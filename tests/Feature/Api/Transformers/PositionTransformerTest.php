<?php

namespace Tests\Feature\Api\Transformers;

class PositionTransformerTest extends Transformer
{
    protected $endpoint = '/api/positions';
    protected $model    = \App\Repositories\Positions\Position::class;
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
    protected $params_transform_is_null = [
        // 'include'   => 'cities',
        'limit'     => 0,
        'q'         => 'filterlinhtinh'
    ];

    /**
     * [belongsToDataProvider description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
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
