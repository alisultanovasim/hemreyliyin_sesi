@extends('dashboard')
@section('content')'
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    canvas {
        max-width: 600px;
        margin: 0 auto;
    }
</style>
    <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
            <!-- Card stats -->
            <div class="row g-6 mb-6">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Ümumi</span>
                                    <span class="h3 font-bold mb-0">{{$allUsers}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                        <i class="bi bi-list"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">İştirak edənlər</span>
                                    <span class="h3 font-bold mb-0">{{$hasRecord}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">İştirak etməyənlər</span>
                                    <span class="h3 font-bold mb-0">{{$hasNoRecord}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                        <i class="bi bi-person-x-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Səsyazmalar</span>
                                    <span class="h3 font-bold mb-0">{{$allRecord}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                        <i class="bi bi-mic"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="eventChart" style="width: 500px;height: 500px"></canvas>
            <div class="card shadow border-0 mt-10">
                <div class="card-header">
                    <h5 class="mb-0 text-center">Yeni qoşulanlar</h5>
                </div>
                <div class="table">
                    <table class="table table-hover table-nowrap">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center">Ad,soy ad</th>
                            <th scope="col" class="text-center">Tarix</th>
                            <th scope="col" class="text-center">Nömrə</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lastUsers as $user)
                            <tr>
                                <td>
                                    <img alt="..." src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                    <a class="text-heading font-semibold" href="#">
                                        {{$user->name.' '.$user->surname}}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{\Illuminate\Support\Carbon::parse($user->created_at)->format('d-m-Y')}}
                                </td>
                                <td class="text-center">
                                    <a class="text-heading font-semibold" href="#">
                                        {{$user->phone}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
<script>
    var ctx = document.getElementById('eventChart').getContext('2d');
    var allMonths = @json($allMonths);

    var monthLabels = allMonths.map(function (data) {
        return data.month;
    });

    var userCounts = allMonths.map(function (data) {
        return data.count;
    });

    var eventChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Qoşulan istifadəçilər',
                data: userCounts,
                fill: false,
                borderColor: 'rgb(203,23,23)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>

@endsection
