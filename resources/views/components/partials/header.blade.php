<header class="bg-base-100 border-b border-base-300 h-16 flex items-center px-6 gap-4 sticky top-0 z-30 shadow-sm">

    <button onclick="toggleSidebar()" class="btn btn-square btn-ghost md:hidden">
        <i data-lucide="menu" class="w-5 h-5"></i>
    </button>

    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-base-content/50">Poliklinik</span>
            <i data-lucide="chevron-right" class="w-4 h-4 text-base-content/30"></i>
            <span class="font-semibold text-base-content">
                {{ $title ?? 'Dashboard' }}
            </span>
        </div>
    </div>

    @php
        $notifications = auth()->user()?->notifications()->latest()->limit(8)->get() ?? collect();
        $unreadCount = auth()->user()?->unreadNotifications->count() ?? 0;
    @endphp

    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle relative">
            <i class="fa-regular fa-bell text-lg" aria-hidden="true"></i>
            @if ($unreadCount > 0)
                <span class="badge badge-error badge-sm absolute -top-1 -right-1 text-[10px] min-w-5 h-5 rounded-full">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </div>

        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-80 p-2 shadow-lg border border-base-300 mt-2">
            <li class="menu-title px-3 py-2 text-sm font-semibold text-base-content/70">
                Notifikasi
            </li>

            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data ?? [];
                    $isUnread = is_null($notification->read_at);
                @endphp

                <li>
                    <div class="flex items-start gap-3 p-3 rounded-lg {{ $isUnread ? 'bg-primary/5' : 'bg-transparent' }}">
                        <div class="mt-0.5">
                            <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $isUnread ? 'bg-primary' : 'bg-base-300' }}"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-base-content {{ $isUnread ? 'font-semibold' : '' }}">
                                {{ $data['title'] ?? 'Notifikasi' }}
                            </div>
                            <div class="text-xs text-base-content/70 mt-1">
                                {{ $data['message'] ?? 'Ada pembaruan baru.' }}
                            </div>
                            <div class="text-[10px] text-base-content/50 mt-1">
                                {{ $notification->created_at?->diffForHumans() ?? 'baru' }}
                            </div>
                        </div>

                        @if ($isUnread)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-xs text-primary" title="Tandai dibaca">
                                    Baca
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                <li>
                    <div class="px-3 py-5 text-sm text-base-content/60 text-center">
                        Tidak ada notifikasi.
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <button onclick="toggleFullscreen()" class="btn btn-square btn-ghost">
        <i id="fsIcon" class="fas fa-expand w-5 h-5"></i>
    </button>

    <a href="{{ route('profile.password.edit') }}"
        class="btn btn-square btn-ghost"
        title="Ganti password"
        aria-label="Ganti password">
        <i class="fas fa-key" aria-hidden="true"></i>
    </a>

    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-semibold leading-tight">
                {{ auth()->user()->nama ?? 'Pengguna' }}
            </div>
            <div class="text-xs text-base-content/50 leading-tight capitalize">
                {{ auth()->user()->role ?? 'User' }}
            </div>
        </div>

        <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                <span class="text-sm font-semibold leading-none">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                </span>
            </div>
        </div>
    </div>

</header>

<script>
    function toggleFullscreen() {
        const icon = document.getElementById('fsIcon');

        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            icon.classList.remove('fa-expand');
            icon.classList.add('fa-compress');
        } else {
            document.exitFullscreen();
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
        }
    }
</script>