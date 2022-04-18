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
    public function store(Request $request, AssetRepository $assetRepository)
    {
        $this->validate($request,[
            'file' => 'required|file'
        ]);

        $url = $assetRepository->addAsset($request->file('file'));

        return response()->json([
            'data' => [
                $url
            ]
        ]);
    }
}
