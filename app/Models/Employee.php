<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuid;

    protected $table = "Employee";

    public $timestamps = false;

    protected $fillable = [
        "NIK",
        "Full_name",
        "Dept_id",
        "Designation",
        "Gender",
        "Birth_place",
        "Birth_date",
        "Phone_no",
        "Join_date",
        "Join_end"
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'Dept_id', 'id');
    }
}
