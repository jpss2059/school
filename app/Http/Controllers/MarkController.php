<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\DivisionSetting;
use App\Models\Examination;
use App\Models\GradeSetting;
use App\Models\Mark;
use App\Models\RemarksSetting;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    public function index(Request $request)
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
        
        return view('marks.index', compact(
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
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'marks' => 'required|array',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.subject_id' => 'required|exists:subjects,id',
            'marks.*.obtained_marks' => 'required|numeric|min:0',
            'marks.*.is_absent' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            foreach ($request->marks as $markData) {
                $subject = Subject::find($markData['subject_id']);
                $percentage = ($markData['obtained_marks'] / $subject->full_marks) * 100;
                
                // Get grade based on percentage
                $gradeSetting = GradeSetting::where('academic_year_id', $request->academic_year_id)
                    ->where('percentage_from', '<=', $percentage)
                    ->where('percentage_to', '>=', $percentage)
                    ->first();
                
                // Get remarks based on percentage
                $remarksSetting = RemarksSetting::where('academic_year_id', $request->academic_year_id)
                    ->where('percentage_from', '<=', $percentage)
                    ->where('percentage_to', '>=', $percentage)
                    ->where('is_auto', true)
                    ->first();
                
                $mark = Mark::updateOrCreate(
                    [
                        'student_id' => $markData['student_id'],
                        'examination_id' => $request->examination_id,
                        'subject_id' => $markData['subject_id'],
                        'academic_year_id' => $request->academic_year_id,
                        'class_id' => $request->class_id,
                        'section_id' => $request->section_id,
                    ],
                    [
                        'obtained_marks' => $markData['obtained_marks'],
                        'percentage' => $percentage,
                        'grade' => $gradeSetting->grade ?? null,
                        'grade_point' => $gradeSetting->grade_point ?? null,
                        'remarks' => $remarksSetting->remarks ?? null,
                        'is_absent' => isset($markData['is_absent']) ? true : false,
                    ]
                );
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Marks saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error saving marks: ' . $e->getMessage());
        }
    }
    
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Here you would implement the Excel import logic
        // This is a placeholder for the actual implementation
        
        return redirect()->back()->with('success', 'Marks imported successfully.');
    }
    
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Here you would implement the Excel export logic
        // This is a placeholder for the actual implementation
        
        return redirect()->back()->with('success', 'Marks exported successfully.');
    }
}
