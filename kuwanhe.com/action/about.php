<?php

$game = $this->website['class']['db']
     ->table('game')
     ->field('tit','tag','image','about')
     ->where('id=?',$_GET['gid'])
     ->one();
$game['tag'] = explode(',',$game['tag']);

$platform = $this->website['class']['db']
           ->table('game_platform')
           ->field('tit','url')
           ->where('gid=?',$_GET['gid'])
           ->select();


// 游戏介绍页面
$this->website['class']['tpl']
    ->assign('css',array('/css/about.css'))
    ->assign('jss',array('js/note.js'))
    ->assign('tit',$game['tit'])
    ->assign('keywords',$game['tit'])
    ->assign('description',$game['tit'])
    ->assign('game',$game)
    ->assign('platform',$platform)
    ->display('about.tpl');
