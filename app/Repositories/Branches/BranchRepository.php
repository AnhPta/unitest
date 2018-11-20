<?php

namespace App\Repositories\Branches;

use App\Repositories\BaseRepository;
// use App\Repositories\UploadTrait;

class BranchRepository extends BaseRepository
{
    // use UploadTrait;
    /**
     * Branch model.
     * @var Model
     */
    protected $model;

    /**
     * BranchRepository constructor.
     * @param Branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->model = $branch;
    }

    /**
     * Lấy tất cả giá trị hợp lệ của trạng thái
     * @return string
     */
    public function getAllStatus()
    {
        return implode(',', Branch::ALL_STATUS);
    }

    /**
     * Cập nhật chi nhánh chính (cũ) thành chi nhánh phụ
     * @return [type] [description]
     */
    public function updateBranchMainOld()
    {
        $branchMain = $this->model->where('type', Branch::MAIN)->get();
        foreach ($branchMain as $key => $value) {
            parent::update($value->id, ['type' => Branch::NOT_MAIN]);
        }
    }

    /**
     * Lưu thông tin 1 chi nhánh mới
     * Nếu đây là chi nhánh chính thì cập nhật chi nhánh chính (cũ)
     * thành chi nhánh phụ bằng cách gọi function updateBranchMainOld()
     * @param  array $data
     * @return Eloquent
     */
    public function store($data)
    {
        if ($data['type'] == Branch::MAIN) {
            $this->updateBranchMainOld();
        }
        return parent::store($data);
    }

    /**
     * Cập nhật thông tin 1 chi nhánh
     * Nếu đây là chi nhánh chính thì cập nhật chi nhánh chính (cũ)
     * thành chi nhánh phụ bằng cách($id, ['status'  gọi function updateBranchMainOld()
     * @param  integer $id  ID chi nhánh
     * @return bool
     */
    public function update($id, $data, $excepts = [], $only = [])
    {
        if ($data['type'] == Branch::MAIN) {
            $this->updateBranchMainOld();
        }
        return parent::update($id, $data);
    }

    /**
     * Thay đổi trạng thái
     * @param  integer $id ID
     * @return [type]      [description]
     */
    public function changeStatus($id)
    {
        $branch = parent::getById($id);
        if ($branch->status == Branch::ENABLE) {
            return parent::update($id, ['status' => Branch::DISABLE]);
        } else {
            return parent::update($id, ['status' => Branch::ENABLE]);
        }
    }

    /**
     * Thay đổi loại chi nhánh
     * @param  integer $id id
     * @return [type]     [description]
     */
    public function changeBranchMain($id)
    {
        $branch = parent::getById($id);
        if ($branch->type == Branch::NOT_MAIN) {
            $this->updateBranchMainOld();
            return parent::update($id, ['type' => Branch::MAIN]);
        } else {
            return $branch;
        }
    }
}
