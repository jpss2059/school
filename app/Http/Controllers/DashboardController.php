<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Examination;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentAcademicYear = AcademicYear::where('is_current', true)->first();
        
        if (!$currentAcademicYear) {
            $currentAcademicYear = AcademicYear::latest()->first();
        }
        
        $academicYearId = $currentAcademicYear?->id;
        
        $classStats = ClassModel::select('classes.id', 'classes.name')
            ->selectRaw('COUNT(CASE WHEN students.gender = "male" AND students.created_at >= ? THEN 1 END) as new_male', [$currentAcademicYear?->start_date ?? now()])
            ->selectRaw('COUNT(CASE WHEN students.gender = "female" AND students.created_at >= ? THEN 1 END) as new_female', [$currentAcademicYear?->start_date ?? now()])
            ->selectRaw('COUNT(CASE WHEN students.gender = "male" AND students.created_at < ? THEN 1 END) as old_male', [$currentAcademicYear?->start_date ?? now()])
            ->selectRaw('COUNT(CASE WHEN students.gender = "female" AND students.created_at < ? THEN 1 END) as old_female', [$currentAcademicYear?->start_date ?? now()])
            ->leftJoin('students', 'classes.id', '=', 'students.class_id')
            ->where('classes.is_active', true)
            ->groupBy('classes.id', 'classes.name')
            ->get();
        
        $totalStudents = Student::where('is_active', true)->count();
        $totalClasses = ClassModel::where('is_active', true)->count();
        $totalExams = Examination::where('academic_year_id', $academicYearId)->count();
        
        // Financial data for chart (placeholder - you would replace with actual data)
        $financialData = [
            'debit' => 50,
            'credit' => 7.28,
            'balance' => 42.72,
        ];
        
        // Get today's birthdays
        $todayBirthdays = Student::whereRaw('MONTH(date_of_birth) = MONTH(CURRENT_DATE()) AND DAY(date_of_birth) = DAY(CURRENT_DATE())')
            ->where('is_active', true)
            ->get();
        
        return view('dashboard', compact(
            'classStats', 
            'totalStudents', 
            'totalClasses', 
            'totalExams', 
            'financialData',
            'todayBirthdays',
            'currentAcademicYear'
        ));
    }
}
