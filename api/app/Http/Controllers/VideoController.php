<?php

namespace App\Http\Controllers;

use App\Http\Vender\YoutubeApi;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideoTagMst;
use Exception;
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
                    ->get();

        return response()->json($videos);
    }

    /**
     * YouTubeAPIを使用し「乃木坂配信中」から動画をDBに登録する
     */
    public function registerYoutubeList(Request $request)
    {
        $client = new YoutubeApi();
        $searchListArray = $client->searchList();

        // YouTubeAPI
        $searchVideoArray = [];
        foreach ($searchListArray as $index => $res) {
            $video = $client->videosList($res->id->videoId);
            array_push($searchVideoArray, $video);
        }

        // 返却結果を整形
        $snippetArray = [];
        foreach ($searchVideoArray as $index => $videos) {
            $description = $videos[0]->snippet->description;
            $tags = array_slice(explode("#", $description), 1);
            
            array_walk($tags, function (&$value) {
                $value = trim($value);
            });

            $snippetArray[$index] = [
                'video_id' => $videos[0]->id,
                'title' => $videos[0]->snippet->title,
                'description' => $description,
                'thumbnail_url' => $videos[0]->snippet->thumbnails->high->url,
                'thumbnail_height' => $videos[0]->snippet->thumbnails->high->height,
                'thumbnail_width' => $videos[0]->snippet->thumbnails->high->width,
                'published_at' => $videos[0]->snippet->publishedAt,
                'tags' => [
                    $tags
                ],
            ];  
        }

        // $snippetArray = [
        //     0 => [
        //         "video_id" => "YtWOmZ6wIdg",
        //         "title" => "【アート】鈴木絢音、真っ白いものを汚したい【電視台】【乃木坂46時間TV】",
        //         "description" => "
        //             真っ白いものを汚したい、という欲望のもと、鈴木絢音が生配信でアート作品を作り上げました！\n
        //             皆さまにもストレス発散におススメ！？\n
        //             ぜひご覧ください！\n
        //             \n
        //             「乃木坂46時間TV」の個人企画・乃木坂電視台の「鈴木絢音」アーカイブを公開！\n
        //             2022年2月に配信しました「乃木坂46時間TV」のアーカイブを順次公開していきます♪\n
        //             \n
        //             ぜひご覧ください！\n
        //             \n
        //             出演\n
        //             乃木坂46 鈴木絢音\n
        //             \n
        //             ■乃木坂配信中チャンネル登録\n
        //             https://www.youtube.com/c/nogizakahaishinchu\n
        //             \n
        //             \n■「乃木坂46時間TV」再生リスト\n
        //             #鈴木絢音 #アート #乃木坂46時間TV #電視台 #乃木坂46 #乃木坂配信中
        //         ",
        //         "thumbnail_url" => "https://i.ytimg.com/vi/0qf_UVGZ64k/hqdefault.jpg",
        //         "thumbnail_height" => 360,
        //         "thumbnail_width" => 480,
        //         "published_at" => "2022-04-28T10:00:04Z",
        //         "tags" => [
        //             0 => [
        //                 0 => "鈴木絢音",
        //                 1 => "アート",
        //                 2 => "乃木坂46時間TV",
        //                 3 => "電視台",
        //                 4 => "乃木坂46",
        //                 5 => "乃木坂配信中",
        //             ],
        //         ],
        //     ],
        //     1 => [
        //         "video_id" => "-HSuyOOcJdY",
        //         "title" => "ゲーム実況生配信直後！桃鉄楽しかったです♪アーカイブでも楽しんでください！！ #Shorts",
        //         "description" => "#Shorts #ゲーム #ゲーム実況 #桃鉄 #生配信 #乃木坂46 #乃木坂配信中 #梅澤美波 #賀喜遥香 #金川紗耶 #吉田綾乃クリスティー",
        //         "thumbnail_url" => "https://i.ytimg.com/vi/rNZQU9mq9wc/hqdefault.jpg",
        //         "thumbnail_height" => 360,
        //         "thumbnail_width" => 480,
        //         "published_at" => "2022-04-26T15:00:26Z",
        //         "tags" => [
        //             0 => [
        //                 0 => "Shorts",
        //                 1 => "ゲーム",
        //                 2 => "ゲーム実況",
        //                 3 => "桃鉄",
        //                 4 => "生配信",
        //                 5 => "乃木坂46",
        //                 6 => "乃木坂配信中",
        //                 7 => "梅澤美波",
        //                 8 => "賀喜遥香",
        //                 9 => "金川紗耶",
        //                 10 => "吉田綾乃クリスティー",
        //             ],
        //         ],
        //     ],
        // ];

        // DB登録
        DB::beginTransaction();

        try {
            foreach ($snippetArray as $videos) {
                $video = DB::table('videos')->where('video_id', "=", $videos['video_id'])->get();
                if ($video->isNotEmpty()) continue;
    
                $now = date('Y/m/d H:i:s');
    
                // videosに登録
                $newVideo = Video::create([
                    'video_id' => $videos['video_id'],
                    'title' => $videos['title'],
                    'description' => $videos['description'],
                    'thumbnail_url' => $videos['thumbnail_url'],
                    'thumbnail_height' => $videos['thumbnail_height'],
                    'thumbnail_width' => $videos['thumbnail_width'],
                    'published_at' => date('Y/m/d H:i:s', strtotime($videos['published_at'])),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
    
                // tagsに登録
                $tagIdArray = [];
                foreach ($videos['tags'][0] as $tagName) {
                    $tag = DB::table('tags')->where('tag_name', "=", $tagName)->select('id')->get();
                    if ($tag->isNotEmpty()) {
                        foreach ($tag as $t) {
                            array_push($tagIdArray, $t->id);
                        }
                        continue;
                    }
                    
                    $newTag = Tag::create([
                        'id' => '',
                        'tag_name' => $tagName,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    array_push($tagIdArray, $newTag->id);
                }
                
                // video_tag_mstに登録
                foreach ($tagIdArray as $tag) {

                    $newVideoTagMst = VideoTagMst::create([
                        'video_id' => $newVideo->video_id,
                        'tag_id' => $tag,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        } catch(Exception $e) {
            info($e->getMessage());
            dd($e->getMessage());
            DB::rollBack();
        }

        DB::commit();
        
        return response()->json("complete insert DB", 200);
    }

    /**
     * タグ一覧取得
     */
}