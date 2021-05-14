<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class CategoryConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $name = 'category_index';
    /**
     * @var array
     */
    protected $settings = [
        'analysis' => [
            'analyzer' => [
                'custom_analyzer' => [
                    'type' => 'custom',
                    'tokenizer' => 'keyword',
                    'filter' => [
                        'lowercase'
                    ],
                ],
            ],
        ],
    ];
}