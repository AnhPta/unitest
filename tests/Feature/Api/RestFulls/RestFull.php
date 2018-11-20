<?php

namespace Tests\Feature\Api\RestFulls;

use TestCase;
// use Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class RestFull extends TestCase
{
    use DatabaseMigrations;

    /**
     * url endpoint
     * @var [type]
     */
    protected $endpoint;
    /**
     * model class
     * @var string
     */
    protected $model;
    /**
     * table
     * @var string
     */
    protected $table;
    /**
     * is soft delete
     * @var boolean
     */
    protected $isSoftDelete = false;
    /**
     * data transfrom
     * @var arrau
     */
    protected $transform;
    /**
     * seeder data
     * @var [type]
     */
    protected $seederObject;
    /**
     * seeder data insert, update
     * @var array
     */
    protected $seederObjectModel;
    /**
     * seeder data update
     * @var array
     */
    protected $seederObjectUpdate;

    /**
     * number row to test
     * @var [type]
     */
    protected $initDataNumber = 10;

    /**
     * is soft delete
     * @var boolean
     */

    /**
     * data store not valid
     * @return array
 */
    abstract public function storeOrUpdateFailedDataProvider();

    public function setUp()
    {
        // dd('kk');
        parent::setUp();
        $this->generateTestData();
        // $this->authWithSupperAdmin();
    }

    /**
     * create data for test by model factory & initDataNumber
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     */
    protected function generateTestData()
    {
        factory($this->model, $this->initDataNumber)->create();
        factory($this->model)->create($this->seederObject);
    }

    public function failedResponse($errors = null)
    {
        if ($errors == null) {
            return [
                'code',
                'status',
                'data',
                'message'
            ];
        } else {
            return [
                'code',
                'status',
                'data' => [
                    'errors' => $errors
                ],
                'message'
            ];
        }
    }

    public function deleteResponse()
    {
        return [
            'code',
            'status',
            'data',
            'message'
        ];
    }

    public function successResponse($transform, $meta = false)
    {
        if ($meta) {
            return [
                'code',
                'status',
                'data'  => $transform,
                'meta'  => [
                    'pagination'
                ]
            ];
        } else {
            return [
                'code',
                'status',
                'data'  => $transform
            ];
        }
    }

    /**
     * [testListting description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testListting()
    {
        $this->json('GET', $this->endpoint)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse([$this->transform], true));

        $this->assertCount(12, $this->response->getData()->data);
    }

    /**
     * [testListtingWithUnLimit not pagination]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testListtingWithUnLimit()
    {
        $this->json('GET', $this->endpoint . '?' . http_build_query(['limit' => -1]))
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse([$this->transform]));

        $this->assertCount(\DB::table($this->table)->count(), $this->response->getData()->data);
    }

    /**
     * [testListtingSingle not pagination]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testListtingSingle()
    {
        $this->json('GET', $this->endpoint . '?' . http_build_query(['limit' => 0]))
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse($this->transform));
        $this->assertEquals(1, count($this->response->getData()->data));
    }

    /**
     * [testShowNotFound description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testShowNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('GET', $this->endpoint . '/' . $idNotFound)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * [testShowSuccess description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testShowSuccess()
    {
        $this->json('GET', $this->endpoint . '/1')
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse($this->transform));

        $this->assertEquals(1, $this->response->getData()->data->id);
    }

    /**
     * [testStoreFailed description]
     * @dataProvider storeOrUpdateFailedDataProvider
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @param  [type]     $data   [description]
     * @param  [type]     $errors [description]
     * @return [type]             [description]
     */
    public function testStoreFailed($data, $errors)
    {
        $this->json('POST', $this->endpoint, $data)
        ->seeStatusCode(422)
        ->seeJsonStructure($this->failedResponse($errors));
    }

    /**
     * [testStoreSuccess description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testStoreSuccess()
    {        
        $this->json('POST', $this->endpoint, $this->seederObjectModel)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse($this->transform));

        $id_success   = \DB::table($this->table)->count();
        $success_data = array_merge(['id' => $id_success], $this->seederObjectModel);

        $this->seeInDatabase($this->table, $success_data);
    }

    /**
     * @dataProvider storeOrUpdateFailedDataProvider
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @param  [type]     $data   [description]
     * @param  [type]     $errors [description]
     * @return [type]             [description]
     */
    public function testUpdateFailed($data, $errors)
    {
        $this->json('PUT', $this->endpoint . '/1' , $data)
        ->seeStatusCode(422)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * [testUpdateNotFound description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testUpdateNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('PUT', $this->endpoint . '/' . $idNotFound, $this->seederObjectModel)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * [testUpdateSuccess description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testUpdateSuccess()
    {
        $this->json('PUT', $this->endpoint . '/1', $this->seederObjectUpdate)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse($this->transform));

        $success_data = array_merge(['id' => 1], $this->seederObjectUpdate);
        $this->seeInDatabase($this->table, $success_data);
    }

    /**
     * [testDeleteNotFound description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testDeleteNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('DELETE', $this->endpoint . '/' . $idNotFound)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * [testDeleteSuccess description]
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testDeleteSuccess()
    {
        $this->json('DELETE', $this->endpoint . '/1')
        ->seeStatusCode(200)
        ->seeJsonStructure($this->deleteResponse());

        if ($this->isSoftDelete) {
            $objectSoftDelete = \DB::table($this->table)->where('deleted_at', '!=', null)->find(1);

            $this->assertFalse(empty($objectSoftDelete));

        } else {
            $this->notSeeInDatabase($this->table, [
                'id' => 1
            ]);
        }
    }

    /**
     * module permission
     * @var [type]
     */
    // protected $resfullPermission;

    /**
     * restful api
     * @return array     [
            permissions
            method,
            url
        ]
     */
    // public function restfulEndpoidProvider()
    // {
    //     return [
    //         [
    //             [$this->resfullPermission . '.view'],
    //             'GET',
    //             $this->endpoint
    //         ],
    //         [
    //             [$this->resfullPermission . '.view'],
    //             'GET',
    //             $this->endpoint . '/1'
    //         ],
    //         [
    //             [$this->resfullPermission . '.create'],
    //             'POST',
    //             $this->endpoint
    //         ],
    //         [
    //             [$this->resfullPermission . '.update'],
    //             'PUT',
    //             $this->endpoint . '/1'
    //         ],
    //         [
    //             [$this->resfullPermission . '.delete'],
    //             'DELETE',
    //             $this->endpoint . '/1'
    //         ],
    //     ];
    // }

    /**
     * test not authen return 401
     * @dataProvider restfulEndpoidProvider
     * @param  array     $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorization($permissions, $method, $endpoint)
    // {
    //     $this->json($method, $endpoint, [], $this->headers)
    //          ->seeStatusCode(401);
    // }

    /**
     * test user not has permission
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testForbidden($permissions, $method, $endpoint)
    // {
    //     // $this->authWithAdminHasPermissions();
    //     $this->json($method, $endpoint, [])
    //          ->seeStatusCode(403);
    // }

    /**
     * test user as permission can access
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorized($permissions, $method, $endpoint)
    // {
    //     $this->authWithAdminHasPermissions($permissions);
    //     $response = $this->json($method, $endpoint, [], $this->headers);

    //     $this->assertTrue(in_array($response->response->getStatusCode(), [200, 422]));
    // }

    /**
     * test supper admin can access
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorizedWithSupperAdmin($permissions, $method, $endpoint)
    // {
    //     $response = $this->json($method, $endpoint, [], $this->headers);

    //     $this->assertTrue(in_array($response->response->getStatusCode(), [200, 422]));
    // }
}
