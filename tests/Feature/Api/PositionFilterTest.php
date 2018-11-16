<?php

namespace Tests\Feature\Api;

class PositionFilterTest extends Filter
{
    protected $endpoint = '/api/positions';
    protected $model    = \App\Repositories\Positions\Position::class;
    protected $table = 'positions';
    protected $seederObject = [
        'name'       => 'abc',
    ];
    protected $seederObjectFilter = [
        'name'       => 'abcxyz',
    ];
    protected $transform = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    public function listtingFilterLimitSingle()
    {
        return [
            [
                ''
            ],
            [
                $this->seederObject['name']
            ]
        ];
    }  

    public function listtingFilterUnLimit()
    {
        return [
            [
                ''
            ],
            [
                $this->seederObject['name']
            ],
            [
                'filterlinhtinh'
            ]
        ];
    }
}
