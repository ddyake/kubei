<?php

$games = $this->website['class']['db']
     ->table('game')
     ->field('id','letter','tit','icon','tag')
     ->limit()
     ->select();





// 游戏库
$this->website['class']['tpl']
    ->assign('css',array('/css/center.css'))
    ->assign('jss',array('js/lazyload.js','js/center.js'))
    ->assign('tit','游戏库')
    ->assign('keywords','游戏库')
    ->assign('description','游戏库')
    ->assign('games',$games)
    ->display('center.tpl');
