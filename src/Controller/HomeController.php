<?php 

namespace StreamerPhp\Controller;
use StreamerPhp\Models\Playlist;


class HomeController
{
    public function index($params)
    {
       
       $playlists = Playlist::all();
       foreach ($playlists as $playlist) {
           echo "<a href='/playlist/{$playlist->name}'>{$playlist->name}</a><br>";
       }
       
       return $playlists;
    }

    public function playlist($params)
    {
        $playlist = Playlist::find(urldecode($params['titulo']));
        if ($playlist) {
            $videos = $playlist->videos();
            foreach ($videos as $video) {
                echo "<a href='/video/{$playlist->name}/{$video->name}'>{$video->name}</a><br>";
            }
        } else {
            echo "Playlist não encontrada";
        }
    }

    public function video($params)
    {
        $playlist = Playlist::find(urldecode($params['playlist']));
       
        if($video = $playlist->video(urldecode($params['video']))){
           
            $video->path();
        }
       
        
    }
}
?>