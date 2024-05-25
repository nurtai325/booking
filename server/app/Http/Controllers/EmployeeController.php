<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function get() {
        $employees = Employee::all();
        return \response($employees->toJson())
            ->header('Content-Type', 'application/json');
    }
}
