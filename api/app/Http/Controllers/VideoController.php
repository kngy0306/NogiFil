<?php

namespace App\Http\Controllers;

use App\Http\Vender\YoutubeApi;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        // $client = new YoutubeApi();
        // $searchList = $client->searchList('乃木坂46');

        // $responseArray = [];
        // foreach ($searchList as $index => $res) {
        //     array_push($responseArray, $res);
        //     array_push($responseArray, "============");
        //     $video = $client->videosList($res->id->videoId);
        //     array_push($responseArray, $video);
        // }

        // return response()->json($responseArray);

        $responseArray = [];

        array_push($responseArray, [
            'title' => '【公式】「乃木坂工事中」# 319「第3回 頭NO王決定戦 前編」2021.07.25 OA',
            'thumbnail_url' => 'https://i.ytimg.com/vi/-HSuyOOcJdY/maxresdefault.jpg',
            'video_id' => '-HSuyOOcJdY',
            'published_at' => '2021-07-25T15:28:46Z',
        ]);

        array_push($responseArray, [
            'title' => '【公式】「乃木坂工事中」# 318「上半期 乃木坂46反省大賞」2021.07.18 OA',
            'thumbnail_url' => 'https://i.ytimg.com/vi/ZlFMLj_BRwk/maxresdefault.jpg',
            'video_id' => '-HSuyOOcJdY',
            'published_at' => '2021-07-18T15:58:49Z',
        ]);

        return response()->json($responseArray);
    }

    public function getYoutubeList(Request $request)
    {
        // $client = new YoutubeApi();
        // $searchList = $client->searchList('乃木坂46');

        // $responseArray = [];
        // foreach ($searchList as $index => $res) {
        //     array_push($responseArray, $res);
        //     array_push($responseArray, "============");
        //     $video = $client->videosList($res->id->videoId);
        //     array_push($responseArray, $video);
        // }

        // return response()->json($responseArray);
    }
}