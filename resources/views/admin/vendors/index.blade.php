<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Pending Vendor Approvals</h1>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if ($vendors->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Business Name</th>
                        <th>Business License</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr id="vendor-{{ $vendor->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->business_name }}</td>
                            <td>{{ $vendor->business_license }}</td>
                            <td>
                                <select class="form-select status-dropdown" data-id="{{ $vendor->id }}">
                                    <option value="requested" {{ $vendor->status == 'requested' ? 'selected' : '' }}>
                                        Requested</option>
                                    <option value="approved" {{ $vendor->status == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="pending" {{ $vendor->status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No vendors pending approval.</p>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.status-dropdown').change(function() {
                var vendorId = $(this).data('id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '/admin/vendors/' + vendorId + '/approve',
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Something went wrong.');
                    }
                });
            });
        });
    </script>
</body>

</html>
