<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unload file') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">File</label>
                            <input class="form-control" type="FILE" id="formFile" name="file">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Folder" name="folder">
                                <option selected>Folder</option>
                                @foreach ($folders as $folder)
                                    <option value="{{$folder->id}}">{{$folder->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </form>
                    {{-- <form method="post">
                         @csrf
                         <label for="name">Name of folder:</label>
                         <input type="name" id="name" name="name"><br><br>
                         <input type="submit" value="Submit">
                     </form>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
