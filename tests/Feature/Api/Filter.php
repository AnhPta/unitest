<?php

namespace Tests\Feature\Api;

use TestCase;
// use Tests\Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class Filter extends TestCase
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
     * data filter search
     * @return array
     */
    // abstract public function listtingFilterSearchProvider();

    public function setUp()
    {
        parent::setUp();
        $this->geretateTestData();
    }

    protected function geretateTestData()
    {
        factory($this->model, 10)->create();
        factory($this->model)->create($this->seederObject);
        factory($this->model)->create($this->seederObjectFilter);
    }

    /**
     * [testListtingFilterLimitSingle description]
     * @dataProvider listtingFilterLimitSingle
     * @param  [type] $q     [description]
     * @return [type]        [description]
     */
    public function testListtingFilterLimitSingle($q)
    {
        $params = [
            'limit' => 0,
            'q' => $q
        ];

        $this->json('GET', $this->endpoint . '?' . http_build_query($params))
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'code',
            'status',
            'data'  => []
        ]);

        $this->assertEquals(1, count($this->response->getData()->data));
    } 

    /**
     * [testListtingFilterLimitSingle description]
     * @dataProvider listtingFilterUnLimit
     * @param  [type] $q     [description]
     * @return [type]        [description]
     */
    public function testListtingFilterUnLimit($q)
    {
        $params = [
            'limit' => -1,
            'q' => $q
        ];

        $this->json('GET', $this->endpoint . '?' . http_build_query($params))
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'code',
            'status',
            'data'  => []
        ]);

        $numberEquals = 0;
        if ($q === '') {
            $numberEquals = 12;
        }
        if ($q === 'abc') {
            $numberEquals = 2;
        }
        if ($q === 'filterlinhtinh') {
            $numberEquals = 0;
        }
        
        $this->assertEquals($numberEquals, count($this->response->getData()->data));
    }

    /**
     * [testListtingFilterLimitSingle description]
     * @dataProvider listtingFilterUnLimit
     * @param  [type] $q     [description]
     * @return [type]        [description]
     */
    public function testListtingFilter($q)
    {
        $params = [
            'q' => $q
        ];

        $this->json('GET', $this->endpoint . '?' . http_build_query($params))
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'code',
            'status',
            'data'  => [],
            'meta'  => [
                'pagination'
            ]
        ]);

        $numberEquals = 0;
        if ($q === '') {
            $numberEquals = 12;
        }
        if ($q === 'abc') {
            $numberEquals = 2;
        }
        if ($q === 'filterlinhtinh') {
            $numberEquals = 0;
        }

        $this->assertEquals($numberEquals, count($this->response->getData()->data));
    }
}
