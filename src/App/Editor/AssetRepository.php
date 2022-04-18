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
        return $this->disk->allFiles($this->diskPath);
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
        $path = $this->disk->putFileAs($this->diskPath, $file, $file->getClientOriginalName(), 'public');
        return $this->disk->url($path);
    }
}
