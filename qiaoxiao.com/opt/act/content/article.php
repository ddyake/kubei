<?php
// 网站文章相关

// 返回文章内容
function act_article_get(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $aid    = $_GET['aid']??false;
  if(!$aid || !is_numeric($aid)){
    $json['msg'] = 'aid';
    $josn['data']= '未知编号!';
  }else{
    $article = $website['class']['db']
               ->table('article')
               ->field('tid','createtime','click','pg','tag','tit','source','editor','note','image')
               ->where('id=?',$aid)
               ->one();
    $detail = $website['class']['db']
               ->table('article_detail')
               ->field('tits','article')
               ->where('aid=?',$aid)
               ->limit($article['pg'])
               ->order('page asc')
               ->select();
    $arr = [];
    $tits=[];
    foreach($detail as $v){
      $arr[] = $v['article'];
      $tits[]=$v['tits'];
    }
    $article['article'] = implode('<hr/>', $arr);
    $article['tits'] = $tits;
    $json['status'] = 'ok';
    $json['msg']    = 'ok';
    $json['data']   = $article;
  }

  return json_encode($json);
}

// 新建文章
function act_article_insert(&$website){
  $user   = fn_session('optLogin');
  $tit    = $_POST['tit']??false;
  $article= $_POST['article']??false;
  $tid    = $_POST['tid']??false;
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入文章标题';
  }elseif(!$article){
    $json['msg'] = 'article';
    $json['data']= '请输入文章内容';
  }elseif(!$tid){
    $json['msg'] = 'tid';
    $json['data'] = '未选择文章栏目';
  }else{
    // 分页
    $articles = explode('<hr/>',$article);
    //分页标题
    $tits     = json_decode($_POST['tits'],1);
    // 标题简介
    $note   = function() use(&$article){
      if($_POST['nchecked'] == '1'){
        $str = str_replace(
          array(' ','　','\t','\n','\r','&nbsp;'),
          array('','','','','',''),
          strip_tags($article)
        );
        return mb_substr($str,0,100,'utf-8');
      }else{
        return strip_tags($_POST['note']);
      }
    };
    $ctime = function(){
      if(date('Y-m-d') == $_POST['ctime']){
        return $_SERVER['REQUEST_TIME'];
      }elseif(preg_match('/^\d+-\d+-\d+/',$_POST['ctime'])){
        $t = explode('-',$_POST['ctime']);
      }else{
        return $_SERVER['REQUEST_TIME'];
      }
    };
    // 缩略图
    $image = $_POST['image'];
      if($_POST['checked'] == '1'){
        preg_match('/src="([\s\S]*?)"/',$article,$imgs);
        $image = $imgs[1];
      }else{
        $path = $website['path']['upload']['image'].date('/Ym/d/')
                .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
        $tempName = $website['path']['temp'].'/'.$image;
        if(is_file($tempName)){
          rename($tempName,$path);
          $image = str_replace($website['path']['root'],'',$path);
        }
    }

    // 写入数据库
    // 标题表
    $aid = $website['class']['db']
            ->table('article')
            ->field(
              'uid',
              'upid',
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
              strip_tags($_POST['upid']),
              strip_tags($tid),
              $ctime(),
              is_numeric($_POST['click'])?$_POST['click']:1,
              count($articles),
              strip_tags($_POST['tag']),
              strip_tags($tit),
              strip_tags($_POST['source']),
              strip_tags($_POST['editor']),
              $note(),
              $image
            )
            ->insert();
    // $sql = $website['class']['db']->sql;

    if($aid){
      // 内容表
      foreach($articles as $k=>$v){
        $website['class']['db']
                ->table('article_detail')
                ->field('aid','page','tits','article')
                ->value($aid,$k+1,isset($tits[$k]) ? $tits[$k] : '' ,$v)
                ->insert();
      }
      $json['status'] = 'ok';
      $json['msg'] = 'ok';
      $json['data']='更新成功!';

      $domainM = 'm.qiaoxiao.com';
      $domainW = 'www.qiaoxiao.com';
      $urlsM = ['http://'.$domainM.fn_url('/act.php?act=article&aid='.$aid)];
      $urlsW = ['http://'.$domainW.fn_url('/act.php?act=article&aid='.$aid)];

      $website['class']['log']->write(fn_baidu_push($domainM,$urlsM),'百度链接推送:');
      $website['class']['log']->write(fn_baidu_push($domainW,$urlsW),'百度链接推送:');

    }else{
      $json['msg']='database';
      $json['data']='数据库写入失败!'.$sql;
    }
  }

  return json_encode($json);
}

