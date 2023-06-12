<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="video" accept="video/mp4">
        <button type="submit">Upload</button>
    </form>

    @php
        $previewPath = public_path('previews');
        $previewFiles = File::files($previewPath);
    @endphp

    @if(count($previewFiles) > 0)
        <div>
            <h2>Video Previews:</h2>
            <ul>
                @foreach ($previewFiles as $file)
                    <li>
                        <img src="{{ asset('previews/' . $file->getFilename()) }}" alt="Video Preview" style="max-width: 200px; max-height: 200px;">
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
