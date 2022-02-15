<?php

namespace LaraEditor\App\Http\Controllers;

use LaraEditor\App\Models\TempMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaraEditor\App\Editor\AssetRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AssetController extends Controller
{
    use ValidatesRequests;

    public function index(AssetRepository $assetRepository)
    {
        return response()->json(
            $assetRepository->getAllMediaLinks()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'file' => 'bail|required|array|min:1',
            'file.*' => 'bail|required|max:'.config('media-library.max_file_size', 2048)
        ]);

        $media = TempMedia::create()->addMediaFromRequest('file')->toMediaCollection('default');
        return response()->json([
            'data' => [
                route('laraeditor.media.show', $media)
            ]
        ]);
    }
}
