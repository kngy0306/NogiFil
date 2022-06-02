<?php

namespace App\Http\Controllers;

use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * 動画一覧を取得する
     */
    public function index(Request $req, VideoService $videoService)
    { 
        return response()->json($videoService->getAllVideos());
    }

    /**
     * タグから動画を取得する
     */
    public function getVideosByTagname(string $tagName, VideoService $videoService)
    { 
        return response()->json($videoService->getVideosByTagname($tagName)); 
    }
}