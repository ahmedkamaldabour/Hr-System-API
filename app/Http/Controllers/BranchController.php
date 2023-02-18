<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Branch;
use Illuminate\Http\Request;
use function dd;

class BranchController extends Controller
{
	use ApiTrait;

	protected Branch $branch;

	public function __construct(Branch $branch)
	{
		$this->branch = $branch;
	}

	public function index()
	{
		try {
			$branches = $this->branch::get();
			return $this->apiResponse('200', 'All branches', 'null', $branches);
		} catch (\Exception $e) {
			return $this->errorResponse($e->getMessage());
		}

	}

	public function store(BranchRequest $request)
	{
		try {
			$branch = $this->branch::create([
				'name' => $request->name,
			]);
			return $this->apiResponse('200', 'Branch created', 'null', $branch);
		} catch (\Exception $e) {
			return $this->errorResponse($e->getMessage());
		}

	}

	public function update(BranchRequest $request, $id)
	{
		try {
			$branch = $this->branch::find($id);
			if ($branch) {
				$branch->update([
					'name' => $request->name,
				]);
				return $this->apiResponse('200', 'Branch updated', 'null', $branch);
			} else {
				return $this->apiResponse('404', 'Branch not found', 'null', 'null');
			}
		} catch (\Exception $e) {
			return $this->errorResponse($e->getMessage());
		}
	}

	public function destroy($id)
	{
		try {
			$branch = $this->branch::find($id);
			if ($branch) {
				$branch->delete();
				return $this->apiResponse('200', 'Branch deleted', 'null', 'null');
			} else {
				return $this->apiResponse('404', 'Branch not found', 'null', 'null');
			}
		} catch (\Exception $e) {
			return $this->errorResponse($e->getMessage());
		}
	}

	public function branch_employees($id)
	{
		try {
			$branch = $this->branch::find($id);
			if ($branch) {
				$employees = $branch->users()->with('department')->get();
				return $this->apiResponse('200', 'All employees in '.$branch->name.' Branch', 'null', $employees);
			} else {
				return $this->apiResponse('404', 'Branch not found', 'null', 'null');
			}
		} catch (\Exception $e) {
			return $this->errorResponse($e->getMessage());
		}
	}
}
