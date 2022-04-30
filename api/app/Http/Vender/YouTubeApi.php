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
     * @return array
     */
    public function searchList(String $nextPageToken = '')
    {
        $r = $this->youtube->search->listSearch('snippet', array(
          'channelId' => 'UCfvohDfHt1v5N8l3BzPRsWQ',
          'maxResults' => 2,
          'order' => 'date',
          'pageToken' => $nextPageToken,
        ));

        if($r->nextPageToken) info("nextPageToken: " . $r->nextPageToken);

        return $r->items;
    }

    /**
     * /v3/videosを呼び出す
     *
     * @param string $id
     * @return array
     */
    public function videosList(String $id)
    {
        $r = $this->youtube->videos->listVideos('snippet', array(
          'id' => $id,
        ));
        
        return $r->items;
    }
}