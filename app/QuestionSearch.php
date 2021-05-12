<?php

namespace App;

use ScoutElastic\SearchRule;

class QuestionSearch extends SearchRule
{
    /**
     * @inheritdoc
     */
    public function buildHighlightPayload()
    {
        return [
            'fields' => [
                'name' => [
                    'type' => 'plain'
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        return [
            'must' => [
                'function_score' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $this->builder->query,
                            'fields' => ['content']
                        ], 
                        // 'function_score' => [
                        //     'query' => $this->builder->query,
                        //     'boost' => '5',
                        //     'random_score' => [],
                        //     'boost_mode' => 
                        // ]
                    ],
                    'min_score' => 1,
                    
                ]
            ]
        ];
    }
}
