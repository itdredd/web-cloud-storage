<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    public function upload(Request $request) {
        if($request->isMethod('POST')) {
            $size = 0;
            $files = Media::where('user_id', Auth::user()->id)->get();

            foreach ($files as $file) {
                $size+=$file->size;
            }

            if($size > 104857600)
                return 'size off';

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
            $folder = Folder::find($validated['folder']);


            $upload = Storage::put("public/{$folder->name}/{$name}", $file);
            Media::query()->create(
                attributes: [
                    'name' => "{$name}",
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'path' => "public/{$folder->name}/{$name}"
                    ,
                    'disk' => 'app',
                    'file_hash' => hash_file(
                        config('app.uploads.hash', 'md5'),
                        storage_path(
                            path: "app/public/{$folder->name}/{$name}/{$name}",
                        ),
                    ),
                    'collection' => $request->get('collection'),
                    'size' => $file->getSize(),
                    'user_id' => Auth::user()->id,
                    'folder_id' => $folder->id,
                ],
            );

            return response(200);
        }

        $folders = Folder::where('user_id', Auth::user()->id)->get();

        return view('file.upload', compact('folders'));
    }

    public function download(Media $id) {
        return Storage::download($id->path . '/'. $id->name);
    }

    public function delete(Media $id){
        Storage::delete($id->path . '/'. $id->name);
        $id->delete();
        return back();
    }

    public function rename(Media $id, Request $request) {
        if($request->isMethod('post')) {
            Storage::move($id->path . '/'. $id->name, $id->path . '/'. $request->input('name'));
            $id->name = $request->input('name');
            $id->file_name = $request->input('name');
            $id->save();
            return back();
        }
        return view('file.rename');
    }
}
