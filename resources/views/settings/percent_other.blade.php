@extends('layouts.app')

@section('title', 'Percentage & Other Settings')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('settings.examination') }}" class="btn btn-outline-primary">Examination</a>
            <a href="{{ route('settings.subject') }}" class="btn btn-outline-primary">Subject/Cr/Hour</a>
            <a href="{{ route('settings.percent-other') }}" class="btn btn-primary">Percent/Other</a>
            <a href="{{ route('settings.remarks') }}" class="btn btn-outline-primary">Remarks</a>
            <a href="{{ route('settings.consider') }}" class="btn btn-outline-primary">Consider</a>
            <a href="{{ route('settings.extra-activities') }}" class="btn btn-outline-primary">Extra Activities</a>
            <a href="{{ route('settings.marks-convert') }}" class="btn btn-outline-primary">Marks Convert</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        Percent & Other Setting
    </div>
    <div class="card-body">
        <form action="{{ route('settings.percent-other.store') }}" method="POST">
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

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Percent/Division Detail
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="20%">Division</th>
                                            <th width="20%">From (%)</th>
                                            <th width="20%">To (%)</th>
                                            <th width="40%">Label</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Distinction</td>
                                            <td>
                                                <input type="number" class="form-control" name="divisions[0][percentage_from]" value="80.00" step="0.01" min="0" max="100">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="divisions[0][percentage_to]" value="100.00" step="0.01" min="0" max="100">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="divisions[0][division_name]" value="Distinction">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>First Division</td>
                                            <td>
                                                <input type="number" class="form-control" name="divisions[1][percentage_from]" value="60.00" step="0.01" min="0" max="100">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="divisions[1][percentage_to]" value="79.99" step="0.01" min="0" max="100">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="divisions[1][division_name]" value="First">
                                            </td>
                                        </tr>
                                        


```blade file="resources/views/settings/grade_settings.blade.php"
@extends('layouts.app')

@section('title', 'Grade Settings')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Grade Settings</h1>
</div>

<div class="card">
    <div class="card-header">
        Percent for Marks to Granding
    </div>
    <div class="card-body">
        <form action="{{ route('settings.grade.store') }}" method="POST">
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
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S/n</th>
                            <th>Per% from</th>
                            <th>Per% upto</th>
                            <th>Granding</th>
                            <th>Grade Point</th>
                            <th>GPA Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[0][percentage_from]" value="90.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[0][percentage_to]" value="100.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[0][grade]" value="A+">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[0][grade_point]" value="4.0" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[0][remarks]" value="Outstanding">
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[1][percentage_from]" value="80.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[1][percentage_to]" value="89.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[1][grade]" value="A">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[1][grade_point]" value="3.6" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[1][remarks]" value="Excellent">
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[2][percentage_from]" value="70.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[2][percentage_to]" value="79.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[2][grade]" value="B+">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[2][grade_point]" value="3.2" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[2][remarks]" value="Very Good">
                            </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[3][percentage_from]" value="60.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[3][percentage_to]" value="69.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[3][grade]" value="B">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[3][grade_point]" value="2.8" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[3][remarks]" value="Good">
                            </td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[4][percentage_from]" value="50.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[4][percentage_to]" value="59.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[4][grade]" value="C+">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[4][grade_point]" value="2.4" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[4][remarks]" value="Satisfactory">
                            </td>
                        </tr>
                        <tr>
                            <td>6.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[5][percentage_from]" value="40.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[5][percentage_to]" value="49.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[5][grade]" value="C">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[5][grade_point]" value="2.0" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[5][remarks]" value="Acceptable">
                            </td>
                        </tr>
                        <tr>
                            <td>7.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[6][percentage_from]" value="35.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[6][percentage_to]" value="39.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[6][grade]" value="D+">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[6][grade_point]" value="1.6" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[6][remarks]" value="Partially Acceptable">
                            </td>
                        </tr>
                        <tr>
                            <td>8.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[7][percentage_from]" value="0.10" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[7][percentage_to]" value="34.99" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[7][grade]" value="NG">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[7][grade_point]" value="0.0" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[7][remarks]" value="Not Graded">
                            </td>
                        </tr>
                        <tr>
                            <td>9.</td>
                            <td>
                                <input type="number" class="form-control" name="grades[8][percentage_from]" value="0.00" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[8][percentage_to]" value="0.09" step="0.01" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[8][grade]" value="ABS">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="grades[8][grade_point]" value="0.0" step="0.1" min="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="grades[8][remarks]" value="Absent">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
