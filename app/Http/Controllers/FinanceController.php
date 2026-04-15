<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function fees()
    {
        return view('module-placeholder', ['moduleName' => 'Fee Collection']);
    }

    public function expenses()
    {
        return view('module-placeholder', ['moduleName' => 'Expense Management']);
    }
}