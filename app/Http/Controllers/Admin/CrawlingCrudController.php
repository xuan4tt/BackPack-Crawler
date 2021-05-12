<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CrawlingRequest;

use App\Jobs\AddCategoryClassJob;
use App\Jobs\CrawlingJob;
use App\Jobs\CrawlingJob2;
use App\Jobs\UrlExamQuestionsJob;

use App\Services\UrlExamService;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Class_rom;
use App\Models\Correct_answer;
use App\Models\Crawling;
use App\Models\Question;
use App\Models\Url_exam_question;
use App\Models\User;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

use Goutte\Client;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CrawlingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CrawlingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    protected $UrlExamService;

    public function __construct(UrlExamService $UrlExamService)
    {   
        parent::__construct();
        $this->UrlExamService = $UrlExamService;
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Crawling::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/crawling');
        CRUD::setEntityNameStrings('crawling', 'crawlings');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        CRUD::setFromDb(); // columns
        // dd(User::all());
        // $this->crud->filters();
        // CRUD::removeAllFilters(); 
        //$this->crud->addButtonFromView('top', 'import', 'import', 'end');
        CRUD::addColumn([
            'label' => 'Class',
            'type' => 'relationship',
            'name' => 'class',
            'entity' => 'CrawlingClass_rom',
            'attribute' => 'name',
            'model' => Class_rom::class
        ]);

        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'relationship',
            'name' => 'category',
            'entity' => 'CrawlingCategory',
            'attribute' => 'name',
            'model' => Category::class
        ]);

        CRUD::addColumn([
            'label' => 'User',
            'type' => 'relationship',
            'name' => 'user',
            'entity' => 'CrawlingUser',
            'attribute' => 'name',
            'model' => User::class
        ]);

        CRUD::addColumn([
            'name' => 'created_at',
            'type' => 'datetime',
            'label' => 'Date time',
        ]);

        CRUD::addButtonFromModelFunction('line', 'action_crawling', 'ActionCrawling', 'beginning');

        CRUD::enableBulkActions();

        // CRUD::addColumn([
        //     'type'           => 'checkbox',
        //     'name'           => 'bulk_actions',
        //     'label'          => ' <input type="checkbox" class="crud_bulk_actions_main_checkbox" />',
        //     'priority'       => 1,
        //     'searchLogic'    => false,
        //     'orderable'      => false,
        //     'visibleInModal' => false,
        // ])->makeFirstColumn();

        CRUD::column('class_id')->remove();
        CRUD::column('category_id')->remove();
        CRUD::column('user_id')->remove();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(CrawlingRequest::class);

        // CRUD::setFromDb(); // fields

        CRUD::addField([
            'label' => 'Url Crawl',
            'type' => 'text',
            'name' => 'url',
            'value' => 'Tiến hành crawl data',
            'multiple' => 'disabled'
        ]);

        // else {
        //     CRUD::addField([
        //         'label' => 'Class',
        //         'type' => 'select',
        //         'name' => 'class_id',
        //         'entity' => 'CrawlingClass_rom',
        //         'attribute' => 'name',
        //         'model' => Class_rom::class
        //     ]);

        //     CRUD::addField([
        //         'label' => 'Category',
        //         'type' => 'select',
        //         'name' => 'category_id',
        //         'entity' => 'CrawlingCategory',
        //         'attribute' => 'name',
        //         'model' => Category::class
        //     ]);

        //     CRUD::addField([
        //         'label' => 'AutherID',
        //         'type' => 'hidden',
        //         'name' => 'user_id',
        //         'value' => Auth::guard(backpack_guard_name())->user()->id
        //     ]);
        // }


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function store(CrawlingRequest $CrawlingRequest)
    {
        // dd(
        //     Url_exam_question::where('status', 0)->limit(15)->orderBy('class_id', 'ASC')->get()
        // );
        $url = 'https://khoahoc.vietjack.com/trac-nghiem';
        if (Class_rom::count() == 0 || Category::count() == 0) {
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $crawler->filter('div.col-sm-6 > div.info-box')->each(
                function (Crawler $node) {
                    $name = $node->filter('a > div.info-box-content > span.info-box-text')->html();
                    $url = $node->filter('a')->attr('href');
                    if (Class_rom::where('name', $name)->count() == 0) {
                        $Class_rom = new Class_rom;
                        $Class_rom->name = $name;
                        $Class_rom->url = $url;
                        $Class_rom->save();
                    }
                    AddCategoryClassJob::dispatch($url);
                }
            );
        }
        $Class_rom = Class_rom::all();
        $Category = Category::all();
        foreach ($Class_rom as $item) {
            foreach ($Category as $item2) {
                $UrlLink = $item->url . "/" . $item2->type;
                UrlExamQuestionsJob::dispatch($UrlLink, $item->id, $item2->id);
            }
        }


        // $request = $CrawlingRequest->all();
        // if (isset($request['url']) && $request['url'] && $request['url'] == 'https://khoahoc.vietjack.com/trac-nghiem') {

        //     $client = new Client();
        //     $crawler = $client->request('GET', $request['url']);
        //     $crawler->filter('div.col-sm-6 > div.info-box')->each(
        //         function (Crawler $node) {
        //             $name = $node->filter('a > div.info-box-content > span.info-box-text')->html();
        //             $url = $node->filter('a')->attr('href');

        //             $Class_rom = new Class_rom;
        //             $Class_rom->name = $name;
        //             $Class_rom->url = $url;
        //             $Class_rom->save();

        //             AddCategoryClassJob::dispatch($url);
        //         }
        //     );
        //     Alert::add('success', 'You can get started URL Crawl')->flash();
        //     return redirect()->route('crawling.index');
        // } else {
        //     $request = $CrawlingRequest->all();
        //     $urlClass_rom = Class_rom::find($request['class_id'])->url;
        //     $typeCategory = Category::find($request['category_id'])->type;
        //     $link = $urlClass_rom . "/" . $typeCategory;

        //     if (Crawling::where('link', $link)->first()) {
        //         Alert::add('error', 'URL Crawl already exists!')->flash();
        //         return redirect()->back();
        //     }
        //     $Crawling = new Crawling;
        //     $Crawling->class_id = $request['class_id'];
        //     $Crawling->category_id = $request['category_id'];
        //     $Crawling->user_id = $request['user_id'];
        //     $Crawling->link = $link;
        //     $Crawling->save();

        Alert::add('success', 'URL Crawl added successfully')->flash();
        return redirect()->route('crawling.index');
        // }
    }

    public function crawling($id)
    {
        $crawling = Crawling::find($id);
        if ($crawling->status == 0) {
            $link = $crawling->link;
            $client = new Client();
            $crawler = $client->request('GET', $link);
            $crawler->filter('li.exam-item > div.block-content-exam-item')->each(function (Crawler $node) use (&$id, &$client) {
                $url = $node->filter('a.url-root')->attr('href');
                $crawler = $client->request('GET', $url);
                if ($crawler->filter('div.quiz-answer-item > ul.exam-related > li')->count() !== 0) {
                    $crawler->filter('div.quiz-answer-item > ul.exam-related > li')->each(
                        function (Crawler $node) use (&$id) {
                            $node_url = $node->filter('a')->attr('href');
                            CrawlingJob2::dispatch($node_url, $id);
                        }
                    );
                }
                CrawlingJob2::dispatch($url, $id);
                // CrawlingJob::dispatch($url, $id);
            });

            //Check url in page
            if ($crawler->filter('li.page-item > a')->count() > 0) {
                $crawler->filter('li.page-item > a')->each(function (Crawler $node) use (&$id) {
                    $url_page =  $node->attr('href');
                    if ($url_page !== null) {
                        $client = new Client();
                        $crawler_page = $client->request('GET', $url_page);
                        $crawler_page->filter('li.exam-item > div.block-content-exam-item')->each(function (Crawler $node) use (&$id) {
                            $url = $node->filter('a.url-root')->attr('href');
                            CrawlingJob2::dispatch($url, $id);
                        });
                    }
                });
            }

            // $crawling->status = 1;
            // $crawling->save();

            Alert::add('success', 'URL Crawl executing system :))')->flash();
        } else {
            Alert::add('error', 'URL Crawl already exists!')->flash();
        }
        return redirect()->route('crawling.index');
    }
}
