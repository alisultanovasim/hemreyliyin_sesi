<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <button class="btn btn-primary">
        <a style="text-decoration: none;color: white" href="{{route('admin')}}">Geriyə qayıt</a>
    </button>
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
</body>
</html>
