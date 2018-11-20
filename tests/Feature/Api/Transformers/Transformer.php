<?php

namespace Tests\Feature\Api\Transformers;

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
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    protected function geretateTestData()
    {
        factory($this->model)->create($this->seederObject);
    }

    public function setUp()
    {
        parent::setUp();
        $this->geretateTestData();
    }

    /**
     * Model is null
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    public function testTransformIsNull()
    {
        $this->json('GET', $this->endpoint . '?' . http_build_query($this->params_transform_is_null))
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'code',
            'data'  => []
        ]);
        $relationship = $this->params_transform_is_null['include'];

        $this->assertCount(0, $this->response->getData()->data->$relationship->data);
    }

    /**
     * test include of transformer
     * @dataProvider belongsToDataProvider
     * @param  [type] $info_factory     array           infomation array of the factories
     * @param  [type] $params           array           params query request
     * @param  [type] $transform_part   array           transform of model belongsTo
     */
    public function testTransformer($info_factory , $params, $transform_part)
    {
        // $this->authWithSupperAdmin();

        factory($info_factory['class'], $info_factory['init_data'])->create($info_factory['value']);

        $this->json('GET', $this->endpoint . '?' . http_build_query($params))
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'code',
            'status',
            'data'  => [
                array_merge($this->transform, $transform_part)
            ],
            'meta'  => [
                'pagination'
            ]
        ]);
        $relationship = $this->params_transform_is_null['include'];

        $this->assertEquals($info_factory['init_data'], count($this->response->getData()->data[0]->$relationship->data));
    }
}
