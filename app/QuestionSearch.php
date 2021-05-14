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
        // return [
        //     'must' => [
        //         'function_score' => [
        //             'query' => [
        //                 'multi_match' => [
        //                     'query' => $this->builder->query,
        //                     'fields' => ['content'],
        //                 ]
        //             ],
        //             'min_score' => 1,
        //         ]
        //     ],
        // ];
        
        
    }
}
