<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\Departments\Department;
use App\Repositories\Branches\Branch;
use App\Repositories\Departments\DepartmentRepository;
use App\Http\Transformers\DepartmentTransformer;

class DepartmentController extends ApiController
{
    protected $validationRules = [
        'name'      => 'required',
        'branch_id' => 'required|exists:branches,id',
        'status'    => 'in:',
    ];
    protected $validationMessages = [
        'name.required'      => 'Tên phòng ban không được để trống',
        'branch_id.required' => 'Vui lòng chọn chi nhánh',
        'branch_id.exists'   => 'Chi nhánh không tồn tại trên hệ thống',
        'status.in'          => 'Trạng thái không hợp lệ',
    ];

    /**
     * DepartmentController constructor.
     * @param DepartmentRepository $department
     */
    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
        $this->setTransformer(new DepartmentTransformer);
    }

    public function index(Request $request)
    {
        // $this->authorize('department.view');
        $pageSize = $request->get('limit', 25);
        return $this->successResponse($this->department->getByQuery($request->all(), $pageSize));
    }

    public function show($id)
    {
        try {
            // $this->authorize('department.view');
            return $this->successResponse($this->department->getById($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function store(Request $request)
    {
        $this->validationRules['status'] .= $this->department->getAllStatus();
        try {
            // $this->authorize('department.create');
            $this->validate($request, $this->validationRules, $this->validationMessages);
            $data = $this->department->store($request->all());

            return $this->successResponse($data);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return $this->errorResponse([
                'errors' => $validationException->validator->errors(),
                'exception' => $validationException->getMessage()
            ]);
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function update($id, Request $request)
    {
        $this->validationRules['status'] .= $this->department->getAllStatus();
        try {
            // $this->authorize('department.update');
            $this->validate($request, $this->validationRules, $this->validationMessages);
            $model = $this->department->update($id, $request->all());

            return $this->successResponse($model);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return $this    ->errorResponse([
                'errors' => $validationException->validator->errors(),
                'exception' => $validationException->getMessage()
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function destroy($id)
    {
        try{
            $this->department->delete($id);
            return $this->deleteResponse();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function changeStatus($id)
    {
        try {
            // $this->authorize('department.update');
            $data = $this->department->changeStatus($id);

            return $this->successResponse($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }
    
    // public function getByBranch(Request $request, $id)
    // {
    //     $id = (int)$id;
        // $this->authorize('department.view');
    //     return $this->successResponse($this->department->getByBranch($id));
    // }

    // public function getByBranch(Request $request, $id)
    // {
    //     return $this->model->getByBranch($id);
    // }
}
