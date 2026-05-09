<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, HasUuid;

    protected $table = "Attendance";

    protected $fillable = [
        "Employee_id",
        "Time_in",
        "Time_out"
    ];
}
