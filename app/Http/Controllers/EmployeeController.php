<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Traits\ApiTrait;
use App\Models\User;
use Illuminate\Http\Request;
use function redirect;

class EmployeeController extends Controller
{
	use ApiTrait;

	protected User $employee;

	public function __construct(User $employee)
	{
		$this->employee = $employee;
	}

	public function index()
	{
		try {
			// get all employees
			$employees = $this->employee::paginate();
			return $this->apiResponse('200', 'All employees', 'null', $employees);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	public function store(EmployeeRequest $request)
	{
		try {
			// create new employee
			$employee = $this->employee::create([
				'name'          => $request->name,
				'email'         => $request->email,
				'password'      => bcrypt($request->password),
				'department_id' => $request->department_id,
				'branch_id'     => $request->branch_id,
				'role'          => $request->role,
				'phone'         => $request->phone,
				'rate'          => $request->rate,
				'salary'        => $request->salary,
			]);
			return $this->apiResponse('200', 'Employee created', 'null', $employee);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	public function update(EmployeeRequest $request, $id)
	{
		try {
			// get employee by id
			$employee = $this->employee::find($id);
			// check if employee exists
			if (!$employee) {
				return $this->apiResponse('404', 'Employee not found', 'null', 'null');
			}
			// update employee
			$employee->update([
				'name'          => $request->name,
				'email'         => $request->email,
				'department_id' => $request->department_id,
				'branch_id'     => $request->branch_id,
				'role'          => $request->role,
				'phone'         => $request->phone,
				'rate'          => $request->rate,
				'salary'        => $request->salary,
			]);
			// check if password is not empty and update it if it is not empty
			if ($request->password && !empty($request->password)) {
				$employee->update([
					'password' => bcrypt($request->password),
				]);
			}
			return $this->show($employee->id);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	public function show($id)
	{
		try {
			// get employee by id
			$employee = $this->employee::with('branch', 'department')->find($id);
			// check if employee exists
			if (!$employee) {
				return $this->apiResponse('404', 'Employee not found', 'null', 'null');
			}
			return $this->apiResponse('200', 'Employee', 'null', $employee);

		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	public function destroy($id)
	{
		try {
			// get employee by id
			$employee = $this->employee::find($id);
			// check if employee exists
			if (!$employee) {
				return $this->apiResponse('404', 'Employee not found', 'null', 'null');
			}
			// delete employee
			$employee->delete();
			return $this->apiResponse('200', 'Employee deleted', 'null', 'null');
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}
}
