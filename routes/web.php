<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Students
Route::resource('students', StudentController::class);

// Examinations
Route::resource('examinations', ExaminationController::class);

// Marks
Route::get('marks', [MarkController::class, 'index'])->name('marks.index');
Route::post('marks', [MarkController::class, 'store'])->name('marks.store');
Route::post('marks/import', [MarkController::class, 'import'])->name('marks.import');
Route::get('marks/export', [MarkController::class, 'export'])->name('marks.export');

// Reports
Route::get('reports/progress-card', [ReportController::class, 'progressCard'])->name('reports.progress-card');
Route::get('reports/marks-ledger', [ReportController::class, 'marksLedger'])->name('reports.marks-ledger');
Route::get('reports/marks-analysis', [ReportController::class, 'marksAnalysis'])->name('reports.marks-analysis');
Route::get('reports/subject-printing', [ReportController::class, 'subjectPrinting'])->name('reports.subject-printing');

// Settings
Route::get('settings/academic-year', [SettingController::class, 'academicYear'])->name('settings.academic-year');
Route::post('settings/academic-year', [SettingController::class, 'storeAcademicYear'])->name('settings.academic-year.store');
Route::put('settings/academic-year/{academicYear}', [SettingController::class, 'updateAcademicYear'])->name('settings.academic-year.update');

Route::get('settings/grade', [SettingController::class, 'gradeSettings'])->name('settings.grade');
Route::post('settings/grade', [SettingController::class, 'storeGradeSettings'])->name('settings.grade.store');

Route::get('settings/division', [SettingController::class, 'divisionSettings'])->name('settings.division');
Route::post('settings/division', [SettingController::class, 'storeDivisionSettings'])->name('settings.division.store');

Route::get('settings/remarks', [SettingController::class, 'remarksSettings'])->name('settings.remarks');
Route::post('settings/remarks', [SettingController::class, 'storeRemarksSettings'])->name('settings.remarks.store');

Route::get('settings/extra-activities', [SettingController::class, 'extraActivities'])->name('settings.extra-activities');
Route::post('settings/extra-activities', [SettingController::class, 'storeExtraActivity'])->name('settings.extra-activities.store');
Route::put('settings/extra-activities/{extraActivity}', [SettingController::class, 'updateExtraActivity'])->name('settings.extra-activities.update');

Route::get('settings/subject', [SettingController::class, 'subjectSettings'])->name('settings.subject');
Route::post('settings/subject', [SettingController::class, 'storeSubject'])->name('settings.subject.store');
Route::put('settings/subject/{subject}', [SettingController::class, 'updateSubject'])->name('settings.subject.update');

Route::get('settings/marks-convert', [SettingController::class, 'marksConvert'])->name('settings.marks-convert');
Route::post('settings/marks-convert', [SettingController::class, 'storeMarksConvert'])->name('settings.marks-convert.store');

Route::get('settings/examination', [SettingController::class, 'examination'])->name('settings.examination');
Route::post('settings/examination', [SettingController::class, 'storeExamination'])->name('settings.examination.store');

Route::get('settings/percent-other', [SettingController::class, 'percentOther'])->name('settings.percent-other');
Route::post('settings/percent-other', [SettingController::class, 'storePercentOther'])->name('settings.percent-other.store');

Route::get('settings/consider', [SettingController::class, 'consider'])->name('settings.consider');
Route::post('settings/consider', [SettingController::class, 'storeConsider'])->name('settings.consider.store');
