@extends('dashboard')
@section('content')

    <div class="container mt-4">
        <h2 class="text-center">Qeydə alınmış səslər</h2>
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped mt-4">
                <thead>
                <tr class="text-center">
                    <th>№</th>
                    <th>Ad,Soy ad</th>
                    <th>Səsyazma</th>
                    <th>Endir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($voices as $key=>$voice)
                    <tr >
                        <td class="col-md-1">{{$key+1}}</td>
                        <td class="col-md-5">{{ $voice->user->name }} {{ $voice->user->surname }}</td>
                        <td class="text-center col-3">
                            <audio controls>
                                <source src="{{ asset('storage/voices/'.$voice->name) }}" type="audio/mpeg">
                            </audio>
                        </td>
                        <td class="text-center col-2">
                            <a href="{{ asset('storage/voices/'.$voice->name) }}" class="btn btn-primary" download>
                                <i class="bi bi-download"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>


@endsection
