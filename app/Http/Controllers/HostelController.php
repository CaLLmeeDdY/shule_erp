<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index() {
        return view('module-placeholder', ['moduleName' => 'Hostel Management']);
    }
}