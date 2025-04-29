<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">Vendor Panel</a>
        <div class="ms-auto d-flex align-items-center">
            <!-- Notification Button -->
            <div class="dropdown me-3">
                @php
                    $notifications = auth()->user()->unreadNotifications;
                    $count = $notifications->count();
                @endphp

                <button class="btn btn-outline-light position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    🔔
                    @if ($count > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $count }}
                        </span>
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                    @forelse ($notifications as $notification)
                        <li>
                            <a class="dropdown-item" href="{{ $notification->data['url'] }}">
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                    @empty
                        <li><span class="dropdown-item text-muted">No new notifications</span></li>
                    @endforelse
                </ul>
            </div>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Mark notifications as read via JavaScript when dropdown is opened --}}
    <script>
        document.getElementById('notificationDropdown')?.addEventListener('click', function () {
            fetch("{{ route('notifications.markAsRead') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            });
        });
    </script>
</body>

</html>
