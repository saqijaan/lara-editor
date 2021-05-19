<?php

namespace LaraEditor\App\Contracts;

interface Editable
{
    public function setGjsDataAttribute($value);
    public function getGjsDataAttribute($value): array;

    public function getHtml(): array | string;
    public function getCss(): array | string;

    public function getComponents(): array | string;
    public function getStyles(): array | string;

    public function getStyleSheetLinks(): array;
    public function getScriptLinks(): array;
    public function getAssets(): array;

    public function getEditorStoreUrl(): string | null;
    public function getEditorLoadUrl(): string | null;
    public function getEditorTemplatesUrl(): string | null;
}
