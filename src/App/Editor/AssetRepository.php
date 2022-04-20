<?php

namespace LaraEditor\App\Editor;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AssetRepository
{
    private $diskPath;

    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk(config('laraeditor.assets.disk'));
        $this->diskPath = config('laraeditor.assets.path');
    }

    public function getAllMediaLinks()
    {
        return collect($this->disk->allFiles($this->diskPath))
            ->map(fn ($file) => $this->disk->url($file))
            ->toArray();
    }

    public function getUploadUrl()
    {
        return config('laraveleditor.assets.upload-url', route('laraeditor.asset.store'));
    }

    public function getFileManagerUrl()
    {
        return config('laraveleditor.assets.filemanager_url', '/file-manager/');
    }

    public function addAsset(UploadedFile $file)
    {
        /**
         * Check if file is submitted by Image Editor Its name will be blob
         */
        if ( 'blob' ==  $file->getClientOriginalName()){
            $path = $this->disk->putFile($this->diskPath, $file, 'public');
            return $this->disk->url($path);
        }

        $path = $this->disk->putFileAs($this->diskPath, $file, $file->getClientOriginalName(), 'public');
        return $this->disk->url($path);
    }

    public function addAssetFromRequest($assetName = 'file')
    {
        $files = request()->file($assetName);
        if (is_array($files)) {
            $addedFiles = [];
            foreach ($files as $file) {
                $addedFiles = $this->addAsset($file);
            }
            return $addedFiles;
        }

        return [
            $this->addAsset($files)
        ];
    }
}
