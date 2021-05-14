<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionRequest;
use App\Models\Category;
use App\Models\Class_rom;
use App\Models\Crawling;
use App\Models\Question;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/question');
        CRUD::setEntityNameStrings('question', 'questions');
        CRUD::enableDetailsRow();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns
        $this->crud->addFilter([
            'name'  => 'class_id',
            'type'  => 'select2',
            'label' => 'Class'
        ], function () {
            $class_rom = Class_rom::all();
            $array_class_rom = [];
            foreach ($class_rom as $value) {
                $array_class_rom[$value->id] = $value->name;
            }
            return $array_class_rom;
        }, function ($value) {
            $this->crud->addClause('where', 'class_id', $value);
        });

        // select2 filter Category
        $this->crud->addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Category'
        ], function () {
            $category = Category::all();
            $array_category = [];
            foreach ($category as $value) {
                $array_category[$value->id] = $value->name;
            }
            return $array_category;
        }, function ($value) {
            $this->crud->addClause('where', 'category_id', $value);
        });

        CRUD::addColumn([
            'label' => 'Id',
            'type' => 'text',
            'name' => 'id'
        ]);

        CRUD::addColumn([
            'label' => 'Class',
            'type' => 'relationship',
            'name' => 'class_rom',
            'entity' => 'QuestionClass_rom',
            'attribute' => 'name',
            'model' => Class_rom::class
        ]);

        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'relationship',
            'name' => 'category',
            'entity' => 'QuestionCategory',
            'attribute' => 'name',
            'model' => Category::class
        ]);

        CRUD::addColumn([
            'label' => 'Question',
            'type' => 'text',
            'name' => 'content'
        ]);

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
        CRUD::setValidation(QuestionRequest::class);

        CRUD::setFromDb(); // fields

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

    protected function showDetailsRow($id)
    {   
        $question = Question::find($id);
        $name_exam_question = $question->QuestionUrl_exam_question->name;
        $link_exam_question = $question->QuestionUrl_exam_question->link;
        $answers = $question->answers;
        return view('showQuestionDetail', compact(
            'question', 
            'name_exam_question', 
            'link_exam_question',
            'answers'
        ));
    }
}
