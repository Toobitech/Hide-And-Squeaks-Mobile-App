<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Auth;
class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return response()->json($videos);
    }
  /**
     * Handles the file upload for multiple videos
     *
     * @param Request $request
     * @return JsonResponse
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */
    public function storeMultiple(Request $request)
    {
        try {
           //  Auth::user();
              $user_id = auth()->user()->id;
            // Check if the files are present in the request
            if (!$request->hasFile('files')) {
                throw new UploadMissingFileException('No files uploaded.');
            }

            $files = $request->file('files');

            $uploadedVideos = [];

            foreach ($files as $file) {
                // Check if the upload is successful
                if (!$file->isValid()) {
                    throw new UploadFailedException('File upload failed.');
                }

                // Save the file to storage and database
                $response = $this->saveFile($file, $request->input('title'), $request->input('description'),  $user_id);

                // Check the type of response and handle accordingly
                if ($response instanceof JsonResponse) {
                    // If it's a JsonResponse, extract the data
                    $responseData = $response->getData(true);
                    $uploadedVideos[] = $responseData['video'];
                } else {
                    // Assume it's an array or an object
                    $uploadedVideos[] = $response['video'];
                }
            }

            return response()->json([
                'message' => 'Videos uploaded successfully',
                'videos' => $uploadedVideos,
            ]);
        } catch (UploadMissingFileException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (UploadFailedException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Unexpected exception: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }


    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */
    public function store(Request $request)
    {
        try {
            // Check if the file is present in the request
            if (!$request->hasFile('file')) {
                throw new UploadMissingFileException('No file uploaded.');
            }
             $user_id = auth()->id();

            // Create the file receiver
            $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

            // Check if the upload is successful
            if (!$receiver->isUploaded()) {
                throw new UploadFailedException('File upload failed.');
            }

            // Receive the file
            $save = $receiver->receive();

            // Check if the upload has finished
            if ($save->isFinished()) {
                // Save the file to storage and database
                $response = $this->saveFile($save->getFile(), $request->input('title'), $request->input('description'), $user_id);

                return $response;
            }

            // We are in chunk mode, send the current progress
            $handler = $save->handler();

            return response()->json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ]);
        } catch (UploadMissingFileException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (UploadFailedException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Log other unexpected exceptions
            Log::error('Unexpected exception: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Saves the file to storage and database
     *
     * @param UploadedFile $file
     * @param string $title
     * @param int $user_id
     * @param string $description
     * @return JsonResponse
     */
    protected function saveFile(UploadedFile $file, $title, $description,$user_id)
    {
        try {
            // Validate file size, mime type, or any other relevant validation

            $fileName = $this->createFilename($file);

            // Group files by mime type
            $mime = str_replace('/', '-', $file->getMimeType());

            // Group files by the date (week)
            $dateFolder = date("Y-m-W");

            // Build the file path
            $filePath = "upload/";
            $finalPath = storage_path("app/public/" . $filePath);

            // Move the file
            $file->move($finalPath, $fileName);

            // Save video information to the database
            $video = Video::create([
                'title' => $title,
                'description' => $description,
                'file_path' => $filePath . $fileName,
                'user_id'=>$user_id,
            ]);

            $response = [
                'message' => 'Video uploaded successfully',
                'video' => [
                    'video_path' => $video->file_path,
                    'title' => $video->title,
                    'description' => $video->description,
                    'user_id'=>$video->user_id,
                ],
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            // Log other unexpected exceptions
            Log::error('Unexpected exception: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Create unique filename for uploaded file
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to the name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
