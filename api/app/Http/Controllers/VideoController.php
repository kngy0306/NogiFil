<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * 動画一覧を取得する
     */
    public function index(Request $request)
    {
        $videos = DB::table('videos')
                    ->leftJoin('video_tag_mst', 'videos.video_id', '=', 'video_tag_mst.video_id')
                    ->leftJoin('tags', 'video_tag_mst.tag_id', '=', 'tags.id')
                    ->select('videos.video_id', 'videos.title', 'video_tag_mst.id', 'tags.tag_name')
                    ->orderByDesc('videos.published_at')
                    ->get();

        $videoId = '';
        $responseData = [];
        foreach ($videos as $videoIndex => $videoData) {
            if ($videoData->video_id !== $videoId) {
                $videoId = $videoData->video_id;
                $responseData[$videoId] = [
                    'title' => $videoData->title,
                    'tags' => [$videoData->id => $videoData->tag_name],
                ];
                continue;
            }

            $responseData[$videoId]['tags'][$videoData->id] = $videoData->tag_name;
        }

        return response()->json($responseData);
    }

    /**
     * タグから動画を取得する
     */
    public function getVideosByTagname(Request $request, $tagName)
    {
        if (empty($tagName)) $this->index($request);

        $videos = DB::table('tags')
                    ->join('video_tag_mst', 'tags.id', '=', 'video_tag_mst.tag_id')
                    ->join('videos', 'video_tag_mst.video_id', '=', 'videos.video_id')
                    ->select('videos.video_id', 'videos.title', 'videos.thumbnail_url')
                    ->where('tags.tag_name', '=', $tagName)
                    ->orderByDesc('videos.published_at')
                    ->get();

        return response()->json($videos);
    }
}