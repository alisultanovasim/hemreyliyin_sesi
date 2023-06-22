@extends('dashboard')
@section('content')
    <div class="container mt-4">
        <div class="row text-center">
            <h2 style="text-align: center;margin-top: 20px">Qeydə alınmış səslər</h2>
            @foreach($voices as $voice)
                <div class="col-md-6 offset-md-3 my-2">
                    <div class="card">
                        <div class="card-body">
                            <p>İştirakçı: {{ $voice->user->name }} {{ $voice->user->surname }}</p>
                            <audio controls>
                                <source src="{{ asset('storage/voices/'.$voice->name) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
