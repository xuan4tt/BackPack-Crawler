<?php

namespace App\Console\Commands;

use App\Jobs\CategoryJob;
use App\Jobs\ClassJob;
use App\Jobs\CrawlingJob;
use App\Jobs\CreateIndexJob;
use App\Jobs\TestJob;
use App\Jobs\UrlExamQuestionsJob;
use App\Models\Category;
use App\Models\Class_rom;
use App\Models\Url_exam_question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Url;

class TaskCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:task-crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl data VietJack - J97';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Class_rom::count() == 0 || Category::count() == 0) {
            //index elastics
            CreateIndexJob::dispatch();

            ClassJob::dispatch();
            CategoryJob::dispatch();

        } else {
            if (Url_exam_question::count() == 0) {
                $Class_rom = Class_rom::all();
                $Category = Category::all();
                foreach ($Class_rom as $item) {
                    foreach ($Category as $item2) {
                        $UrlLink = $item->url . "/" . $item2->type;
                        UrlExamQuestionsJob::dispatch($UrlLink, $item->id, $item2->id);
                    }
                }
            } else {
                if (Url_exam_question::where('status', 0)->count() > 0) {
                    $link =  Url_exam_question::where('status', 0)->orderBy('id', 'ASC')->first();
                    CrawlingJob::dispatch($link->link, $link->category_id, $link->class_id, $link->id);
                }
            }
        }
    }
}
