<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VideoTest extends TestCase
{
    // api_video

    /**
     * @test
     */
    public function api_videoにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/video');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_videoにGETメソッドで取得するデータ形式テスト()
    {
        $sampleVideoId = 'CG4quiaaiGw';
        
        $response = $this->get('api/video');
        $videos = $response->json();
        $video = $videos[$sampleVideoId];
        $this->assertSame(
            ['title', 'tags'],
            array_keys($video),
        );
    }

    // api_video_tagname

    /**
     * @test
     */
    public function api_video_秋元真夏にGETメソッドでアクセスできる()
    {
        $sampleMember = '秋元真夏';

        $response = $this->get('api/video/' . $sampleMember);
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function api_video_秋元真夏にGETメソッドで取得するデータ形式テスト()
    {
        $sampleMember = '秋元真夏';

        $response = $this->get('api/video/' . $sampleMember);
        $videos = $response->json();
        $video = $videos[0];
        $this->assertSame(
            ['video_id', 'title', 'thumbnail_url'],
            array_keys($video),
        );
    }
}