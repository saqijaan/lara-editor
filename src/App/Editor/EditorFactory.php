<?php

namespace LaraEditor\App\Editor;

use LaraEditor\App\Contracts\Editable;

class EditorFactory extends EditorBaseClass
{
    public function initialize(Editable $editable)
    {
        $assetRepository = app(AssetRepository::class);
        $editorCanvas = new EditorCanvas;
        $editorCanvas->styles = array_merge(
            config('laraeditor.styles'),
            $editable->getStyleSheetLinks()
        );

        $editorCanvas->scripts = array_merge(
            config('laraeditor.scripts'),
            $editable->getScriptLinks()
        );

        $editorStorage = new EditorStorageManager;
        $editorStorage->type = 'remote';
        $editorStorage->urlStore = $editable->getEditorStoreUrl();
        $editorStorage->params = [
            '_token' => csrf_token()
        ];

        $editorAssetManager = new EditorAssetManager;
        $editorAssetManager->assets = $assetRepository->getAllMediaLinks();
        $editorAssetManager->upload = $assetRepository->getUploadUrl();
        $editorAssetManager->headers = [
            '_token' => csrf_token()
        ];

        $editorAssetManager->uploadName = 'file';
        $editorConfig = new EditorConfig;
        $editorConfig->components = $editable->getComponents();
        $editorConfig->style = $editable->getStyles();
        $editorConfig->canvas = $editorCanvas;
        $editorConfig->assetManager = $editorAssetManager;
        $editorConfig->storageManager = $editorStorage;
        $editorConfig->forceClass = config('laraeditor.force_class', true);
        $editorConfig->avoidInlineStyle = false;
        $editorConfig->templatesUrl = $editable->getEditorTemplatesUrl();
        $editorConfig->assetStoreUrl = $assetRepository->getUploadUrl();
        $editorConfig->filemanagerUrl = $assetRepository->getFileManagerUrl();
        $editorConfig->_token = csrf_token();
        return $editorConfig;
    }
}
