<?php

namespace Tests\Feature\Api\Filters;

class PositionFilterTest extends Filter
{
    protected $endpoint = '/api/positions';
    protected $model    = \App\Repositories\Positions\Position::class;
    protected $table = 'positions';
    protected $seederObject = [
        'name'   => 'abc',
        'status' => 1
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

    /**
     * [listtingFilterLimitSingle description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
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

    /**
     * [listtingFilterUnLimit description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
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
