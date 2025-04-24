<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="POST" action="{{ route('register.customer') }}">
            @csrf
            <div>
                <h1 class="text-center">Register Form Customer</h1>
            </div>
            <div class="m-3"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
            <div class="m-3"><input class="form-control" type="hidden" name="role" value="{{ request()->query('role') }}"></div>
            <div class="m-3"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
            <div class="m-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
            <div class="m-3"><input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required></div>
            <button class="btn btn-success m-3" type="submit">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>


