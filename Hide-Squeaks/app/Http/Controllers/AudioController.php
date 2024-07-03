<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage; // Add this line

use Illuminate\Http\Request;
use App\Models\Audio;
// use VideoThumbnail;
use Str;
use Symfony\Component\HttpFoundation\Response; // Make sure to import Response
use Pawlox\VideoThumbnail\VideoThumbnail;
use FFMpeg;
use FFMpeg\Coordinate\TimeCode;
class AudioController extends Controller
{
    public function formVideo(){
        return  view('pages.apps.testing.index');
    }

    public function postVedio(Request $request){
        // if ($request->hasFile('video')) {
        //     $video = $request->file('video');
        //     $img = Str::random(20) . $video->getClientOriginalName();

        //     // Move the uploaded video to a location
        //     $video->move(public_path('documents/profile-testing'), $img);

        //     // Generate Thumbnail
        //     $thumbnailPath = public_path('documents/thumbs/');
        //     $thumbnailName = Str::random(20).'.jpeg';
        //     $videoPath = public_path("documents/profile-testing/{$img}");
        //     $videoThumbnail = new VideoThumbnail();
        //     try {
        //         $videoThumbnail->createThumbnail(
        //             $videoPath,
        //             $thumbnailPath,
        //             $thumbnailName,
        //             2,

        //         );
        //         return new Response('Thumbnail generated successfully');
        //     } catch (\Exception $e) {
        //         return new Response('Error generating thumbnail: ' . $e->getMessage(), 500);
        //     }
        // }

        // return new Response('No video file provided', 400);
        $video = $request->file('video');

        // Save the video to the storage disk
        return $videoPath = $video->store('videos', 'public');

        // Generate thumbnail
        $thumbnailPath = $this->generateThumbnail($videoPath);

        // Save video details to the database if needed

        return response()->json(['video_path' => $videoPath, 'thumbnail_path' => $thumbnailPath]);
    }
    private function generateThumbnail($videoPath)
    {
        dd($videoPath);
        $thumbnailPath = 'thumbnails/' . pathinfo($videoPath, PATHINFO_FILENAME) . '.jpg';
        FFMpeg::fromDisk('public')
            ->open($videoPath)
            ->getFrameFromSeconds(1) // Adjust the time (in seconds) to capture the frame
            ->export()
            ->toDisk('public')
            ->save($thumbnailPath);

        return $thumbnailPath;
    }
    public function index()
    {
        $audios = Audio::all();
        $data = compact('audios');
        return view('pages.apps.audios.index')->with($data);
        
        // try {
        //     # code...
        //     $audios = Audio::all();
        //     return view('pages.apps.audios.index', compact('audios'));
        // } catch (\Throwable $e) {
        //     return redirect()->back()->with('error', 'Something went wrong');
        // }
    }

    public function create()
    {
        return view('pages.apps.audios.index');
    }

    public function store(Request $request)
    {
        // my code here

        // Validate the request data
        $request->validate([
        'title' => 'required',
        'audio_file' => 'required|mimes:mp3,wav',
        ]);

    // Handle video upload
    $audio = $request->file('audio_file');
    $audioFileName = Str::random(20) . '.' . $audio->getClientOriginalExtension();
    $audio->move(public_path('storage/audio_file'), $audioFileName);

    // $user_id = Auth::id();

    $insert = new Audio();
    $insert->title = $request->title;
    $insert->file_path = 'storage/audio_file/' . $audioFileName;
    $insert->type = $request->type;
    $insert->price = $request->price;
    $insert->save();

    return redirect()->route('audios.index')->with('success', 'Audio deleted successfully');

        // my code here

        // try {
        //     # code...
        //     $request->validate([
        //         'title' => 'required',
        //         'audio_file' => 'required|mimes:mp3,wav',

        //     ]);

        //     $audioFile = $request->file('audio_file');
        //     $file_path = $audioFile->store('audio_files', 'public');

        //     Audio::create([
        //         'title' => $request->input('title'),
        //         'file_path' => $file_path,
        //         'type'=>$request->input('type'),
        //         'price' =>$request->input('price')??0.00,
        //     ]);

        //     return redirect()->route('audios.index')->with('success', 'Audio uploaded successfully');
        // } catch (\Throwable $e) {
        //     return redirect()->back()->with('error', 'Something went wrong');
        // }
    }
    public function destroy($id)
    {
        $audio = Audio::findOrFail($id);

        // Delete the audio file from storage
        Storage::disk('public')->delete($audio->file_path);

        // Delete the audio record from the database
        $audio->delete();

        return redirect()->route('audios.index')->with('success', 'Audio deleted successfully');
    }
    public function edit($id)
    {
        try {
            # code...
            $audio = Audio::findOrFail($id);
            return view('pages.apps.audios.edit', compact('audio'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            # code...
            $audio = Audio::findOrFail($id);

            $audio->title = $request->input('title');
            $audio->type = $request->input('type');
            $audio->price = $request->input('price')??0.00;

            if ($request->hasFile('audio_file')) {
                // Delete the existing audio file from storage
                Storage::disk('public')->delete($audio->file_path);

                // Upload the new audio file
                $audioFile = $request->file('audio_file');
                $audio->file_path = $audioFile->store('audio_files', 'public');
            }

            $audio->save();

            return redirect()->route('audios.index')->with('success', 'Audio updated successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}
