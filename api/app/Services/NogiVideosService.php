<?php

namespace App\Services;

use App\Http\Vender\YoutubeApi;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideoTagMst;
use Exception;
use Illuminate\Support\Facades\DB;

final class NogiVideosService
{
  /**
   * 動画を取得
   * 
   * @param string $nextPageToken
   * @param int $maxResults = 50
   * @param string $q = ''
   * @return array
   */
  public function fetchVideos(string $nextPageToken = '', int $maxResults, string $q = ''): array
  {
    $client = new YoutubeApi();
    $searchListArray = $client->searchList($nextPageToken, $maxResults, $q);

    // YouTubeAPI
    $searchVideoArray = [];
    foreach ($searchListArray as $index => $res) {
      info("index: " . $index . " videoId: " . $res->id->videoId);
      if (is_null($res->id->videoId)) {
        info('video_id is null in 【' . __METHOD__ . '】');
        break;
      }
      
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

    return $snippetArray;
  }

  /**
   * 動画をDBへ登録
   * 
   * @param array $videoArray
   * @return bool
   */
  public function insertVideos(array $videoArray): bool
  {

    DB::beginTransaction();
    
    try {
      foreach ($videoArray as $videos) {
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
      return false;
    }

  DB::commit();
        
  return true;
  }
}