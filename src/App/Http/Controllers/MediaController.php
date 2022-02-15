<?php

namespace LaraEditor\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaraEditor\App\Models\TempMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    use ValidatesRequests;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|image|max:'.config('media-library.max_file_size', 2048)
        ]);

        $mediaStored = TempMedia::create()->addMediaFromRequest('file')->toMediaCollection('temporary');

        if ( $request->has('accept_only_id') ){
            return $mediaStored->model->id;
        }

        return [
            "location" => route('grapesjs.media.show', $mediaStored->id),
            'temp_id' => $mediaStored->model->id,
            'media_id' => $mediaStored->id,
            'media_url' => route('grapesjs.media.show', $mediaStored->id)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Media $media
     * @return \Illuminate\Http\Response
     */
    public function show($media)
    {
        $media = Media::findOrFail($media);
        return response()->download($media->getPath(), $media->file_name, [], 'inline');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Media $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    protected function response($success=true, $message='', $data=[],  $code=200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Media $media
     * @return \Illuminate\Http\Response
     */
    public function destroy($media)
    {
        $media = Media::findOrFail($media);
        $media->delete();
        return $this->response(true, "File Deleted");
    }

    /**
     * @param TempMedia|null $media
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeTemp(Request $request)
    {
        $payload = json_decode($request->getContent());

        if ( !$payload instanceof \stdClass || !$payload->temp_id ){
            return $this->response(false, "file Not found", [], 404);
        }

        $tempMedia = TempMedia::find($payload->temp_id);

        if ( !$tempMedia ){
            return $this->response(false, "file Not found", [], 404);
        }

        $tempMedia->delete();
        return $this->response(true, "File Deleted");
    }
}
