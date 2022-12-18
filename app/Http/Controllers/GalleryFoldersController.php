<?php

namespace App\Http\Controllers;

use App\Models\GalleryFolders;
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
}
