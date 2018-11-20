<?php

namespace Tests\Feature\Api\Transformers;

class BranchTransformerTest extends Transformer
{
    protected $endpoint = '/api/branches';
    protected $model    = \App\Repositories\Branches\Branch::class;
    protected $seederObject = [
        'id'          => 1,
        'name'        => 'Chi nhánh Láng Hạ',
        'phone'       => '0965656565',
        'address'     => '102 Láng Hạ',
        'email'       => 'langha@gmail.com',
        'tax_number'  => '12345',
        'type'        => 1
    ];
    protected $transform = [
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
    protected $params_transform_is_null = [
        'include'   => 'departments',
        'limit'     => 0,
        'q'         => 'filterlinhtinh'
    ];

    protected $transformDepartment = [
        'id',
        'name',
        'branch_id',
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
                    'class'     => \App\Repositories\Departments\Department::class,
                    'init_data' => 3,
                    'value'     => [
                            'branch_id'  => $this->seederObject['id']
                    ]
                ],
                [
                    'include'   => 'departments'
                ],
                [
                    'departments'  => [
                        'data'  => [
                            $this->transformDepartment
                        ]
                    ]
                ]
            ]
        ];
    }
}
