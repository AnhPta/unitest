<?php

namespace Tests\Feature\Api\Filters;

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
     * table
     * @var string
     */
    protected $table;
    /**
     * seeder data
     * @var array
     */
    protected $seederObject;
    /**
     * seeder data filter
     * @var array
     */
    protected $seederObjectFilter;
    /**
     * number row to test
     * @var [type]
     */
    protected $initDataNumber = 10;
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

    /**
     * create data for test by model factory & initDataNumber
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @return [type]     [description]
     */
    protected function geretateTestData()
    {
        factory($this->model, $this->initDataNumber)->create();
        factory($this->model)->create($this->seederObject);
        factory($this->model)->create($this->seederObjectFilter);
    }

    public function successResponse($meta = true)
    {
        if ($meta) {
            return [
                'code',
                'status',
                'data'  => [],
                'meta'  => [
                    'pagination'
                ]
            ];
        } else {
            return [
                'code',
                'status',
                'data'  => []
            ];
        }
    }

    /**
     * [testListtingFilter description]
     * @dataProvider listtingFilterUnLimit
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @param  [type]     $q [description]
     * @return [type]        [description]
     */
    public function testListtingFilter($q)
    {
        $params = [
            'q' => $q
        ];

        $this->json('GET', $this->endpoint . '?' . http_build_query($params))
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse());

        $numberEquals = 0;

        if ($q === '') {
            $numberEquals = 12;
        }
        if ($q === $this->seederObject['name']) {
            $numberEquals = 2;
        }
        if ($q === 'filterlinhtinh') {
            $numberEquals = 0;
        }

        $this->assertEquals($numberEquals, count($this->response->getData()->data));
    }

    /**
     * [testListtingFilterLimitSingle description]
     * @dataProvider listtingFilterLimitSingle
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @param  [type]     $q [description]
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
        ->seeJsonStructure($this->successResponse(false));

        $this->assertEquals(1, count($this->response->getData()->data));
    } 

    /**
     * [testListtingFilterUnLimit description]
     * @dataProvider listtingFilterUnLimit
     * @author AnhPta <tuananhsc96@gmail.com>
     * @date   2018-11-17
     * @param  [type]     $q [description]
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
        ->seeJsonStructure($this->successResponse(false));

        $numberEquals = 0;
        if ($q === '') {
            $numberEquals = 12;
        }
        if ($q === $this->seederObject['name']) {
            $numberEquals = 2;
        }
        if ($q === 'filterlinhtinh') {
            $numberEquals = 0;
        }
        
        $this->assertEquals($numberEquals, count($this->response->getData()->data));
    }
}
