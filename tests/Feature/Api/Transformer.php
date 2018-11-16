<?php

namespace Tests\Feature\Api;

use TestCase;
// use Tests\Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class Transformer extends TestCase
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
     * seeder data insert, update,show
     * @var array
     */
    protected $seederObject;
    /**
     * data transform
     * @var array
     */
    protected $transform;
    /**
     * params of testTransformisNull
     * @var array
     */
    protected $params_transform_is_null;

    /**
     * data relationship belongsTo
     * @return array
     */
    // abstract public function belongsToDataProvider();

    /**
     * create data for test by model factory
     */
    protected function geretateTestData()
    {
        factory($this->model, 10)->create();
        factory($this->model)->create($this->seederObject);
    }

    public function setUp()
    {
        parent::setUp();
        $this->geretateTestData();
    }

    /**
     * Model is null
     * @return [type] [description]
     */
    public function testTransformIsNull()
    {
        // $this->authWithSupperAdmin();
        $this->json('GET', $this->endpoint . '?' . http_build_query($this->params_transform_is_null))
              ->seeStatusCode(200)
              ->seeJsonStructure([
                'code',
                'data'  => []
            ]);

            $this->assertEquals(0, count($this->response->getData()->data));
    }

    /**
     * test include of transformer
     * @dataProvider belongsToDataProvider
     * @param  [type] $info_factory     array           infomation array of the factories
     * @param  [type] $params           array           params query request
     * @param  [type] $transform_part   array           transform of model belongsTo
     */
    // public function testTransformer($info_factory , $params, $transform_part)
    // {
    //     // $this->authWithSupperAdmin();

    //     foreach ($info_factory as $key => $info) {
    //         factory($info['class'], $info['init_data'])->create($info['value']);
    //     }

    //     $this->json('GET', $this->endpoint . '?' . http_build_query($params))
    //           ->seeStatusCode(200)
    //           ->seeJsonStructure([
    //             'code',
    //             'status',
    //             'data'  => [
    //                 array_merge($this->transform, $transform_part)
    //             ],
    //             'meta'  => [
    //                 'pagination'
    //             ]
    //         ]);
    //         // dd($this->response->getData()->data);
    //     // $this->assertCount(1, $this->response->getData()->data);
    // }
}
