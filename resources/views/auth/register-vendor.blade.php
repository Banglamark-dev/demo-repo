<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 50px;
        }
    </style>
</head>
<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">


        <form method="POST" action="{{ route('register.vendor') }}">
            @csrf
                <div>
                    <h1 class="text-center">Register Form</h1>
                </div>
                <div class="m-2">
                    <input class="form-control" type="text" name="name" placeholder="Name" required>
                </div>
                <div class="m-2"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
                <div class="m-2"><input class="form-control" type="hidden" name="role" value="{{ request()->query('role') }}"></div>
                <div class="mb-2">
                    <label for="brands" class="form-label">Select Brands</label>
                    <select class="form-control select2" name="brands[]" multiple required>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2"><input class="form-control" type="text" name="business_name" placeholder="Business Name" required></div>
                <div class="m-2"><input class="form-control" type="text" name="business_license" placeholder="Business License" required></div>
                <div class="m-2"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                <div class="m-2"><input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required></div>

                <div class="m-2">
                    <button class="btn btn-danger" type="submit">Register</button>
                </div>




        </form>


    </div>



       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <!-- JS Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Select brands",
                    width: '400',
                    closeOnSelect: false
                });
            });
        </script>
</body>
</html>

