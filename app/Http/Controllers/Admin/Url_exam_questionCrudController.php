<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Class_rom;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Url_exam_questionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Url_exam_questionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Url_exam_question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/url_exam_question');
        CRUD::setEntityNameStrings('url_exam_question', 'url_exam_questions');  
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

        CRUD::addFilter([
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
            CRUD::addClause('where', 'class_id', $value);
        });

        CRUD::addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Suject'
        ], function () {
            $category = Category::all();
            $array_category = [];
            foreach ($category as $value) {
                $array_category[$value->id] = $value->name;
            }
            return $array_category;
        }, function ($value) {
            CRUD::addClause('where', 'category_id', $value);
        });

        CRUD::addFilter([
            'name'  => 'status',
            'type'  => 'select2',
            'label' => 'Status'
        ], function () {
            $status = [
                '0' => 'have not crawl',
                '1' => 'crawl sucsses'
            ];
            return $status;
        }, function ($value) {
            CRUD::addClause('where', 'status', $value);
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
            'entity' => 'class_rom',
            'attribute' => 'name',
            'model' => Class_rom::class
        ]);

        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'relationship',
            'name' => 'category',
            'entity' => 'category',
            'attribute' => 'name',
            'model' => Category::class
        ]);

        CRUD::addColumn([
            'label' => 'Link',
            'type' => 'text',
            'name' => 'link'
        ]);

        CRUD::addColumn(
            [
                // select_from_array
                'name'    => 'status',
                'label'   => 'Status',
                'type'    => 'select_from_array',
                'options' => ['0' => 'have not crawl', '1' => 'crawl sucsses'],
            ],
        );
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
        // CRUD::setValidation(Url_exam_questionRequest::class);

        // CRUD::setFromDb(); // fields

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
    
}
