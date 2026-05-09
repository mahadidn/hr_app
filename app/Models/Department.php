<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, HasUuid;

    protected $table = "Department";

    public $timestamps = false;

    protected $fillable = [
        "Dept_name"
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'Dept_id', 'id');
    }
}
