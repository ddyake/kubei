<?php

//链接管理



//插入链接
function act_links_insert(&$website){
  $image = $_POST['image']??'';
  $field = array('tid','color','target','tit','href','cont');
  $value = array(
    $_POST['tid'],
    $_POST['color'],
    $_POST['target'],
    $_POST['tit'],
    $_POST['href'],
    $_POST['cont']
  );
  if($image){
    $path = $website['path']['upload']['image'].date('/Ym/d/')
            .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
    if(preg_match('/^http\:/',$image)){ // 外域图片
      $imgData = file_get_contents($image);
      fn_mkdir($path);
      file_put_contents($path, $imgData);
      $image = str_replace($website['path']['root'],'',$path);
      $field[]='image';
      $value[]=$image;
    }elseif(!preg_match('/^\//',$image)){ //上传了新图片
      $tempName = $website['path']['temp'].'/'.$image;
      if(is_file($tempName)){
        fn_mkdir($path);
        rename($tempName,$path);
        $image = str_replace($website['path']['root'],'',$path);
        $field[]='image';
        $value[]=$image;
      }
    }
  }

  $lid = $website['class']['db']
          ->table('links')
          ->field($field)
          ->value($value)
          ->insert();
  return json_encode(array(
      'status'    => 'ok',
      'msg'       => 'links-insert',
      //测试'sql'       => $website['class']['db']->sql,
      'data'      => '链接添加成功!'
  ));
}

//更新链接
function act_links_update(&$website){
  $image = $_POST['image']??'';
  $field = array('color','target','tit','href','cont');
  $value = array(
    $_POST['color'],
    $_POST['target'],
    $_POST['tit'],
    $_POST['href'],
    $_POST['cont']
  );
  if($image){
    $path = $website['path']['upload']['image'].date('/Ym/d/')
            .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
    if(preg_match('/^http\:/',$image)){ // 外域图片
      $imgData = file_get_contents($image);
      fn_mkdir($path);
      file_put_contents($path, $imgData);
      $image = str_replace($website['path']['root'],'',$path);
      $field[]='image';
      $value[]=$image;
    }elseif(!preg_match('/^\//',$image)){ //上传了新图片
      $tempName = $website['path']['temp'].'/'.$image;
      if(is_file($tempName)){
        fn_mkdir($path);
        rename($tempName,$path);
        $image = str_replace($website['path']['root'],'',$path);
        $field[]='image';
        $value[]=$image;
      }
    }
  }

  $num = $website['class']['db']
          ->table('links')
          ->field($field)
          ->value($value)
          ->where('id=?',$_POST['lid'])
          ->limit(1)
          ->update();
  return json_encode(array(
      'status'    => 'ok',
      'msg'       => 'links-update',
      'data'      => $num?'更新成功!':'数据未发生改变!'
  ));
}

//删除链接
function act_links_delete(&$website){
    if(is_numeric($_POST['lid'])){
        $website['class']['db']->table('links')->where('id=?',$_POST['lid'])->delete();
        return json_encode(array(
            'status'    => 'ok',
            'msg'       => 'content-delete',
            'data'      => 'ok'
        ));
    }else{
        return json_encode(array(
            'status'    => 'error',
            'msg'       => 'links-delete',
            'data'      => '未找到编号为 '.$_POST['lid'].' 的数据'
        ));
    }
}

//获取链接内容
function act_links_get(&$website){
    if(is_numeric($_POST['lid'])){
        $arr = $website['class']['db']->table('links')->where('id=?',$_POST['lid'])->one();
        return json_encode(array(
            'status'    => 'ok',
            'msg'       => 'content-delete',
            'data'      => $arr
        ));
    }else{
        return json_encode(array(
            'status'    => 'error',
            'msg'       => 'links-get',
            'data'      => '未找到编号为 '.$_POST['lid'].' 的数据'
        ));
    }
}



function act_links_sort(&$website){
  if(!is_numeric($_POST['sort']) || $_POST['sort'] < 0){
      return array('status'=>'error','data'=>'排序数字必须为正整数');
  }


  $arrs           = $website['class']['db']
                    ->table('links')
                    ->field('tid','sort')
                    ->where('id=?',$_POST['lid'])
                    ->one();

  //$args['db']->select('links',array('sort','tid'),"where `lid`='{$_GET['lid']}' limit 1");
  //$g_where        = "`tid` = '{$arrs[0]['tid']}' and `sort` != '0' and `lid` != '{$_GET['lid']}'";
  $gWhere        = "tid='{$arr['tid']}' and sort !='{$_POST['sort']}' and id!='{$_POST['lid']}'?";
  $count          = $website['class']['db']
                    ->table('links')
                    ->where('tid = ? and sort != ?',$arrs['tid'],0)
                    ->count();


  //判断是否已经是最后一个
  if(!$count){
      $_POST['sort']   = 1;
  }elseif($_POST['sort'] > $count && $website['class']['db']->table('links')->where('id=? and sort!=?',$_POST['lid'],0)->count()){
      $_POST['sort'] = $count;
  }elseif($_POST['sort'] > $count){
      $website['class']['db']
              ->table('links')
              ->field('sort')
              ->value($count+1)
              ->where('lid=?',$_POST['lid'])
              ->update();
      return json_encode(
        array(
            'status'    => 'ok',
            'data'      => '排序成功'
        )
      );
  }

  $website['class']['db']
      ->table('links')
      ->field('sort')
      ->value($_POST['sort'])
      ->where('id=?',$_POST['lid'])
      ->update();
//return json_encode(array('status'=>'ok','data'=>$website['class']['db']->sql.'....'.$_POST['sort']));

  if($_POST['sort'] != $arrs['sort']){//修改排序必须 现有排序数字与原排序数字不同
      if($_POST['sort'] == '0'){
          $order  = 'sort asc';
          $sort   = 1;//排序数字
      }elseif($_POST['sort'] == '1'){
          $order  = 'sort asc';
          $sort   = 2;//排序数字
      }elseif($_POST['sort'] < $arrs[0]['sort']){//上移
          $gWhere.= " and (`sort` >= '{$_POST['sort']}' and `sort` < '{$arrs['sort']}')";
          $sort   = $_POST['sort']+1;
      }elseif($_POST['sort'] > $arrs[0]['sort']){//下移
          $gWhere.= " and (`sort` > '{$arrs['sort']}' and `sort` <= '{$_POST['sort']}')";
          $sort   = $_POST['sort']-1;
      }

      $arrs   = $website['class']['db']
                ->table('links')
                ->field('id')
                ->where($gWhere)
                ->order('sort asc')
                ->select();


      foreach($arrs as $v){
          $website['db']
            ->table('links')
            ->field('sort')
            ->value($sort)
            ->where('id=?',$v['id'])
            ->update();
          $sort++;
      }

  }
  return json_encode(array('status'=>'ok','data'=>'排序成功'));
}
