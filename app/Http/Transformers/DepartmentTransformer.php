<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Departments\Department;
use App\Repositories\Positions\PositionRepository;

class DepartmentTransformer extends TransformerAbstract {

	protected $availableIncludes = [
		'branch'
		// 'employees',
	];

	public function transform(Department $department = null)
	{
		if (is_null($department)) {
			return [];
		}

		$data = [
			'id'          => $department->id,
			'name'        => $department->name,
			'branch_id'   => $department->branch_id,
			'branch_name' => $department->branch ? $department->branch->name : '',
			'status'      => $department->status,
			'status_txt'  => $department->getStatus(),
			'created_at'  => $department->created_at,
			'updated_at'  => $department->updated_at,
		];

		// if ($department->pivot && $department->pivot->position_id) {
		// 	$data['position_id'] = $department->pivot->position_id;
		// 	$data['position_name'] = app()->make(PositionRepository::class)->getById($data['position_id'])->name;
		// }

		return $data;
	}

	public function includeBranch(Department $department = null)
	{
		if (is_null($department)) {
			return $this->null();
		}

		return $this->item($department->branch, new BranchTransformer);
	}

	// public function includeEmployees(Department $department = null) {
	// 	if (is_null($department)) {
	// 		return $this->null();
	// 	}

	// 	return $this->collection($department->employees, new EmployeeTransformer);
	// }
}
