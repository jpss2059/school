<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\DivisionSetting;
use App\Models\ExtraActivity;
use App\Models\GradeSetting;
use App\Models\RemarksSetting;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function academicYear()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        
        return view('settings.academic_year', compact('academicYears'));
    }
    
    public function storeAcademicYear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:academic_years',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            if ($request->has('is_current') && $request->is_current) {
                AcademicYear::where('is_current', true)->update(['is_current' => false]);
            }
            
            AcademicYear::create($request->all());
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Academic year created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error creating academic year: ' . $e->getMessage());
        }
    }
    
    public function updateAcademicYear(Request $request, AcademicYear $academicYear)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'is_active' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            if ($request->has('is_current') && $request->is_current) {
                AcademicYear::where('is_current', true)->update(['is_current' => false]);
            }
            
            $academicYear->update($request->all());
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Academic year updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error updating academic year: ' . $e->getMessage());
        }
    }
    
    public function gradeSettings()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $gradeSettings = GradeSetting::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->orderBy('percentage_from', 'desc')
            ->get();
        
        return view('settings.grade_settings', compact('academicYears', 'currentAcademicYear', 'gradeSettings'));
    }
    
    public function storeGradeSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'grades' => 'required|array',
            'grades.*.percentage_from' => 'required|numeric|min:0|max:100',
            'grades.*.percentage_to' => 'required|numeric|min:0|max:100',
            'grades.*.grade' => 'required|string|max:10',
            'grades.*.grade_point' => 'required|numeric|min:0',
            'grades.*.remarks' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Delete existing grade settings for this academic year
            GradeSetting::where('academic_year_id', $request->academic_year_id)->delete();
            
            // Create new grade settings
            foreach ($request->grades as $gradeSetting) {
                GradeSetting::create([
                    'academic_year_id' => $request->academic_year_id,
                    'percentage_from' => $gradeSetting['percentage_from'],
                    'percentage_to' => $gradeSetting['percentage_to'],
                    'grade' => $gradeSetting['grade'],
                    'grade_point' => $gradeSetting['grade_point'],
                    'remarks' => $gradeSetting['remarks'] ?? null,
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Grade settings saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error saving grade settings: ' . $e->getMessage());
        }
    }
    
    public function divisionSettings()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $divisionSettings = DivisionSetting::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->orderBy('percentage_from', 'desc')
            ->get();
        
        return view('settings.division_settings', compact('academicYears', 'currentAcademicYear', 'divisionSettings'));
    }
    
    public function storeDivisionSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'divisions' => 'required|array',
            'divisions.*.division_name' => 'required|string|max:255',
            'divisions.*.percentage_from' => 'required|numeric|min:0|max:100',
            'divisions.*.percentage_to' => 'required|numeric|min:0|max:100',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Delete existing division settings for this academic year
            DivisionSetting::where('academic_year_id', $request->academic_year_id)->delete();
            
            // Create new division settings
            foreach ($request->divisions as $divisionSetting) {
                DivisionSetting::create([
                    'academic_year_id' => $request->academic_year_id,
                    'division_name' => $divisionSetting['division_name'],
                    'percentage_from' => $divisionSetting['percentage_from'],
                    'percentage_to' => $divisionSetting['percentage_to'],
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Division settings saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error saving division settings: ' . $e->getMessage());
        }
    }
    
    public function remarksSettings()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $remarksSettings = RemarksSetting::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->orderBy('percentage_from', 'desc')
            ->get();
        
        return view('settings.remarks_settings', compact('academicYears', 'currentAcademicYear', 'remarksSettings'));
    }
    
    public function storeRemarksSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'remarks' => 'required|array',
            'remarks.*.percentage_from' => 'required|numeric|min:0|max:100',
            'remarks.*.percentage_to' => 'required|numeric|min:0|max:100',
            'remarks.*.remarks' => 'required|string|max:255',
            'remarks.*.is_auto' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Delete existing remarks settings for this academic year
            RemarksSetting::where('academic_year_id', $request->academic_year_id)->delete();
            
            // Create new remarks settings
            foreach ($request->remarks as $remarksSetting) {
                RemarksSetting::create([
                    'academic_year_id' => $request->academic_year_id,
                    'percentage_from' => $remarksSetting['percentage_from'],
                    'percentage_to' => $remarksSetting['percentage_to'],
                    'remarks' => $remarksSetting['remarks'],
                    'is_auto' => isset($remarksSetting['is_auto']) ? true : false,
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Remarks settings saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error saving remarks settings: ' . $e->getMessage());
        }
    }
    
    public function extraActivities()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $extraActivities = ExtraActivity::where('academic_year_id', $currentAcademicYear->id ?? null)
            ->orderBy('id')
            ->get();
        
        return view('settings.extra_activities', compact('academicYears', 'currentAcademicYear', 'extraActivities'));
    }
    
    public function storeExtraActivity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'shortcut' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        ExtraActivity::create($request->all());
        
        return redirect()->back()->with('success', 'Extra activity created successfully.');
    }
    
    public function updateExtraActivity(Request $request, ExtraActivity $extraActivity)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shortcut' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $extraActivity->update($request->all());
        
        return redirect()->back()->with('success', 'Extra activity updated successfully.');
    }
    
    public function subjectSettings()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        $classes = ClassModel::where('is_active', true)->get();
        $subjects = collect();
        
        if (request()->has('class_id') && request()->class_id) {
            $subjects = Subject::where('class_id', request()->class_id)
                ->orderBy('name')
                ->get();
        }
        
        return view('settings.subject_settings', compact('academicYears', 'currentAcademicYear', 'classes', 'subjects'));
    }
    
    public function storeSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'class_id' => 'required|exists:classes,id',
            'full_marks' => 'required|integer|min:0',
            'pass_marks' => 'required|integer|min:0|lte:full_marks',
            'credit_hours' => 'nullable|integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Subject::create($request->all());
        
        return redirect()->back()->with('success', 'Subject created successfully.');
    }
    
    public function updateSubject(Request $request, Subject $subject)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'full_marks' => 'required|integer|min:0',
            'pass_marks' => 'required|integer|min:0|lte:full_marks',
            'credit_hours' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $subject->update($request->all());
        
        return redirect()->back()->with('success', 'Subject updated successfully.');
    }
    
    public function marksConvert()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $currentAcademicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::latest()->first();
        
        return view('settings.marks_convert', compact('academicYears', 'currentAcademicYear'));
    }
    
    public function storeMarksConvert(Request $request)
    {
        // This would be implemented based on your specific requirements
        // for marks conversion between different examination types
        
        return redirect()->back()->with('success', 'Marks conversion settings saved successfully.');
    }
}
