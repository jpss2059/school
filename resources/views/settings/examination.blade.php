@extends('layouts.app')

@section('title', 'Examination Settings')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('settings.examination') }}" class="btn btn-primary">Examination</a>
            <a href="{{ route('settings.subject') }}" class="btn btn-outline-primary">Subject/Cr/Hour</a>
            <a href="{{ route('settings.percent-other') }}" class="btn btn-outline-primary">Percent/Other</a>
            <a href="{{ route('settings.remarks') }}" class="btn btn-outline-primary">Remarks</a>
            <a href="{{ route('settings.consider') }}" class="btn btn-outline-primary">Consider</a>
            <a href="{{ route('settings.extra-activities') }}" class="btn btn-outline-primary">Extra Activities</a>
            <a href="{{ route('settings.marks-convert') }}" class="btn btn-outline-primary">Marks Convert</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Exam Terminal
            </div>
            <div class="card-body">
                <form action="{{ route('settings.examination.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="academic_year" class="col-sm-4 col-form-label">Academic Year :</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="academic_year" name="academic_year_id">
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ $currentAcademicYear && $currentAcademicYear->id == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="exam_name" class="col-sm-4 col-form-label">Exam Name :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="exam_name" name="name">


```blade file="resources/views/settings/extra_activities.blade.php"
@extends('layouts.app')

@section('title', 'Extra Activities Settings')

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
            <a href="{{ route('settings.extra-activities') }}" class="btn btn-primary">Extra Activities</a>
            <a href="{{ route('settings.marks-convert') }}" class="btn btn-outline-primary">Marks Convert</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Extra Activities
            </div>
            <div class="card-body">
                <form action="{{ route('settings.extra-activities.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="academic_year" class="col-sm-4 col-form-label">Academic Year :</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="academic_year" name="academic_year_id">
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ $currentAcademicYear && $currentAcademicYear->id == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="extra_activities" class="col-sm-4 col-form-label">Extra Activities :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="extra_activities" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="shortcut" class="col-sm-4 col-form-label">ShortCut :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="shortcut" name="shortcut">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-arrow-repeat"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Edit</th>
                                <th>S/n</th>
                                <th>Academy Year</th>
                                <th>Extra Activities</th>
                                <th>ShortCut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($extraActivities as $index => $activity)
                                <tr>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary edit-activity" data-id="{{ $activity->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $activity->academicYear->name }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->shortcut }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No extra activities found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editActivityModalLabel">Edit Extra Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editActivityForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Activity Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_shortcut" class="form-label">Shortcut</label>
                        <input type="text" class="form-control" id="edit_shortcut" name="shortcut">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit activity button click
        const editButtons = document.querySelectorAll('.edit-activity');
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const activityId = this.getAttribute('data-id');
                
                // Here you would typically fetch the activity data via AJAX
                // For this example, we'll just show the modal with empty fields
                document.getElementById('editActivityForm').action = `/settings/extra-activities/${activityId}`;
                
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('editActivityModal'));
                modal.show();
            });
        });
    });
</script>
@endsection
