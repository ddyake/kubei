<?php
// 图片内容

// 查询图片文章
function act_image_select(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $aid  = $_GET['aid']??false;
  if(!$aid){
    $json['msg'] = 'aid';
    $json['data']= '文章编号为空!';
  }elseif(!$website['class']['db']
            ->table('article')
            ->where('id=?',$aid)
            ->count()){
    $json['msg'] = 'aid';
    $json['data']= '文章不存在(或已被删除)!';
  }else{
    $json['data'] = $website['class']['db']
              ->table('article')
              ->where('id=?',$aid)
              ->one();
    $json['data']['img'] = $website['class']['db']
                      ->table('article_image')
                      ->field('img')
                      ->where('aid=?',$aid)
                      ->order('page asc')
                      ->select();
    $json['msg'] = 'ok';
    $json['status'] = 'ok';
  }

  return json_encode($json);

}

// 插入图片文章
function act_image_insert(&$website){
  $user   = fn_session('optLogin');
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $tit    = $_POST['tit']??false;
  $imgs   = json_decode($_POST['imgs'],1);
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入图片标题!';
  }elseif(!$imgs){
    $json['msg'] = 'imgs';
    $json['data']= '未上传内容图片!';
  }else{
    $ctime = function(){
      if(date('Y-m-d') == $_POST['ctime']){
        return $_SERVER['REQUEST_TIME'];
      }elseif(preg_match('/^\d+-\d+-\d+/',$_POST['ctime'])){
        $t = explode('-',$_POST['ctime']);
      }else{
        return $_SERVER['REQUEST_TIME'];
      }
    };

    //内容图片
    $err = [];
    $images=[];
    foreach($imgs as $k=>$v){
      if(!($image = global_img_save_img($website,$v))){
        $err[] = $k;
      }else{
        $images[] = $image;
      }
    }
    if(!count($images)){
      $json['msg'] = 'image';
      $json['data']= '未上传任何图片!';
      return json_encode($json);
    }
    // 缩略图
    $image = $_POST['image'];
    if($_POST['checked'] == '1'){
      $image = $images[0];
    }elseif($image){
      $image = global_img_save_img($website,$_POST['image']);
    }else{
      $json['msg'] = 'image';
      $json['data']= '未上传缩略图或未选择自动提取!';
      return json_encode($json);
    }

    // 写入标题表
    $aid = $website['class']['db']
           ->table('article')
           ->field(
             'uid',
             'tid',
             'createtime',
             'click',
             'pg',
             'tag',
             'tit',
             'source',
             'editor',
             'note',
             'image'
           )
           ->value(
             $user['id'],
             strip_tags($_POST['tid']),
             $ctime(),
             is_numeric($_POST['click'])?$_POST['click']:1,
             count($images),
             strip_tags($_POST['tag']),
             strip_tags($tit),
             strip_tags($_POST['source']),
             strip_tags($_POST['editor']),
             strip_tags($_POST['note']),
             $image
           )
           ->insert();

    // 写入内容表
    foreach($images as $k=>$v){
      $website['class']['db']
        ->table('article_image')
        ->field('uid','aid','page','img')
        ->value($user['id'],$aid,$k+1,$v)
        ->insert();
    }
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '图片数据插入成功!';
    $json['sql'] = $sql;
  }
  return json_encode($json);
}

