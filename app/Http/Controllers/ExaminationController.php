<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExaminationController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $examinations = Examination::with('academicYear')
            ->when($currentAcademicYear, function($query) use ($currentAcademicYear) {
                return $query->where('academic_year_id', $currentAcademicYear->id);
            })
            ->orderBy('exam_date')
            ->get();
        
        return view('examinations.index', compact('examinations', 'academicYears', 'currentAcademicYear'));
    }
    
    public function create()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        return view('examinations.create', compact('academicYears', 'currentAcademicYear'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_date' => 'required|date',
            'working_days' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'is_terminal' => 'boolean',
            'is_final' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Examination::create($request->all());
        
        return redirect()->route('examinations.index')->with('success', 'Examination created successfully.');
    }
    
    public function edit(Examination $examination)
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        
        return view('examinations.edit', compact('examination', 'academicYears'));
    }
    
    public function update(Request $request, Examination $examination)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_date' => 'required|date',
            'working_days' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'is_terminal' => 'boolean',
            'is_final' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $examination->update($request->all());
        
        return redirect()->route('examinations.index')->with('success', 'Examination updated successfully.');
    }
    
    public function destroy(Examination $examination)
    {
        // Check if marks exist for this examination
        if ($examination->marks()->count() > 0) {
            return redirect()->route('examinations.index')->with('error', 'Cannot delete examination with associated marks.');
        }
        
        $examination->delete();
        
        return redirect()->route('examinations.index')->with('success', 'Examination deleted successfully.');
    }
}
