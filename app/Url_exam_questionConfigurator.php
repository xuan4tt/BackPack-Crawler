<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class Url_exam_questionConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $name = 'url_exem_question_index';
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