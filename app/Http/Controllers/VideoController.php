<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
class VideoController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        
        // $request->validate([
        //     'video' => 'required|mimes:mp4|max:2048', // Validate video format and size
        // ]);

        $path = $request->file('video')->store('videos', 'public');
       
        // Generate video preview
        $previewPath = public_path('previews');

        // Create the previews directory if it doesn't exist
        if (!file_exists($previewPath)) {
            mkdir($previewPath, 0777, true);
        }
        
        
        $videoPath = storage_path('app/public/' . $path);

        $ffmpegPath = 'C:\ffmpeg\bin\ffmpeg.exe'; 
        $timestamp = time();
        $filename = 'preview_' . $timestamp . '.jpg';

        $process = new Process([
            $ffmpegPath,
            '-i',
            $videoPath,
            '-ss',
            '00:00:01',
            '-vframes',
            '1',
            $previewPath . '/' . $filename,
        ]);

        $process->run();

        return redirect()->back()->with('success', 'Video uploaded successfully.');
    }
}
