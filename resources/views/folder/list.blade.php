@foreach($files as $file)
    <div>
        File {{ $file->file_name }}
        <a href="{{ route('file.download', ['id' => $file->id]) }}">Download</a>
        <a href="{{ route('file.delete', ['id' => $file->id]) }}">Delete</a>
        <a href="{{ route('file.rename', ['id' => $file->id]) }}">Rename</a>
    </div>
@endforeach
@foreach($folders as $folder)
    <div>
        Folder <a href="{{ route('folder.show', ['folder' => $folder->id]) }}">{{ $folder->name }} </a>
    </div>
@endforeach
