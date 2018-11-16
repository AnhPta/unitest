<?php

namespace Tests\Feature\Api;

class PositionTransformerTest extends Transformer
{
    protected $endpoint = '/api/positions';
    protected $model    = \App\Repositories\Positions\Position::class;
    protected $params_transform_is_null = [
        // 'include'   => 'cities',
        'limit'     => 0,
        'q'         => 'qlinhtinh'
    ];
    protected $seederObject = [
        'name'       => 'bb',
    ];
    protected $transform = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $transformPosition = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at'
    ];

    // public function belongsToDataProvider()
    // {
    //     return [
    //         [
    //             [
    //                 [
    //                     'class'     => \App\Repositories\Positions\Position::class,
    //                     'init_data' => 3,
    //                     'value'     => [
    //                         'name'  => $this->seederObject['name']
    //                     ]
    //                 ]
    //             ],
    //             [
    //                 // 'include'   => 'cities'
    //             ],
    //             [
    //                 // 'cities'  => [
    //                 //     'data'  => [$this->transformCity]
    //                 // ]
    //             ]
    //         ]
    //     ];
    // }
}
