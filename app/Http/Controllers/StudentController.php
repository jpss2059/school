<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['class', 'section']);
        
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->has('section_id') && $request->section_id) {
            $query->where('section_id', $request->section_id);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('roll_number', 'like', "%{$search}%");
            });
        }
        
        $students = $query->orderBy('roll_number')->paginate(15);
        $classes = ClassModel::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        
        return view('students.index', compact('students', 'classes', 'sections'));
    }
    
    public function create()
    {
        $classes = ClassModel::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        
        return view('students.create', compact('classes', 'sections'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'roll_number' => 'required|string|max:50|unique:students',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'mbl_number' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Student::create($request->all());
        
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }
    
    public function show(Student $student)
    {
        $student->load(['class', 'section']);
        
        return view('students.show', compact('student'));
    }
    
    public function edit(Student $student)
    {
        $classes = ClassModel::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        
        return view('students.edit', compact('student', 'classes', 'sections'));
    }
    
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'roll_number' => 'required|string|max:50|unique:students,roll_number,' . $student->id,
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'mbl_number' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $student->update($request->all());
        
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }
    
    public function destroy(Student $student)
    {
        $student->delete();
        
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
