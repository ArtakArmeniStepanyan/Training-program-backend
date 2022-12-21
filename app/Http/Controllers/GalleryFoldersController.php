<?php

namespace App\Http\Controllers;

use App\Models\GalleryFolders;
use App\Models\GalleryImages;
use Illuminate\Http\Request;

class GalleryFoldersController extends Controller
{
    public  function createFolder(Request $request){
        $newFolder = GalleryFolders::insert([
            'folderName' => $request->folderName,
            'userId' => $request->userId,
        ]);

        $folders = GalleryFolders::where('userId', $request->userId)->get();

        if ($newFolder) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Folder created',
                'folders' => $folders
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public  function getUserFolders($id){
        $userFolders = GalleryFolders::where('userId', $id)->get();

        if ($userFolders) {
            return response()->json([
                'status' => 'ok',
                'folders' => $userFolders
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public  function getCurrentFolder($id){
        $folder = GalleryFolders::where('id', $id)->first();

        if ($folder) {
            return response()->json([
                'status' => 'ok',
                'folder' => $folder
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function getCurrentImages($id)
    {
        $images = GalleryImages::where('folderId', $id)->get();

        if ($images) {
            return response()->json([
                'status' => 'ok',
                'images' => $images
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public  function deleteFolder($id){
        $folder = GalleryFolders::where('id', $id)->delete();
        GalleryImages::where('folderId', $id)->delete();

        if ($folder) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Folder deleted'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function deleteImage($id)
    {
        $folderId = GalleryImages::where('id', $id)->first()->folderId;
        $deletedImage = GalleryImages::where('id', $id)->delete();
        $images = GalleryImages::where('folderId', $folderId)->get();

        if ($deletedImage) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Image deleted',
                'images' => $images
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function saveImage(Request $request)
    {
        $path = $request->file('image')->store('Gallery_images', 'public');

        $image = GalleryImages::insert([
            'folderId' => $request->folderId,
            'image' => $path,
        ]);

        $images = GalleryImages::where('folderId', $request->folderId)->get();

        if ($image) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Image added',
                'images' => $images,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
