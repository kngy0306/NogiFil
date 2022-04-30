<?php

namespace App\Http\Vender;

use Google_Client;
use Google_Service_YouTube;

class YoutubeApi
{
    private $client;
    private $youtube;
    
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setDeveloperKey(env('YOUTUBE_API_KEY'));
        $this->youtube = new Google_Service_YouTube($this->client);
    }
    
    /**
     * /v3/searchを呼び出す
     *
     * @param string $nextPageToken = ''
     * @param int $maxResults = 50
     * @param string $q = ''
     * @return array
     */
    public function searchList(string $nextPageToken = '', int $maxResults = 50, string $q = ''): array
    {
        $r = $this->youtube->search->listSearch('snippet', array(
          'channelId' => 'UCfvohDfHt1v5N8l3BzPRsWQ',
          'maxResults' => $maxResults,
          'order' => 'date',
          'pageToken' => $nextPageToken,
          'q' => $q,
        ));

        info("response from YouTubeAPI " . print_r($r, true));
        
        if($r->nextPageToken) info("nextPageToken: 【" . $r->nextPageToken . "】 " . date('Y/m/d H:i:s'));

        return $r->items;
    }

    /**
     * /v3/videosを呼び出す
     *
     * @param string $id
     * @return array
     */
    public function videosList(String $id): array
    {
        $r = $this->youtube->videos->listVideos('snippet', array(
          'id' => $id,
        ));
        
        return $r->items;
    }
}