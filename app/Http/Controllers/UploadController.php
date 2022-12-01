<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class UploadController extends Controller
{
    //dev method
    public function __invoke(UploadRequest $request)
    {

        $validated = $request->validate([
            'file' => ['required',
            Rule::excludeIf(function () use ($request) {
                if ($request->file->getMimeType() == 'text/x-php' || $request->file->getSize() > 20971520) {
                    return true;
                } else return false;
            })],
            'folder' => 'required'
        ]);

        $file = $validated['file'];
        $name = $file->hashName();


        $upload = Storage::put("public/{$name}", $file);
        Media::query()->create(
            attributes: [
                'name' => "{$name}",
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path' => "avatars/{$name}"
                ,
                'disk' => 'app',
                'file_hash' => hash_file(
                    config('app.uploads.hash', 'md5'),
                    storage_path(
                        path: "app/public/{$name}/{$name}",
                    ),
                ),
                'collection' => $request->get('collection'),
                'size' => $file->getSize(),
                'user_id' => Auth::user()->id,
            ],
        );

        return response(200);
    }
}
