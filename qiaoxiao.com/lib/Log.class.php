<?php
// 日志函数
class Log{
  var $website;

  //初始化
  function __construct(&$website){
      $this->website  = $website;
      if(!is_dir($this->website['log']['path'])){
        if(!mkdir($this->website['log']['path'])){
          echo '日志文件夹创建失败,请检查文件夹权限!';
          exit();
        }
      }
  }

  // 返回日志文件名称  1.log
  // 规则根据文件个 判断当前日志大小，超过最大值就新建日志文件
  private function name(){
     $dh = opendir($this->website['log']['path']);
     $num= 0;
     while(($file=readdir($dh)) !== false){
       if($file != '.' && $file != '..'){
         $num+=1;
       }
     }
     $num   = $num?$num:1;
     $file  = $this->website['log']['path'].'/'.$num.'.log';

     if(is_file($file)){
       $size = filesize($file);
       if($size > $this->website['log']['size']){
         $file = $this->website['log']['path'].'/'.($num+1).'.log';
       }
     }else{
       if(!file_put_contents($file,'')){
         echo '<b style="color:#fff">写入日志文件错误,请检查文件夹权限或磁盘容量!</b>';
         return 0;
       }
     }
     return $file;
  }

  // 写入日志
  public function write($txt,$status='WARNING'){
    $file = $this->name();
    $txt  = $status.':'.date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).$txt."\r\n";
    if($file){
      if (!file_put_contents($file,$txt,FILE_APPEND)) {
        return '写入日志文件错误,请检查日志文件夹权限或磁盘容量!';
      }
    }
  }

  // 警告日志
  public function warning($txt){
    $this->write($txt,$status='WARNING');
  }

  // 错误日志
  public function error($txt){
    $this->write($txt,$status='ERROR');
  }


}
