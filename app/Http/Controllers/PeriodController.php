<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Period;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class PeriodController extends Controller
{
	use ApiTrait;

	public function __construct(protected Period $period) {}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$periods = $this->period::get();
			return $this->apiResponse('200', 'All Periods', 'null', $periods);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error!', $e->getMessage(), 'null');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePeriodRequest $request)
	{
		try {
			$period = $this->period::create(
				[
					'period_name' => $request->period_name,
					'start_time'  => $request->start_time,
					'end_time'    => $request->end_time,
				]
			);
			return $this->apiResponse('200', 'Period Created', 'null', $period);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error!', $e->getMessage(), 'null');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int                       $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePeriodRequest $request, $id)
	{
		try {
			$period = $this->period::find($id);
			if (!$period) {
				return $this->apiResponse('404', 'Period Not Found', 'null', 'null');
			}
			$period->update(
				[
					'period_name' => $request->period_name,
					'start_time'  => $request->start_time,
					'end_time'    => $request->end_time,
				]
			);
			return $this->apiResponse('200', 'Period Updated', 'null', $period);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error!', $e->getMessage(), 'null');
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
			$period = $this->period::find($id);
			if (!$period) {
				return $this->apiResponse('404', 'Period Not Found', 'null', 'null');
			}
			$period->delete();
			return $this->apiResponse('200', 'Period Deleted', 'null', 'null');
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error!', $e->getMessage(), 'null');
		}
	}
}
