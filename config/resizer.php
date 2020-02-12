<?php

return [
    'resizer' => [
        'converters' => [
            'cwebp', 'vips', 'imagick', 'gmagick', 'imagemagick', 'graphicsmagick', 'wpc', 'ewww', 'gd'
        ],
        'convert' => [
            'quality' => 100,
        ],
        'metadata' => 'all',
        'cwebp-metadata' => 'exif',
    ]
];
