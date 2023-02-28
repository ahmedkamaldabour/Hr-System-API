<?php

namespace App\Http\Controllers\api\Vacations;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacationRequest;
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
		$vacations = Vacation::paginate();
		return $this->apiResponse('200', 'Data returned successfully', null, $vacations);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(VacationRequest $request)
	{
		try {
			$requests = $request->all();
			$vacations = Vacation::create($requests);
			return $this->apiResponse('201', 'Department Created', 'NULL', $vacations);
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
	public function update(VacationRequest $request, $id)
	{
		try {
			$vacation = Vacation::find($id);
			if (!$vacation) {
				return $this->apiResponse('404', 'vacation not found', 'null', 'null');
			}
			$requests = $request->all();
			$vacation->update($requests);
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
		$vacation = Vacation::find($id);
		if (!$vacation) {
			return $this->apiResponse('404', 'vacation not found', 'null', 'null');
		}
		$vacation->delete();
		return $this->apiResponse('200', 'Data deleted successfully', null, $vacation);
	}
}
