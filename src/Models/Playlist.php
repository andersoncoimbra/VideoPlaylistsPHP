<?php
namespace StreamerPhp\Models;

use StreamerPhp\Services\VideosServices;

class Playlist
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function all(): array
    {
        $pastas = VideosServices::getPastas();
        $playlists = [];
       //cria um array de playlists
        foreach ($pastas as $playlist) {
            $playlist = new self($playlist);
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public static function find($name)
    {
        $playlists = self::all();
        foreach ($playlists as $playlist) {
            if ($playlist->name == $name) {
                return $playlist;
            }
        }
        return null;
    }

    public function videos(): array
    {
        $listagem = VideosServices::getVideos($this->name);
        $videos = [];
        foreach ($listagem as $key => $video) {
            $videos[$key] = new Video($video['name'], $this->name, $video['extension']);
        }
        
        return $videos;
    }

    public function video($name)
    {
        $videos = $this->videos();
        foreach ($videos as $video) {           
            if ($video->name == $name) {
                return $video;
            }
        }
        return null;
    }


}