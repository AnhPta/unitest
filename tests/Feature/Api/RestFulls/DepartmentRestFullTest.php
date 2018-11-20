<?php

namespace Tests\Feature\Api\RestFulls;

class DepartmentRestFullTest extends RestFull
{
    protected $endpoint     = '/api/departments';
    protected $model        = \App\Repositories\Departments\Department::class;
    protected $table        = 'departments';
    protected $isSoftDelete = false;
    protected $transform    = [
        'id',
        'name',
        'branch_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $seederObject = [
        'name' => 'IT',
        'branch_id' => 1
    ];
    protected $seederObjectModel = [
        'name' => 'IT',
        'branch_id' => 1
    ];
    protected $seederObjectUpdate = [
        'name' => 'IT',
        'branch_id' => 1
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
                    'branch_id' => '',
                ],
                [
                    'name',
                    'branch_id',
                ]
            ],
            //exists:branches,id
            [
                [
                    'branch_id' => 12,
                ],
                [
                    'branch_id',
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
            ]
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
}
