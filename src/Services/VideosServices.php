<?php

namespace StreamerPhp\Services;

class VideosServices
{
    public static function getPastas()
    {
        $dir = '../videos/';
        $pastas = array_diff(scandir($dir), array('..', '.'));
        return $pastas;
    }

    public static function getVideos($pasta)
    {
        $dir = '../videos/' . $pasta;
        $lista = array_diff(scandir($dir), array('..', '.'));
        $videos = [];
        // remove a extensão do nome do arquivo
        foreach ($lista as $key => $video) {
            $videos[$key]['name'] = pathinfo($video, PATHINFO_FILENAME);
            $videos[$key]['extension'] = pathinfo($video, PATHINFO_EXTENSION);
        }
        return $videos;
    }

    public static function getVideo($pasta, $video)
    {
        $dir = "../videos/". $pasta ;
       
        $files = scandir($dir);
        foreach($files as $file){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            if($filename == $video){
                return $dir."/".$file;
            }
        }
        return null;
       
      
    }
}