// 更新图片文章
function act_image_update(&$website){
  $user   = fn_session('optLogin');
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $tit    = $_POST['tit']??false;
  $imgs   = json_decode($_POST['imgs'],1);
  $aid    = $_POST['aid']??0;
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入图片标题!';
  }elseif(!$imgs){
    $json['msg'] = 'imgs';
    $json['data']= '未上传内容图片!';
  }elseif(!$aid){
    $json['msg'] = 'pid';
    $json['data']= '错误的图片文章编号!';
  }elseif(!$website['class']['db']
               ->table('article')
               ->where('id=?',$aid)
               ->count()){
    $json['msg'] = 'pid';
    $json['data']= '未找到图片文章编号!';
  }else{
    $tbArticle = $website['class']['db']
                 ->table('article')
                 ->where('id=?',$aid)
                 ->one();
    $ctime = function() use(&$tbArticle){
      if(date('Y-m-d',$tbArticle['createtime']) == $_POST['time']){
        return $tbArticle['createtime'];
      }elseif(preg_match('/^\d+\-\d+\-\d+/',$_POST['time'])){
        $t = explode('-',$_POST['time']);
        return mktime(0, 0, 0, $t[1], $t[2], $t[0]);
      }else{
        return $_SERVER['REQUEST_TIME'];
      }
    };
    //内容图片
    $err = [];
    $images=[];
    foreach($imgs as $k=>$v){
      $tmpPath = str_replace($website['path']['root'],'',$website['path']['tmp']);
      if(!strpos($v,$tmpPath)){//未改变
        $images[] = $v;
      }elseif(!($img = global_img_save_img($website,$v))){
        $err[] = $k;
      }else{
        $images[] = $img;
      }
    }
    if(!count($images)){
      $json['msg'] = 'image';
      $json['data']= '上传图片发生错误!'.print_r($err,1);
      return json_encode($json);
    }
    $tbImage = $website['class']['db']
                 ->table('article_image')
                 ->field('id')
                 ->where('aid=?',$aid)
                 ->select();
    $image = $_POST['image'] ?? false;
    if(!$tbArticle['image'] || $image != $tbArticle['image']){
      // 自动获取缩略图
      if($_POST['checked'] == '1'){
        $image = $images[0];
      }else{
        if($image){
          $image = global_img_save_img($website,$image);
        }else{
          $image = '';
        }
      }
    }

    // 更新标题表
    $website['class']['db']
        ->table('article')
        ->field('uid','tid','createtime','click','pg','tag','tit','source','editor','note','image')
        ->value(
          $user['id'],
          strip_tags($_POST['tid']),
          $ctime(),
          strip_tags($_POST['click']),
          count($images),
          strip_tags($_POST['tag']),
          strip_tags($_POST['tit']),
          strip_tags($_POST['source']),
          strip_tags($_POST['editor']),
          strip_tags($_POST['note']),
          $image
        )
        ->where('id=?',$aid)
        ->update();
    // 更新内容表
    if(count($tbImage) != count($images)){
      $website['class']['db']
        ->table('article_image')
        ->where('aid=?',$aid)
        ->delete();
      foreach($images as $k=>$v){
        $website['class']['db']
          ->table('article_image')
          ->field('uid','aid','page','img')
          ->value($user['id'],$aid,$k+1,$v)
          ->insert();
      }
    }else{
      foreach($tbImage as $k=>$v){
        $website['class']['db']
          ->table('article_image')
          ->field('uid','img')
          ->value($user['id'],$images[$k])
          ->where('id=?',$v['id'])
          ->update();
      }

    }
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '更新成功!'.$sql;
  }
  return json_encode($json);

}


// 删除图片文章
function act_image_delete(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $aid  = $_GET['aid']??false;
  if(!$aid){
    $json['msg'] = 'aid';
    $json['data']= '文章编号为空!';
  }elseif(!$website['class']['db']
            ->table('article')
            ->where('id=?',$aid)
            ->count()){
    $json['msg'] = 'aid';
    $json['data']= '文章不存在(或已被删除)!';
  }else{
    $article = $website['class']['db']
              ->table('article')
              ->field('image')
              ->where('id=?',$aid)
              ->one();
    $image = $website['path']['root'].$article['image'];
    if(is_file($image)){unlink($image);}
    $website['class']['db']
              ->table('article')
              ->where('id=?',$aid)
              ->delete();
    $detail = $website['class']['db']
              ->table('article_image')
              ->field('img')
              ->where('aid=?',$aid)
              ->select();
    foreach($detail as $v){
      $img = $website['path']['root'].$v['image'];
      if(is_file($img)){unlink($img);}
    }
    $website['class']['db']
              ->table('article_image')
              ->where('id=?',$aid)
              ->delete();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data']= '图片文章删除成功!';
  }


  return json_encode($json);
}
