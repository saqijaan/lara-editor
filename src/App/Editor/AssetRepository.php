<?php

namespace LaraEditor\App\Editor;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AssetRepository
{
    public function getAllMediaLinks()
    {
        return [];
    }

    public function getUploadUrl(){
    	return config('laraveleditor.assets.upload-url',route('laraeditor.editor.asset.store'));
    }
}