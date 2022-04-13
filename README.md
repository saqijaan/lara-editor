# lara-editor

install via composer.

`composer require starsoft/laravel-editor`

To Get Start with LaraEditor Follow steps below

1. Add 'gjs_data' Column to model you are going to use with Editor.

2. Implement Editable Interface to Model class

3. add Editable trait to model class

4. Implement Required methods in model and create 2 routes to load and store editor content
5. create a *EditorContentController* controller and add following methods

```
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Page $page)
    {
        return $page->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, Page $page)
    {
        return $page->saveEditorData($request);

    }

    public function templates(Page $page)
    {
       return array_merge(
           $page->getTemplatesFromPath(config('cms.templatesPath')),
           $page->getBlocksFromPath(config('cms.blocksPath')),
        );
    }
```

7. create following routes

```
Route::get('page-customize/{page}', [PageEditorController::class, 'index'])->name('page-customize.index');
Route::post('page-customize/{page}', [PageEditorController::class, 'store'])->name('page-customize.store');
Route::get('page-customize/{page}/templates', [PageEditorController::class, 'templates'])->name('page-customize.templates');
```

8. publish & run migration files

```
php artisan vendor:publish --provider="LaraEditor\LaraEditorServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate

```
