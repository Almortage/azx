<?php
/**
 * Created by PhpStorm.
 * User: mhmd
 * Date: 3/26/2020
 * Time: 9:20 PM
 */
require_once("init.php");
$reader = get('reader',FILTER_SANITIZE_STRING);
if(isset($reader) && is_dir('Voice/'.$reader)){
    $files = scandir('Voice/'.$reader);
        foreach ($files as $file) {
            $filename = 'Voice/'.$reader."/".$file;
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array($ext, ['wav', 'mp3'])) {
                $rows[] = $filename;
            }
            
        }
    $handle = fopen('Voice/'.$reader."/info.txt", "r");
    $name = fread($handle, filesize($filename));
    fclose($handle);
    echo $twig->render('main.twig',array('sounds'=>$rows,'name'=>$name,'dir'=>'Voice/'.$reader));
}else{
    $directories = glob('Voice/*' , GLOB_ONLYDIR);
    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $i=0;
    foreach ($directories as $dir) {
        $files = scandir($dir);
        foreach ($files as $file) {
            $filename = $dir."/".$file;
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array($ext, ['txt', 'jpg'])) {
                if ($file == 'img.jpg' or $file == 'img.png') {
                    $rows[$i]['image'] = $filename;
                }
                if ($file == 'info.txt') {
                    $handle = fopen($filename, "r");
                    $rows[$i]['name'] = fread($handle, filesize($filename));
                    fclose($handle);
                }
            }
            if (in_array($ext, ['wav', 'mp3'])) {
                    $rows[$i]['audio'] = $filename;
            }

            $rows[$i]['path'] = basename($dir);
        }
        $i++;
    }
    echo $twig->render('main.twig',array('readers'=>$rows,'URL'=>$actual_link));
}

