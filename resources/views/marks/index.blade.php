@extends('layouts.app')

@section('title', 'Marks Entry')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Marks Input</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('marks.index') }}" method="GET" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="academic_year" class="form-label">A/Year</label>
                    <select class="form-select" id="academic_year" name="academic_year_id" onchange="document.getElementById('filterForm').submit()">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="examination" class="form-label">Exam Terminal</label>
                    <select class="form-select" id="examination" name="examination_id" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Select Examination</option>
                        @foreach($examinations as $exam)
                            <option value="{{ $exam->id }}" {{ request('examination_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="as_input" class="form-label">As Input</label>
                    <select class="form-select" id="as_input" name="as_input">
                        <option value="marks_input">Marks Input</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="as_index" class="form-label">As Index</label>
                    <select class="form-select" id="as_index" name="as_index">
                        <option value="as_roll_no">As Roll No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="subjects" class="form-label">Subjects</label>
                    <select class="form-select" id="subjects" name="subject_id">
                        <option value="all">ALL</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="class" class="form-label">Class</label>
                    <select class="form-select" id="class" name="class_id" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="section" class="form-label">Section</label>
                    <select class="form-select" id="section" name="section_id" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Sections</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Load
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Export to excel</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="excel_file">
                                <button class="btn btn-outline-secondary" type="button">Choose File</button>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="form-label">Import from excel</label>
                            <button class="btn btn-outline-secondary" type="button">Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        @if(request('academic_year_id') && request('examination_id') && request('class_id') && $students->count() > 0 && $subjects->count() > 0)
            <form action="{{ route('marks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="academic_year_id" value="{{ request('academic_year_id') }}">
                <input type="hidden" name="examination_id" value="{{ request('examination_id') }}">
                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }} ({{ $subject->full_marks }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->roll_number }}</td>
                                    <td>{{ $student->name }}</td>
                                    @foreach($subjects as $subject)
                                        <td>
                                            <input type="hidden" name="marks[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="marks[{{ $loop->index }}][subject_id]" value="{{ $subject->id }}">
                                            <input type="number" class="form-control form-control-sm" 
                                                name="marks[{{ $loop->index }}][obtained_marks]" 
                                                value="{{ $marks[$student->id][$subject->id][0]->obtained_marks ?? '' }}" 
                                                min="0" max="{{ $subject->full_marks }}" step="0.01">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="marks[{{ $loop->index }}][is_absent]" 
                                                    id="absent_{{ $student->id }}_{{ $subject->id }}" 
                                                    {{ isset($marks[$student->id][$subject->id][0]) && $marks[$student->id][$subject->id][0]->is_absent ? 'checked' : '' }}>
                                                <label class="form-check-label" for="absent_{{ $student->id }}_{{ $subject->id }}">
                                                    Absent
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Marks
                        </button>
                    </div>
                </div>
            </form>
        @elseif(request('academic_year_id') && request('examination_id') && request('class_id'))
            <div class="alert alert-info">
                No students or subjects found for the selected criteria.
            </div>
        @endif
    </div>
</div>
@endsection
