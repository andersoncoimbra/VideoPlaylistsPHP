<?php

namespace StreamerPhp\Models;

use StreamerPhp\Services\VideosServices;

class Video{

    public $name;
    public $playlist;
    public $extension;
    public $file;

    public function __construct($name, $playlist, $extension)
    {
        $this->name = $name;
        $this->playlist = $playlist;
        $this->extension = $extension;
        $this->file = $this->name . "." . $this->extension;
    }

    public function path()
    {
        $file_path = VideosServices::getVideo($this->playlist, $this->name);
        if (file_exists($file_path)) {
            $stream = fopen($file_path, 'rb');

            $size = filesize($file_path);
            $length = $size;
            $start = 0;
            $end = $size - 1;

            header('Content-type: video/'.$this->extension);
            header("Accept-Ranges: 0-$length");
            if (isset($_SERVER['HTTP_RANGE'])) {
                $c_start = $start;
                $c_end = $end;
                list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
                if (strpos($range, ',') !== false) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                if ($range == '-') {
                    $c_start = $size - substr($range, 1);
                }else{
                    $range = explode('-', $range);
                    $c_start = $range[0];
                    $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
                }
                $c_end = ($c_end > $end) ? $end : $c_end;
                if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                $start = $c_start;
                $end = $c_end;
                $length = $end - $start + 1;
                fseek($stream, $start);
                header('HTTP/1.1 206 Partial Content');
            }
            header("Content-Range: bytes $start-$end/$size");
            header("Content-Length: ".$length);
            $buffer = 1024 * 8;
            while(!feof($stream) && ($p = ftell($stream)) <= $end) {
                if ($p + $buffer > $end) {
                    $buffer = $end - $p + 1;
                }
                set_time_limit(0);
                echo fread($stream, $buffer);
                flush();
            }
            fclose($stream);
        } else {
            // Caso o arquivo não exista, exibe uma mensagem de erro
            echo "O arquivo não existe.";
        }

    }


}