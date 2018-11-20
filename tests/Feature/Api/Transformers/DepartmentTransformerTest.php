<?php

namespace Tests\Feature\Api\Transformers;

class DepartmentTransformerTest extends Transformer
{
    protected $endpoint = '/api/departments';
    protected $model    = \App\Repositories\Departments\Department::class;
    protected $seederObject = [
        'name'      => 'IT',
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
    protected $params_transform_is_null = [
        'include'   => 'branch',
        'limit'     => 0,
        'q'         => 'filterlinhtinh'
    ];
    protected $transformBranch = [
        'id',
        'name',
        'description',
        'about',
        'phone',
        'address',
        'website',
        'email',
        'facebook',
        'instagram',
        'zalo',
        'tax_number',
        'bank',
        'type',
        'city_id',
        'district_id',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * [belongsToDataProvider description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */ 
    public function belongsToDataProvider()
    {
        return [
            [
                [
                    'class'     => \App\Repositories\Branches\Branch::class,
                    'init_data' => 1,
                    'value'     => []
                ],
                [
                    'include'   => 'branch'
                ],
                [
                    'branch'  => [
                        'data'  => $this->transformBranch
                    ]
                ]
            ]
        ];
    }
}
