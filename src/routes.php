<?php

use StreamerPhp\Controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/playlists', [HomeController::class, 'index']],
    ['GET', '/playlist/{titulo}', [HomeController::class, 'playlist']],
    ['GET', '/video/{playlist}/{video}', [HomeController::class, 'video']],
];