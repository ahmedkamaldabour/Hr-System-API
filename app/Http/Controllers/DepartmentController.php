<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
	use ApiTrait;

	protected Department $department;

	public function __construct(Department $department)
	{
		$this->department = $department;
	}

	public function index()
	{
		try {
			// return all departments
			$departments = $this->department->get();
			return $this->apiResponse('200', 'All Departments', 'NULL', $departments);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}

	}

	public function store(DepartmentRequest $request)
	{
		try {
			// create new department
			$department = $this->department->create([
				'name' => $request->name,
			]);
			return $this->apiResponse('201', 'Department Created', 'NULL', $department);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	public function update(DepartmentRequest $request, $id)
	{
		try {
			// update department
			$department = $this->department->find($id);
			if ($department) {
				$department->update([
					'name' => $request->name,
				]);
				return $this->apiResponse('200', 'Department Updated', 'NULL', $department);
			} else {
				return $this->apiResponse('404', 'Department Not Found', 'NULL', 'NULL');
			}
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	public function destroy($id)
	{
		try {
			// delete department
			$department = $this->department->find($id);
			if ($department) {
				$department->delete();
				return $this->apiResponse('200', 'Department Deleted', 'NULL', 'NULL');
			} else {
				return $this->apiResponse('404', 'Department Not Found', 'NULL', 'NULL');
			}
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	public function department_employees($id)
	{
		try {
			// get department by id
			$department = $this->department->find($id);
			if ($department) {
				// get department employees
				$employees = $department->users()->with('branch')->get();
				return $this->apiResponse('200', 'ALL Employees in '.$department->name.' department', 'NULL', $employees);
			} else {
				return $this->apiResponse('404', 'Department Not Found', 'NULL', 'NULL');
			}
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}
}
