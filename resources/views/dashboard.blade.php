@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-repeat"></i> Refresh
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Organization Status
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="financialChart" width="400" height="300"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="studentChart" width="400" height="300"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm btn-primary">See more chart analysis</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Student Statistics
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th>S/n</th>
                                <th>Class</th>
                                <th>New (M)</th>
                                <th>New (F)</th>
                                <th>Old (M)</th>
                                <th>Old (F)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classStats as $index => $stat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $stat->name }}</td>
                                <td>{{ $stat->new_male }}</td>
                                <td>{{ $stat->new_female }}</td>
                                <td>{{ $stat->old_male }}</td>
                                <td>{{ $stat->old_female }}</td>
                                <td>{{ $stat->new_male + $stat->new_female + $stat->old_male + $stat->old_female }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center py-2">
                    <button class="btn btn-sm btn-primary">See more details</button>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                Today's Birthdays
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>MBL Number</th>
                                <th>Reminder Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($todayBirthdays->count() > 0)
                                @foreach($todayBirthdays as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->mbl_number }}</td>
                                    <td>Birthday Today!</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">There is no Record.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Financial Chart
    var financialCtx = document.getElementById('financialChart').getContext('2d');
    var financialChart = new Chart(financialCtx, {
        type: 'pie',
        data: {
            labels: ['Debit', 'Credit', 'Balance'],
            datasets: [{
                data: [{{ $financialData['debit'] }}, {{ $financialData['credit'] }}, {{ $financialData['balance'] }}],
                backgroundColor: [
                    'rgba(205, 180, 130, 0.8)',
                    'rgba(255, 255, 0, 0.8)',
                    'rgba(75, 192, 75, 0.8)'
                ],
                borderColor: [
                    'rgba(205, 180, 130, 1)',
                    'rgba(255, 255, 0, 1)',
                    'rgba(75, 192, 75, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    
    // Student Chart
    var studentCtx = document.getElementById('studentChart').getContext('2d');
    var studentChart = new Chart(studentCtx, {
        type: 'bar',
        data: {
            labels: ['Students'],
            datasets: [{
                label: 'Total Students',
                data: [{{ $totalStudents }}],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
