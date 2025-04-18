@extends('layouts.app')

@section('title', 'Remarks Settings')

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
            <a href="{{ route('settings.remarks') }}" class="btn btn-primary">Remarks</a>
            <a href="{{ route('settings.consider') }}" class="btn btn-outline-primary">Consider</a>
            <a href="{{ route('settings.extra-activities') }}" class="btn btn-outline-primary">Extra Activities</a>
            <a href="{{ route('settings.marks-convert') }}" class="btn btn-outline-primary">Marks Convert</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        Remarks Setting
    </div>
    <div class="card-body">
        <form action="{{ route('settings.remarks.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="remarks_type" class="col-sm-2 col-form-label">Remarks Type</label>
                <div class="col-sm-4">
                    <select class="form-select" id="remarks_type" name="remarks_type">
                        <option value="auto_remarks">Auto Remarks</option>
                        <option value="manual_remarks">Manual Remarks</option>
                    </select>
                </div>
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

            <div class="row mb-3">
                <label for="replace_import_remarks" class="col-sm-2 col-form-label">Replace import remarks</label>
                <div class="col-sm-4">
                    <select class="form-select" id="replace_import_remarks" name="replace_import_remarks">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="remarks_mode" id="auto_remarks" value="auto" checked>
                        <label class="form-check-label" for="auto_remarks">Auto Remarks</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="remarks_mode" id="manual_remarks" value="manual">
                        <label class="form-check-label" for="manual_remarks">Manual Remarks</label>
                    </div>
                    <button type="submit" class="btn btn-primary ms-3">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <label for="remarks_for_failed_students" class="col-sm-2 col-form-label">Remarks for failed students</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="remarks_for_failed_students" name="remarks_for_failed_students" value="Weak- pay special attention to failure subject(s).">
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Auto Remarks Detail
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="15%">Per% from</th>
                                    <th width="15%">Per% upto</th>
                                    <th width="70%">Remarks Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[0][percentage_from]" value="90.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[0][percentage_to]" value="100.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[0][remarks]" value="Excellent result; Go ahead.">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[1][percentage_from]" value="60.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[1][percentage_to]" value="89.99" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[1][remarks]" value="Good result; Go ahead for better performance.">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[2][percentage_from]" value="50.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[2][percentage_to]" value="59.99" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[2][remarks]" value="Satisfactory; Try hard for better result.">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[3][percentage_from]" value="40.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[3][percentage_to]" value="49.99" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[3][remarks]" value="Fair; Needs extra labour for better result.">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[4][percentage_from]" value="0.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="remarks[4][percentage_to]" value="0.00" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[4][remarks]" value="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
