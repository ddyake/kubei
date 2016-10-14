<?php
//分页
function act_global_paging(&$website){

    $data   = $website['class']['db']
                ->table(is_string($_POST['tb'])? $_POST['tb'] : '')
                ->field(explode(',',is_string($_POST['fields'])? $_POST['fields'] : ''))
                ->where(is_string($_POST['where'])? $_POST['where'] : '')
                ->order(is_string($_POST['order'])? $_POST['order'] : '')
                ->num(is_numeric($_POST['num'])? $_POST['num'] : 10)
                ->page(is_numeric($_POST['page'])? $_POST['page'] : 1)//当前显示页数
                ->paging();

    return json_encode(array(
        'status'    => 'ok',
        'msg'       => 'paging',
        //检测使用'sql'       => $website['class']['db']->sql,
        'data'      => $data
    ));
}
