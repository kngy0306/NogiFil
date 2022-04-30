<?php

namespace App\Console\Commands;

use App\UseCases\NogiVideosUseCase;
use Illuminate\Console\Command;

class RegisterNogiVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-nogiVideos {nextPageToken?} {--maxResults=} {--q=} {--showOption}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "YouTubeAPIを使用し「乃木坂配信中」の動画を取得し、DBへ保存します。 オプション表示: --showOption\n";

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
        if ($this->option('showOption')) {
            $this->comment("Usage app:register-nogiVideos Command\n\napp:register-nogiVideos {nextPageToken?} {--maxResults=} {--q=} {--H|--help}\n\nnextPageTokenを指定しない場合、最新の動画を取得＆保存します。\nmaxResultsオプションを指定いない場合、リクエスト数は50です。\nqオプションを使用した場合、引数の文字列で検索します。");
        }

        $this->info('== Start ExportNogiVideos ==');
        
        $nextPageToken = $this->argument('nextPageToken') ?? "";
        $maxResults = $this->option('maxResults') ?? 50;
        $q = $this->option('q') ?? '';

        $res = $this->useCase->run($nextPageToken, $maxResults, $q);

        if ($res) {
            $this->info("== End ExportNogiVideos OK ==");
        } else {
            $this->error("== End ExportNogiVideos NG ==");
        }

        return 0;
    }
}