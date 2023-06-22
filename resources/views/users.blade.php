@extends('dashboard')
@section('content')
    <div class="container mt-4">
        <div class="row text-center">
                <h1>İstifadəçilərin siyahısı</h1>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Ad</th>
                        <th>Soy ad</th>
                        <th>Nömrə</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection
