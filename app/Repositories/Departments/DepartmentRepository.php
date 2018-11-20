<?php

namespace App\Repositories\Departments;

use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    /**
     * Department model.
     * @var Model
     */
    protected $model;

    /**
     * DepartmentRepository constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        $this->model = $department;
    }

    /**
     * Lấy tất cả giá trị hợp lệ của trạng thái
     * @return string
     */
    public function getAllStatus()
    {
        return implode(',', Department::ALL_STATUS);
    }

    /**
     * Lấy phòng ban theo chi nhánh
     * @param  int    $id [description]
     * @return [type]     [description]
     */
    // public function getByBranch(int $id)
    // {
    //     return $this->model->where('branch_id', $id)->get();
    // }

    /**
     * Thay đổi trạng thái
     * @param  integer $id ID
     * @return [type]      [description]
     */
    public function changeStatus($id)
    {
        $department = parent::getById($id);
        if ($department->status == Department::ENABLE) {
            return parent::update($id, ['status' => Department::DISABLE]);
        } else {
            return parent::update($id, ['status' => Department::ENABLE]);
        }
    }
}
