<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
	use ApiTrait;

	public function __construct(protected Position $position) {}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$positions = $this->position->paginate();
			return $this->apiResponse('200', 'All Positions', 'null', $positions);
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
	public function store(StorePositionRequest $request)
	{
		try {
			$position = $this->position->create([
				'name'        => $request->name,
				'description' => $request->description,
			]);
			return $this->apiResponse('200', 'Position created', 'null', $position);
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
	public function update(UpdatePositionRequest $request, $id)
	{
		try {
			$position = $this->position->find($id);
			if (!$position) {
				return $this->apiResponse('404', 'Position not found', 'null', 'null');
			}
			$position->update([
				'name'        => $request->name,
				'description' => $request->description,
			]);
			return $this->apiResponse('200', 'Position updated', 'null', $position);
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
			$position = $this->position->find($id);
			if (!$position) {
				return $this->apiResponse('404', 'Position not found', 'null', 'null');
			}
			$position->delete();
			return $this->apiResponse('200', 'Position deleted', 'null', 'null');
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Internal Server Error', $e->getMessage(), 'null');
		}
	}
}
