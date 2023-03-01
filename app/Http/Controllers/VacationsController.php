<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVacationRequest;
use App\Http\Requests\updateVacationRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Vacation;
use Illuminate\Http\Request;

class VacationsController extends Controller
{
	use ApiTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$vacations = Vacation::paginate();
			// get employee name and department name
			foreach ($vacations as $vacation) {
				$vacation->employee_name = $vacation->employee->name;
			}
			return $this->apiResponse('200', 'All vacations', 'null', $vacations);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreVacationRequest $request)
	{
		try {
			$vacations = Vacation::create(
				[
					'employee_id'   => $request->employee_id,
					'start_date'    => $request->start_date,
					'end_date'      => $request->end_date,
					'vacation_type' => $request->vacation_type ? $request->vacation_type : 'pending',
				]
			);
			// get employee name rather than employee id
			$vacations->employee_name = $vacations->employee->name;
			return $this->apiResponse('201', 'Vacation created', 'NULL', $vacations);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int                       $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateVacationRequest $request, $id)
	{
		try {
			$vacation = Vacation::find($id);
			if (!$vacation) {
				return $this->apiResponse('404', 'vacation not found', 'null', 'null');
			}
			$vacation->update([
				'start_date'    => $request->start_date ? $request->start_date : $vacation->start_date,
				'end_date'      => $request->end_date ? $request->end_date : $vacation->end_date,
				'vacation_type' => $request->vacation_type ? $request->vacation_type : 'pending',
			]);
			$vacations->employee_name = $vacations->employee->name;
			return $this->apiResponse('201', 'vacation updated', 'NULL', $vacation);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$vacation = Vacation::find($id);
			if (!$vacation) {
				return $this->apiResponse('404', 'vacation not found', 'null', 'null');
			}
			$vacation->delete();
			return $this->apiResponse('200', 'vacation deleted', 'NULL', 'NULL');
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'NULL');
		}
	}
}
