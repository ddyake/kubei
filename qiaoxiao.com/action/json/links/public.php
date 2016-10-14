<?php
// 移动图片到正确地址  /data/upload/image/年月/日/10位图片名称
function global_img_save_img(&$website,&$image){
  // 重复文件名
  // $noDouble = function(&$image) use(&$website,&$noDouble){
  //   $path = $website['path']['upload']['image'].date('/Ym/d/')
  //           .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
  //   if(is_file($path)){
  //     $noDouble($image);
  //   }else{
  //     return $noDouble($image);
  //   }
  // };
  // $path = $noDouble($image);
  $path = $website['path']['upload']['image'].date('/Ym/d/')
          .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
  $tempName = $website['path']['root'].$image;
  fn_mkdir($path);
  if(is_file($tempName)){
    if(rename($tempName,$path)){
      $image = str_replace($website['path']['root'],'',$path);
      return $image;
    }else{
      $website['class']['log']->error('文件移动错误：源文件-'.$tempName.' 新文件-'.$path);
    }
  }else{
    return false;
  }
}
