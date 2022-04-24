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
        $this->validate($request, [
            'file' => 'required|array',
            'file.*' => 'required|file'
        ]);


        $url = $assetRepository->addAssetFromRequest('file');

        return response()->json([
            'data' => [
                $url
            ]
        ]);
    }

    public function mediaProxy(Request $request)
    {
        try {
            $file = $request->get(config('laraeditor.assets.proxy_url_input'));

            [$url, $isLocal] = $this->replaceLocalUrlToFilePath($file);

            if (!$isLocal) {
                $headers = get_headers($url, true);
            }

            if ($isLocal) {
                $headers = [
                    'Content-Type' => mime_content_type($url),
                    'Content-Length' => filesize($url),
                ];
            }

            header('Content-Description: File Transfer');
            header('Content-Type: ' . (isset($headers['Content-Type']) ? $headers['Content-Type'] : 'application/octet-stream'));
            header('Content-Disposition: inline; filename="' . basename($url) . '"');
            header('Cache-Control: ' . (isset($headers['Cache-Control']) ? $headers['Cache-Control'] : 'must-revalidate'));
            header('Pragma: public');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With");
            if (isset($headers['Content-Length'])) {
                header('Content-Length: ' . $headers['Content-Length']);
            }
            readfile($url);
            exit;

        } catch (\Exception $ex) {
            abort(404,$ex->getMessage());
        }
    }

    private function replaceLocalUrlToFilePath($url)
    {
        $urlParts = parse_url($url);
        if ($urlParts['host'] == 'localhost') {
            return [public_path($urlParts['path']), true];
        }

        return [$url, false];
    }
}
