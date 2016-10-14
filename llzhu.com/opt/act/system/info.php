<?php
//获取系统信息
function act_info_get(&$website){
    if(php_uname('s') !== 'Linux'){
      return json_encode(array(
          'status'    => 'error',
          'msg'       => 'info-get',
          'data'      => '不支持非Linux系统'
      ));
    }
    //操作系统信息
    $option = explode(' ',php_uname());
    //CPU信息
    exec('cat /proc/cpuinfo',$cpu);
    //内存信息
    exec('cat /proc/meminfo',$memory);
    //磁盘使用情况
    $hard = array();
    $pars = array_filter(explode("\n",`df -h`));
    foreach ($pars as $par) {
        if ($par{0} == '/') {
            $_tmp = array_values(array_filter(explode(' ',$par)));
            reset($_tmp);
            array_push($hard,"分区挂载点:{$_tmp['5']},总大小:{$_tmp['1']},已使用:{$_tmp['2']}({$_tmp['4']})");
        }
    }
    //CPU使用率
    $cpuUsed    = array();
    $str        = shell_exec('more /proc/stat');
    $pattern    = "/(cpu[0-9]?)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/";
    preg_match_all($pattern, $str, $out);

    for($n=0;$n<count($out[1]);$n++){
       $cpuUsed[] = $out[1][$n].":".(100*($out[1][$n]+$out[2][$n]+$out[3][$n])/($out[4][$n]+$out[5][$n]+$out[6][$n]+$out[7][$n]));
    }
    return json_encode(array(
        'status'    => 'ok',
        'msg'       => 'info-get',
        'data'      => array(
            'cpu'       => array($cpu[4],$cpu[7],$cpu[8],$cpu[12],$cpu[21],$cpu[23]),
            'cpuUsed'   => $cpuUsed,
            'opt'       => $option,
            'memory'    => $memory,
            'hard'      => $hard
        )
    ));
}
