@extends('layouts.app')

@section('title', 'Marks Convert')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('settings.examination') }}" class="btn btn-outline-primary">Examination</a>
            <a href="{{ route('settings.subject') }}" class="btn btn-outline-primary">Subject/Cr/Hour</a>
            <a href="{{ route('settings.percent-other') }}" class="btn btn-outline-primary">Percent/Other</a>
            <a href="{{ route('settings.remarks') }}" class="btn btn-outline-primary">Remarks</a>
            <a href="{{ route('settings.consider') }}" class="btn btn-outline-primary">Consider</a>
            <a href="{{ route('settings.extra-activities') }}" class="btn btn-outline-primary">Extra Activities</a>
            <a href="{{ route('settings.marks-convert') }}" class="btn btn-primary">Marks Convert</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        Marks Convert System
    </div>
    <div class="card-body">
        <form action="{{ route('settings.marks-convert.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="academic_year" class="col-sm-2 col-form-label">Academic Year</label>
                <div class="col-sm-4">
                    <select class="form-select" id="academic_year" name="academic_year_id">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $currentAcademicYear && $currentAcademicYear->id == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S/n</th>
                            <th>Examination Name</th>
                            <th>Exam%</th>
                            <th>Terminal%</th>
                            <th>Final%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>
                                <select class="form-select" name="exams[0][examination_id]">
                                    <option value="">--</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[0][exam_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[0][terminal_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[0][final_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>
                                <select class="form-select" name="exams[1][examination_id]">
                                    <option value="">--</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[1][exam_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[1][terminal_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[1][final_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>
                                <select class="form-select" name="exams[2][examination_id]">
                                    <option value="">--</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[2][exam_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[2][terminal_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[2][final_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>
                                <select class="form-select" name="exams[3][examination_id]">
                                    <option value="">--</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[3][exam_percentage]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[3][terminal_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="exams[3][final_percentage]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="marks_type" class="form-label">Marks</label>
                        <select class="form-select" id="marks_type" name="marks_type">
                            <option value="none">None</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="convert_type" class="form-label">Convert</label>
                        <select class="form-select" id="convert_type" name="convert_type">
                            <option value="convert_to_100">Convert To (100%)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="pass_fail_type" class="form-label">Pass/Fail</label>
                        <select class="form-select" id="pass_fail_type" name="pass_fail_type">
                            <option value="pass_on_th_pr">Pass On (TH + PR)</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
