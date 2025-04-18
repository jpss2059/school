<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\DivisionSetting;
use App\Models\Examination;
use App\Models\ExtraActivity;
use App\Models\GradeSetting;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentExtraActivity;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function progressCard(Request $request)
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $examinations = Examination::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->where('status', 'active')
            ->orderBy('exam_date')
            ->get();
            
        $classes = ClassModel::where('is_active', true)->get();
        $sections = collect();
        $students = collect();
        
        if ($request->has('academic_year_id') && $request->has('class_id')) {
            $sections = Section::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
                
            $studentsQuery = Student::where('class_id', $request->class_id)
                ->where('is_active', true);
                
            if ($request->has('section_id') && $request->section_id) {
                $studentsQuery->where('section_id', $request->section_id);
            }
            
            $students = $studentsQuery->orderBy('roll_number')->get();
        }
        
        $student = null;
        $subjects = collect();
        $marks = collect();
        $extraActivities = collect();
        
        if ($request->has('student_id') && $request->student_id) {
            $student = Student::with(['class', 'section'])->find($request->student_id);
            
            if ($student) {
                $subjects = Subject::where('class_id', $student->class_id)
                    ->where('is_active', true)
                    ->get();
                    
                $marks = Mark::where('student_id', $student->id)
                    ->where('academic_year_id', $request->academic_year_id)
                    ->when($request->has('examination_id') && $request->examination_id, function($query) use ($request) {
                        return $query->where('examination_id', $request->examination_id);
                    })
                    ->get()
                    ->groupBy(['examination_id', 'subject_id']);
                    
                $extraActivities = StudentExtraActivity::with('extraActivity')
                    ->where('student_id', $student->id)
                    ->where('academic_year_id', $request->academic_year_id)
                    ->get();
            }
        }
        
        return view('reports.progress_card', compact(
            'academicYears',
            'currentAcademicYear',
            'examinations',
            'classes',
            'sections',
            'students',
            'student',
            'subjects',
            'marks',
            'extraActivities'
        ));
    }
    
    public function marksLedger(Request $request)
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $examinations = Examination::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->where('status', 'active')
            ->orderBy('exam_date')
            ->get();
            
        $classes = ClassModel::where('is_active', true)->get();
        $sections = collect();
        $subjects = collect();
        $students = collect();
        $marks = collect();
        
        if ($request->has('academic_year_id') && $request->has('examination_id') && $request->has('class_id')) {
            $sections = Section::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
                
            $subjects = Subject::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
                
            $studentsQuery = Student::where('class_id', $request->class_id)
                ->where('is_active', true);
                
            if ($request->has('section_id') && $request->section_id) {
                $studentsQuery->where('section_id', $request->section_id);
            }
            
            $students = $studentsQuery->orderBy('roll_number')->get();
            
            if ($students->isNotEmpty() && $subjects->isNotEmpty()) {
                $marks = Mark::where('academic_year_id', $request->academic_year_id)
                    ->where('examination_id', $request->examination_id)
                    ->where('class_id', $request->class_id)
                    ->when($request->has('section_id') && $request->section_id, function($query) use ($request) {
                        return $query->where('section_id', $request->section_id);
                    })
                    ->get()
                    ->groupBy(['student_id', 'subject_id']);
            }
        }
        
        return view('reports.marks_ledger', compact(
            'academicYears',
            'currentAcademicYear',
            'examinations',
            'classes',
            'sections',
            'subjects',
            'students',
            'marks'
        ));
    }
    
    public function marksAnalysis(Request $request)
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $examinations = Examination::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->where('status', 'active')
            ->orderBy('exam_date')
            ->get();
            
        $classes = ClassModel::where('is_active', true)->get();
        $sections = collect();
        $subjects = collect();
        $analysisData = collect();
        
        if ($request->has('academic_year_id') && $request->has('examination_id') && $request->has('class_id')) {
            $sections = Section::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
                
            $subjects = Subject::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
                
            if ($subjects->isNotEmpty()) {
                foreach ($subjects as $subject) {
                    $query = DB::table('marks')
                        ->select(
                            DB::raw('COUNT(*) as total_students'),
                            DB::raw('SUM(CASE WHEN percentage >= 90 THEN 1 ELSE 0 END) as a_plus'),
                            DB::raw('SUM(CASE WHEN percentage >= 80 AND percentage < 90 THEN 1 ELSE 0 END) as a'),
                            DB::raw('SUM(CASE WHEN percentage >= 70 AND percentage < 80 THEN 1 ELSE 0 END) as b_plus'),
                            DB::raw('SUM(CASE WHEN percentage >= 60 AND percentage < 70 THEN 1 ELSE 0 END) as b'),
                            DB::raw('SUM(CASE WHEN percentage >= 50 AND percentage < 60 THEN 1 ELSE 0 END) as c_plus'),
                            DB::raw('SUM(CASE WHEN percentage >= 40 AND percentage < 50 THEN 1 ELSE 0 END) as c'),
                            DB::raw('SUM(CASE WHEN percentage >= 35 AND percentage < 40 THEN 1 ELSE 0 END) as d'),
                            DB::raw('SUM(CASE WHEN percentage < 35 THEN 1 ELSE 0 END) as f'),
                            DB::raw('SUM(CASE WHEN is_absent = 1 THEN 1 ELSE 0 END) as absent'),
                            DB::raw('AVG(percentage) as average_percentage')
                        )
                        ->where('academic_year_id', $request->academic_year_id)
                        ->where('examination_id', $request->examination_id)
                        ->where('class_id', $request->class_id)
                        ->where('subject_id', $subject->id);
                        
                    if ($request->has('section_id') && $request->section_id) {
                        $query->where('section_id', $request->section_id);
                    }
                    
                    $analysisData[$subject->id] = $query->first();
                }
            }
        }
        
        return view('reports.marks_analysis', compact(
            'academicYears',
            'currentAcademicYear',
            'examinations',
            'classes',
            'sections',
            'subjects',
            'analysisData'
        ));
    }
    
    public function subjectPrinting(Request $request)
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $classes = ClassModel::where('is_active', true)->get();
        $subjects = collect();
        
        if ($request->has('academic_year_id') && $request->has('class_id')) {
            $subjects = Subject::where('class_id', $request->class_id)
                ->where('is_active', true)
                ->get();
        }
        
        return view('reports.subject_printing', compact(
            'academicYears',
            'currentAcademicYear',
            'classes',
            'subjects'
        ));
    }
}
