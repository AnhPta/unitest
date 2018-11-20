<?php

namespace Tests\Feature\Api\RestFulls;

use App\Repositories\Branches\Branch;

class BranchRestFullTest extends RestFull
{
    protected $endpoint     = '/api/branches';
    protected $model        = \App\Repositories\Branches\Branch::class;
    protected $table        = 'branches';
    protected $isSoftDelete = true;
    protected $transform    = [
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
    protected $seederObject = [
        'name'        => 'Chi nhánh Láng Hạ',
        'phone'       => '0965656565',
        'address'     => '102 Láng Hạ',
        'email'       => 'langha@gmail.com',
        'tax_number'  => '12345',
        'type'        => 1,
        'status'      => 1
    ];
    protected $seederObjectModel = [
        'name'        => 'Chi nhánh Láng Hạ bb',
        'phone'       => '0965656566',
        'address'     => '102 Láng Hạ',
        'email'       => 'langha2@gmail.com',
        'tax_number'  => '12346',
        'type'        => 1,
        'status'      => 1
    ];
    protected $seederObjectUpdate = [
        'name'        => 'Chi nhánh Láng Hạ cc',
        'phone'       => '0965656567',
        'address'     => '102 Láng Hạ',
        'email'       => 'langha3@gmail.com',
        'tax_number'  => '12347',
        'type'        => 1
    ];

    // protected $resfullPermission = 'position';

    public function setUp()
    {
        parent::setUp();
        factory($this->model)->create(['status' => 0]);
    }

    /**
     * [storeOrUpdateFailedDataProvider description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function storeOrUpdateFailedDataProvider()
    {
        return [
            //required
            [
                [
                    'name' => '',
                    'address' => '',
                    'phone' => '',
                    'tax_number' => '',
                    'email' => ''
                ],
                [
                    'name',
                    'address',
                    'phone',
                    'tax_number',
                    'email'
                ]
            ],
            //unique
            [
                [
                    'phone' => $this->seederObject['phone'],
                    'tax_number' => $this->seederObject['tax_number'],
                    'email' => $this->seederObject['email']
                ],
                [
                    'phone',
                    'tax_number',
                    'email'
                ]
            ],
            //email
            [
                [
                    'email' => 'email'
                ],
                [
                    'email'
                ]
            ],
            //digits_between:10,12
            [
                [
                    'phone' => '012345678'
                ],
                [
                    'phone'
                ]
            ],
            [
                [
                    'phone' => '0123456789012'
                ],
                [
                    'phone'
                ]
            ],
            //in:0,1
            [
                [
                    'status' => 2
                ],
                [
                    'status'
                ]
            ],
            //boolean
            [
                [
                    'type' => 2
                ],
                [
                    'type'
                ]
            ],
        ];
    }

    public function updateStatusProvider()
    {
        return [
            //status = 1
            [
                'id' => 11
            ],
            //status = 0
            [
                'id' => 12
            ]
        ];
    }

    /**
     * [testChangeStatusFound description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-19
     * @return [type]     [description]
     */
    public function testChangeStatusNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;
        $this->json('PUT', $this->endpoint .'/change-status/'. $idNotFound)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * [testChangeStatusSuccess description]
     * @dataProvider updateStatusProvider
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-19
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function testChangeStatusSuccess($id)
    {
        $this->json('PUT', $this->endpoint . '/change-status/' . $id)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse($this->transform, false));
        if ($id == 11) {
            $this->assertEquals(0, $this->response->getData()->data->status);
        }
        if ($id == 12) {
            $this->assertEquals(1, $this->response->getData()->data->status);
        }
    }

    /**
     * [testUpdateBranchMainOld description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-19
     * @return [type]     [description]
     */
    public function testUpdateBranchMainOld()
    {
        factory($this->model)->create([
            'name'        => 'Chi nhánh Láng Hạ aa',
            'phone'       => '096565656567',
            'email'       => 'langhaa@gmail.com',
            'tax_number'  => '1234567',
            'type'        => 1
        ]);
        parent::testStoreSuccess();
        $this->assertEquals(1, Branch::where('type', Branch::MAIN)->count());
        $this->assertEquals(1, $this->response->getData()->data->type);
    }
}
