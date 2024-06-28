<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binaries
    |--------------------------------------------------------------------------
    |
    | Paths to ffmpeg nad ffprobe binaries
    |
    */

    'binaries' => [
        'ffmpeg'  => env('FFMPEG', 'C:/ffmpeg/bin/ffmpeg'),
        'ffprobe' => env('FFPROBE', 'C:/ffmpeg/bin/ffprobe')
    ]
];
