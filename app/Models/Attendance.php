<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
	use HasFactory;

	protected $fillable
		= [
			'employee_id',
			'attendance_time',
			'leaving_time',
			'working_hours',
			'overtime',
			'attendance_date',
			'attendance_status',
		];

	public function employee()
	{
		return $this->belongsTo(User::class);
	}
}
