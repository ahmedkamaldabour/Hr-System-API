<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Attendance;
use App\Models\OverTimeType;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function dd;
use function public_path;
use function Symfony\Component\Translation\t;

class  SalaryController extends Controller
{
	use ApiTrait;

	public function __construct(protected Salary $salary) {}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$salaries = $this->salary::with('user')->paginate();
			return $this->apiResponse('200', 'All Salaries', 'NULL', $salaries);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	public function store(SalaryRequest $request)
	{
		try {
			$requests = $request->all();
			// return all overtime last 30 days
			$overTimes['last_30_days'] = Attendance::where("employee_id", $request->employee_id)
				->where("overtime", ">", 0)
				->whereDate("created_at", ">=", Carbon::now()->subDays(30))
				->get()
				->sum("overtime");
			$over_time_type_id = User::where("id", $request->employee_id)->first("over_time_type_id");
			$over_time_types = OverTimeType::where("id", $over_time_type_id["over_time_type_id"])->first("hour_price");
			$overtime = $overTimes["last_30_days"] * $over_time_types["hour_price"];

			$netSalary = $overtime + $request->amount + $request->bonus - $request->deduction;
			$requests["net_salary"] = $netSalary;
			$requests["over_time"] = $overtime;
			$requests["bonus"] = $request->bonus ? $request->bonus : 0;
			$requests["deduction"] = $request->deduction ? $request->deduction : 0;

			// create new salary
			$salary = $this->salary->create(
				[
					"employee_id" => $requests["employee_id"],
					"amount"      => $requests["amount"],
					"bonus"       => $requests["bonus"],
					"deduction"   => $requests["deduction"],
					"over_time"   => $requests["over_time"],
					"net_salary"  => $requests["net_salary"],
				]
			);
			return $this->apiResponse('201', 'Salary Created', 'NULL', $salary);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		try {
			// show custom salary ID
			$salary = $this->salary::find($id);
			if (!$salary) {
				return $this->apiResponse('404', 'Salary not found', 'null', 'null');
			}
			return $this->apiResponse('200', 'Data', null, $salary);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function employeeSalary($id)
	{
		try {
			// show custom salary ID
			$salary = $this->salary::where("employee_id", $id)->get();
			if ($salary->isEmpty()) {
				return $this->apiResponse('404', 'Salary not found For this Id', 'null', 'null');
			}
			return $this->apiResponse('200', 'ALL Salary For This employee', null, $salary);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}
}
