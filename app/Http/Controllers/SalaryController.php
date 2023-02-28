<?php

namespace App\Http\Controllers\api\Salary;

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

class SalaryController extends Controller
{
	use ApiTrait;

	protected $salary;

	public function __construct(Salary $salary)
	{
		return $this->salary = $salary;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// return all data as paginate
		$salary = $this->salary::paginate();

		return $this->apiResponse('200', 'Data returned successfully', null, $salary);
	}

	public function store(SalaryRequest $request)
	{
		try {
			$requests = $request->all();

			// return all overtime last 30 days
			$overTimes["last_30_days"] = Attendance::where("employee_id", $request->employee_id)
				->where('attendance_date', '>=', Carbon::now()->subdays(30))->sum("overtime");

			$over_time_type_id = User::where("id", $request->employee_id)->first("over_time_type_id");

			$over_time_types = OverTimeType::where("id", $over_time_type_id["over_time_type_id"])->first("hour_price");

			$overtime = $overTimes["last_30_days"] * $over_time_types["hour_price"];

			$netSalary = $overtime + $request->amount + $request->bonus - $request->deduction;
			$requests["net_salary"] = $netSalary;
			$requests["over_time"] = $overtime;

			// create new salary
			$salary = $this->salary->create($requests);
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
		// show custom salary ID
		$salary = $this->salary::find($id);

		if (!$salary) {
			return $this->apiResponse('404', 'Salary not found', 'null', 'null');
		}
		$salary->delete();
		return $this->apiResponse('200', 'Data deleted successfully', null, $salary);
	}
}
