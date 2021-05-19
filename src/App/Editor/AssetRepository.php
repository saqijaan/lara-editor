<?php

namespace LaraEditor\App\Editor;

use Illuminate\Http\Request;
use Modules\Media\Models\TempMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AssetRepository
{
    public function getAllMediaLinks()
    {
        $allStoredMedia = Media::all()->map(function($media){
            return route('laraeditor.media.show', $media);
        });

        return $allStoredMedia->toArray();
    }

    public function getUploadUrl(){
    	return config('laraveleditor.assets.upload-url',route('laraeditor.editor.asset.store'));
    }
}