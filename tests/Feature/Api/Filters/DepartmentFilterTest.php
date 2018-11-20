<?php

namespace Tests\Feature\Api\Filters;

class DepartmentFilterTest extends Filter
{
    protected $endpoint = '/api/departments';
    protected $model    = \App\Repositories\Departments\Department::class;
    protected $table = 'departments';
    protected $seederObject = [
        'name' => 'Phòng IT',
        'branch_id' => 1
    ];
    protected $seederObjectFilter = [
        'name' => 'Phòng IT xyz',
        'branch_id' => 1
    ];
    protected $transform = [
        'id',
        'name',
        'branch_id',
        'status',
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
