<?php 

return [
    'styles' => [],
    'scripts' => [],

    'assets' => [
        'upload-url' => null,
        'disk' => env('FILESYSTEM_DISK', 'local'),
        'path' => 'editor/media',
        'filemanager_url' => '/file-manager/',
        'editor_icons' => asset('/vendor/laravel-editor/svg')
    ]
];