@foreach($files as $file)
    <div>
        File {{ $file->file_name }}
        <a href="{{ route('file.download', ['id' => $file->id]) }}">Download</a>
        <a href="{{ route('file.delete', ['id' => $file->id]) }}">Delete</a>
    </div>
@endforeach

