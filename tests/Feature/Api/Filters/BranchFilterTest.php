<?php

namespace Tests\Feature\Api\Filters;

class BranchFilterTest extends Filter
{
    protected $endpoint = '/api/branches';
    protected $model    = \App\Repositories\Branches\Branch::class;
    protected $table = 'branches';
    protected $seederObject = [
        'name'        => 'Chi nhánh Láng Hạ',
        'phone'       => '0965656565',
        'email'       => 'langha@gmail.com',
        'tax_number'  => '12345',
        'type'        => 1,
        'status'      => 1
    ];
    protected $seederObjectFilter = [
        'name'        => 'Chi nhánh Láng Hạ xyz',
        'phone'       => '0965656566',
        'email'       => 'langha2@gmail.com',
        'tax_number'  => '12346',
        'type'        => 1,
    ];
    protected $transform = [
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
