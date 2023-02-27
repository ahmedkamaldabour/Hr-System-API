<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable
		= [
			'name',
			'email',
			'password',
			'branch_id',
			'department_id',
			'phone',
			'address',
			'role',
			'salary',
			'rate',
			'image',
		];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden
		= [
			'password',
			'remember_token',
			'branch_id',
			'department_id',
			'created_at',
			'updated_at',
		];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts
		= [
			'email_verified_at' => 'datetime',
		];

	// user belongs to one branch
	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	// user belongs to one department
	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	// user has many attendances
	public function attendances()
	{
		return $this->hasMany(Attendance::class);
	}

	// user has one over time type
	public function overTimeType()
	{
		return $this->hasOne(OverTimeType::class);
	}

	// user has period
	public function period()
	{
		return $this->hasOne(Period::class);
	}

	// user has many vacations
	public function vacations()
	{
		return $this->hasMany(Vacation::class);
	}

	// user has many salaries
	public function salaries()
	{
		return $this->hasMany(Salary::class);
	}
}
