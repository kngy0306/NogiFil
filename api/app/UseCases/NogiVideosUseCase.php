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
}