// 修改文章
function act_article_update(&$website){
  $user   = fn_session('optLogin');
  $tit    = $_POST['tit']??false;
  $article= $_POST['article']??false;
  $tid    = $_POST['tid']??false;
  $image = $_POST['image']??false;
  $aid   = $_POST['aid']??false;
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入文章标题';
  }elseif(!$article){
    $json['msg'] = 'article';
    $json['data']= '请输入文章内容';
  }elseif(!$tid){
    $json['msg'] = 'tid';
    $json['data'] = '未选择文章栏目';
  }elseif(!$aid || !is_numeric($aid)){
    $json['msg'] = 'aid';
    $json['data'] = '未知文章编号!';
  }else{

    $tbArticle = $website['class']['db']
                 ->table('article')
                 ->where('id=?',$aid)
                 ->one();
    // 分页
    $articles = explode('<hr/>',$article);
    //分页标题
    $tits     = json_decode($_POST['tits'],1);
    // 标题简介
    $note   = function() use(&$article){
      if($_POST['nchecked'] == '1'){
        $str = str_replace(
          array(' ','　','\t','\n','\r','&nbsp;'),
          array('','','','','',''),
          strip_tags($article)
        );
        return mb_substr($str,0,100,'utf-8');
      }else{
        return strip_tags($_POST['note']);
      }
    };
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

    if(!$tbArticle['image'] || $image != $tbArticle['image']){
      // 自动获取缩略图
      if($_POST['checked'] == '1'){
        if(preg_match('/src="([\s\S]*?)"/',$article,$imgs)){
          $image = $imgs[1];
        }else{
          $image='';
        }
      }else{
        if($image){
          $path = $website['path']['upload']['image'].date('/Ym/d/')
                  .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
          $tempName = $website['path']['temp'].'/'.$image;
          if(is_file($tempName)){
            rename($tempName,$path);
            $image = str_replace($website['path']['root'],'',$path);
          }
        }else{
          $image = '';
        }
      }
    }
    // 更新数据库
    // 标题表
    $website['class']['db']
            ->table('article')
            ->field(
              'uid',
              'upid',
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
              strip_tags($_POST['upid']),
              strip_tags($tid),
              $ctime(),
              is_numeric($_POST['click'])?$_POST['click']:1,
              count($articles),
              strip_tags($_POST['tag']),
              strip_tags($tit),
              strip_tags($_POST['source']),
              strip_tags($_POST['editor']),
              $note(),
              $image
            )
            ->where('id=?',$aid)
            ->limit(1)
            ->update();
    // 内容表
    $count =  $website['class']['db']
                 ->table('article_detail')
                 ->where('aid=?',$aid)
                 ->count();

    if(count($articles) != $count){
      $website['class']['db']
        ->table('article_detail')
        ->where('aid=?',$aid)
        ->limit($count)
        ->delete();
      // $json['sql'] = $website['class']['db']->sql;
      foreach($articles as $k=>$v){
        $website['class']['db']
                ->table('article_detail')
                ->field('aid','page','tits','article')
                ->value($aid,$k+1,isset($tits[$k]) ? $tits[$k]: '' ,$v)
                ->insert();
      }
    }else{
      foreach($articles as $k=>$v){
        $website['class']['db']
                ->table('article_detail')
                ->field('aid','tits','article')
                ->value($aid,isset($tits[$k]) ? $tits[$k]: '' ,$v)
                ->where('aid=? and page=?',$aid,$k+1)
                ->limit(1)
                ->update();
      }
    }
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data']='更新成功!';

  }

  return json_encode($json);
}

// 删除文章
function act_article_delete(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $aid    = $_GET['aid']??false;
  if(!$aid || !is_numeric($aid)){
    $json['msg'] = 'aid';
    $json['data']= '未知文章编号!';
  }elseif(!$website['class']['db']
           ->table('article')
           ->where('id=?',$aid)
           ->count()){
    $json['msg'] = 'count';
    $json['data']= '找不到文章，或者已被删除!';
  }else{
    $website['class']['db']
             ->table('article')
             ->where('id=?',$aid)
             ->limit(1)
             ->delete();
    $website['class']['db']
              ->table('article_detail')
              ->where('aid=?',$aid)
              ->delete();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '删除成功!';
  }

  return json_encode($json);
}
