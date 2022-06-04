<?php

namespace App\UseCases;

use App\Services\NogiVideosService;

final class NogiVideosUseCase
{
  /** @var NogiVideosService */
  private $service;

  public function __construct(NogiVideosService $service)
  {
    $this->service = $service;
  }

  public function run(string $nextPageToken = '', int $maxResults, string $q = ''): bool
  {
    // YouTubeAPIを使用し動画を取得
    $videoArray = $this->service->fetchVideos($nextPageToken, $maxResults, $q);
    // DB登録
    $res = $this->service->insertVideos($videoArray);

    return $res;
  }

  public function runByManual(string $video_id, string $title, string $thumbnail_url, string $published_at, array $tags): bool
  {
    // tagを配列へ
    $videoTag[0] = $tags;

    // DB登録用の配列を作成
    $videoArray = [];
    array_push($videoArray, [
      "video_id" => $video_id,
      "title" => $title,
      "description" => $title,
      "thumbnail_url" => $thumbnail_url,
      "thumbnail_height" => 360,
      "thumbnail_width" => 480,
      "published_at" => $published_at,
      "tags" => $videoTag,
    ]);

    // DB登録
    $res = $this->service->insertVideos($videoArray);

    return $res;
  }
}