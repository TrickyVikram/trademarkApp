<!-- User Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="font-size: 1.5rem; color: #1D3557;">
            🏛️ <span>Legal Bruz</span>
        </a>

        <!-- Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar"
            aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="userNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        📊 Dashboard
                    </a>
                </li>

                <!-- My Documents -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.documents') ? 'active' : '' }}"
                        href="{{ route('user.documents') }}">
                        📄 My Documents
                    </a>
                </li>

                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        🔔 Notifications
                        @php
                            $unreadCount = \App\Services\NotificationService::getUnreadCount(Auth::id());
                        @endphp
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown"
                        style="width: 350px;">
                        @php
                            $notifications = \App\Services\NotificationService::getRecentNotifications(Auth::id(), 5);
                        @endphp

                        @if ($notifications->count() > 0)
                            @foreach ($notifications as $notif)
                                <li>
                                    <a class="dropdown-item {{ $notif->isUnread() ? 'bg-light' : '' }}"
                                        href="javascript:void(0)" onclick="markNotificationRead({{ $notif->id }})">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $notif->title }}</strong>
                                                <p class="text-muted mb-0" style="font-size: 0.7rem;">
                                                    {{ $notif->message }}
                                                </p>
                                            </div>
                                            @if ($notif->isUnread())
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                            @endforeach
                        @else
                            <li class="text-center p-3">
                                <small class="text-muted">No notifications</small>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userProfileDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        👤 {{ Auth::user()->name ?? 'User' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userProfileDropdown">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">👤 Profile</a></li>
                        <li><a class="dropdown-item" href="#">⚙️ Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="dropdown-item" type="submit">🚪 Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function markNotificationRead(notificationId) {
        fetch(`/api/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => location.reload());
    }
</script>

<style>
    .navbar-brand span {
        margin-left: 0.5rem;
    }

    .navbar-nav .nav-link {
        color: #1D3557;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #2A9D8F !important;
        font-weight: 600;
    }

    .dropdown-menu {
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
