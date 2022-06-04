<?php

namespace App\Console\Commands;

use App\UseCases\NogiVideosUseCase;
use Illuminate\Console\Command;

class RegisterNogiVideoByName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:registerNogiVideoByName {video_id} {title} {thumbnail_url} {published_at} {--tags=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "YouTubeAPIを使用し「乃木坂配信中」の動画を取得し、DBへ保存します。\n入力が必要な値\n・video_id\ntitle\nthumbnail_url\nthumbnail_height\nthumbnail_width\npublished_at\ntags";

    /** @var NogiVideosUseCase */
    private $useCase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NogiVideosUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('== Start RegisterNogiVideo by memberName ==');

        $res = $this->useCase->runByManual($this->argument('video_id'), $this->argument('title'), $this->argument('thumbnail_url'), $this->argument('published_at'), $this->option('tags'));

        if ($res) {
            $this->info("== End RegisterNogiVideo OK ==");
        } else {
            $this->error("== End RegisterNogiVideo NG ==");
        }

        return 0;
    }
}