<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAttendRequest;
use App\Http\Requests\AddLeaveRequest;
use App\Http\Traits\ApiTrait;
use App\Models\Attendance;
use App\Models\Period;
use App\Models\User;
use Carbon\Carbon;
use function strtotime;

class AttendanceController extends Controller
{
	use ApiTrait;

	public function __construct(protected Attendance $attendance, protected Period $period) {}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$attendances = $this->attendance->paginate();
			return $this->apiResponse('200', 'All Employees Attendance', 'null', $attendances);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error', $e->getMessage(), 'null');
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
			$attendance = $this->attendance->where('employee_id', $id)->latest()->orderBy('id', 'desc')->paginate();
			if ($attendance->count() === 0) {
				return $this->apiResponse('404', 'Employee Attendance Not Found', 'null', 'null');
			}
			return $this->apiResponse('200', 'Employee Attendance', 'null', $attendance);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error', $e->getMessage(), 'null');
		}
	}

	public function addAttend(AddAttendRequest $request)
	{
		try {
			$attendance = $this->attendance->create(
				[
					'employee_id'       => $request->employee_id,
					'attendance_time'   => $request->attendance_time,
					'attendance_date'   => $request->attendance_date,
					'attendance_status' => $request->attendance_time ? 'worked' : 'absent',
				]
			);
			return $this->apiResponse('200', 'Employee Attendance Added', 'null', $attendance);
		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error', $e->getMessage(), 'null');
		}
	}

	public function addLeave(AddLeaveRequest $request, $id)
	{
		try {
			$attendance = $this->attendance->where('employee_id', $id)->latest()->orderBy('id', 'desc')->first();
			if (!$attendance) {
				return $this->apiResponse('404', 'Employee Attendance Not Found', 'null', 'null');
			}
			// check if employee is already on leave
			if ($attendance->leave_time) {
				return $this->apiResponse('400', 'Employee Already On Leave', 'null', 'null');
			}
			$attendance->leaving_time = $request->leaving_time;
			if ($attendance->attendance_status == 'worked') {
				$attendance->attendance_status = 'present';
			} elseif ($attendance->attendance_status == 'absent') {
				return $this->apiResponse('400', 'Employee did not come today', 'null', 'null');
			}
			$attendance->save();

			// working hours using carbon diff in hours method
			$attendance->working_hours = Carbon::parse($attendance->attendance_time)->diffInHours($attendance->leaving_time);
			$employee_id = $attendance->employee_id;
			$period_id = User::find($employee_id)->period_id;
			$emp_period_endTime = $this->period->find($period_id)->end_time;
			// compare leave time with period end time if leave time is greater than period end time add diff in hours to overtime hours
			$leave_time = strtotime($attendance->leaving_time);
			$period_end_time = strtotime($emp_period_endTime);
			if ($leave_time > $period_end_time) {
				$attendance->overtime = Carbon::parse($attendance->leaving_time)->diffInHours($emp_period_endTime);
				$attendance->save();
			}
			return $this->apiResponse('200', 'Employee Leave Added', 'null', $attendance);

		} catch (\Exception $e) {
			return $this->apiResponse('500', 'Error', $e->getMessage(), 'null');
		}
	}

}
