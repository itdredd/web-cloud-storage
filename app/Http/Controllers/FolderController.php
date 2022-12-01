<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $folder = new Folder();
            $folder->name = $name;
            $folder->user_id = Auth::user()->id;
            $folder->path = storage_path("app/public/{$name}");
            $folder->save();

            return redirect()->route('folder.list');
        }
        return view('folder/create');
    }

    public function list()  {
        $folders = Folder::where('user_id', Auth::user()->id)->get();
        $files = Media::where('user_id', Auth::user()->id)->get();

        return view('folder/list', compact('folders', 'files'));
    }

    public function show(Folder $folder) {
        if($folder) {
            $files = Media::where([['user_id', Auth::user()->id], ['folder_id', $folder->id]])->get();
            return view('folder/show', compact('files'));
        }
        return redirect()->route('folder.list');
    }
}
