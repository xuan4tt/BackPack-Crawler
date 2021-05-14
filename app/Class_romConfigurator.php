<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class Class_romConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $name = 'class_rom_index';
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