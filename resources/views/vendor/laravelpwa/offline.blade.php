<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Offline</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.css') }}">
</head>

<body>
    <div class='container'>
        <div class='row justify-content-center py-5'>
            <div class='col-md-12'>
                <figure>
                    <img class='img-fluid d-block mx-auto' src='{{ asset('img/errors/offline.svg') }}' width='600'
                        alt="offline">
                    <figcaption>
                        <h5 class='text-center text-danger'>Please connect to WIFI as you are currently offline.</h5>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
</body>

</html>
