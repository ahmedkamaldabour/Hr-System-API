<?php

namespace App\Http\Controllers;

use App\Http\Requests\SotreOverTimeRequest;
use App\Http\Requests\UpdateOverTimeRequest;
use App\Http\Traits\ApiTrait;
use App\Models\OverTimeType;
use Illuminate\Http\Request;

class OverTimeTypeController extends Controller
{
	use ApiTrait;

	public function __construct(protected OverTimeType $overtime_type) {}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$overTimes = $this->overtime_type::get();
			return $this->apiResponse('200', 'All OverTime Types', 'null', $overTimes);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SotreOverTimeRequest $request)
	{
		try {
			$overTime = $this->overtime_type::create(
				[
					'type'       => $request->type,
					'hour_price' => $request->hour_price,
				]
			);
			return $this->apiResponse('200', 'OverTime Type Created', 'null', $overTime);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int                       $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateOverTimeRequest $request, $id)
	{
		try {
			$overTime = $this->overtime_type::find($id);
			if (!$overTime) {
				return $this->apiResponse('404', 'OverTime Type Not Found', 'null', 'null');
			}
			$overTime->update(
				[
					'type'       => $request->type,
					'hour_price' => $request->hour_price,
				]
			);
			return $this->apiResponse('200', 'OverTime Type Updated', 'null', $overTime);

		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
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
			$overTime = $this->overtime_type::find($id);
			if (!$overTime) {
				return $this->apiResponse('404', 'OverTime Type Not Found', 'null', 'null');
			}
			$overTime->delete();
			return $this->apiResponse('200', 'OverTime Type Deleted', 'null', 'null');
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}
}
