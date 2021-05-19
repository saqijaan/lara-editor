<?php

namespace LaraEditor\App\Traits;

use Illuminate\Http\Request;
use LaraEditor\App\Editor\EditorFactory;

trait EditableTrait
{
    public $placeholders = [];

    public function setGjsDataAttribute($value)
    {
        $this->attributes['gjs_data'] = json_encode($value);
    }

    public function getGjsDataAttribute($value): array
    {
        return json_decode($value, true) ?? [];
    }

    public function getHtml(): string
    {
        if (!$this->html) {
            return '';
        }

        return $this->replacePlaceholders();
    }

    public function getCss(): string
    {
        return json_decode(optional($this->gjs_data)['css'] ?? '[]');
    }

    public function getComponents(): array
    {
        return json_decode(optional($this->gjs_data)['components'] ?? '[]');
    }

    public function getStyles(): array
    {
        return json_decode(optional($this->gjs_data)['styles'] ?? '[]');
    }

    public function getStyleSheetLinks(): array
    {
        return json_decode(optional($this->gjs_data)['stylesheets'] ?? '[]');
    }

    public function getScriptLinks(): array
    {
        return json_decode(optional($this->gjs_data)['scripts'] ?? '[]');
    }

    public function getAssets(): array
    {
        return [];
    }

    public function setPlaceholder($placeolder, $content)
    {
        $this->placeholders[$placeolder] = $content;

        return $this;
    }

    private function replacePlaceholders()
    {
        $processedContent = $this->html;
        foreach ($this->getPlaceholders() as $placeolder => $replaceContent) {
            $processedContent = str_replace($placeolder, $replaceContent, $processedContent);
        }

        return $processedContent;
    }

    public function saveEditorData(Request $request)
    {
        $this->gjs_data = [
	        'components' => $request->get('laravel-editor-components'),
	        'styles' => $request->get('laravel-editor-styles'),
	        'css' => $request->get('laravel-editor-css'),
	        'html' => $request->get('laravel-editor-html'),
	    ];

        $this->save();

	    return response()->noContent(200);
    }

    public function getEditor()
    {
        $factory = new EditorFactory;
		$editorConfig = $factory->initialize($this);
		return view('laraeditor::editor', compact($this,'editorConfig'));
    }
}
