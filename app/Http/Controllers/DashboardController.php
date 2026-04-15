<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Safe Data Fetching
        // We use 'try-catch' so the dashboard NEVER crashes, even if tables are empty.
        try {
            $totalStudents = DB::table('students')->count();
            $recentStudents = DB::table('students')->orderBy('created_at', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            $totalStudents = 0;
            $recentStudents = [];
        }

        try {
            $totalStaff = DB::table('users')->count(); // Assuming staff are users
        } catch (\Exception $e) {
            $totalStaff = 0;
        }

        // 2. Mock Data for incomplete features (Placeholders)
        $totalClasses = 12; 
        $pendingAlerts = 3; 

        // 3. Send data to the view
        return view('dashboard', compact(
            'totalStudents', 
            'recentStudents', 
            'totalStaff', 
            'totalClasses', 
            'pendingAlerts'
        ));
    }
}