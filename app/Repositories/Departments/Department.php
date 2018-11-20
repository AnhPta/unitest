<?php

namespace App\Repositories\Departments;

use App\Repositories\Entity;

class Department extends Entity {
	use FilterTrait, PresentationTrait;

	const ENABLE 	= 1;
	const DISABLE 	= 0;

	const ALL_STATUS = [
		self::DISABLE,
		self::ENABLE
	];
	const DISPLAY_STATUS = [
        self::DISABLE   => 'Không hiển thị',
        self::ENABLE    => 'Hiển thị'
	];

	/**
	 * Fillable definition
	 * @var array
	 */
	protected $fillable = [
		'name',
		'branch_id',
		'status'
	];

	/**
	 * Relationship with Branch
	 */
	public function branch()
	{
		return $this->belongsTo(\App\Repositories\Branches\Branch::class);
	}

	/**
	 * Relationship with Employee
	 */
	// public function employees()
	// {
	// 	return $this->belongsToMany(\App\Repositories\Employees\Employee::class, 'department_employee')->withPivot(['position_id', 'status']);
	// }
}
