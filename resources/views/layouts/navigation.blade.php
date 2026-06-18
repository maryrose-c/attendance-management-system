<nav x-data="{ open: false }" class="relative z-50 border-b border-violet-500/10 bg-[#070316]/90 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="text-2xl">🔮</span>
                    <span class="text-xl font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-300 to-pink-300">ATTEND</span>
                </a>

                <div class="hidden sm:flex items-center gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')">
                        {{ __('Classes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                        {{ __('Students') }}
                    </x-nav-link>
                    <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*') && !request()->routeIs('attendance.scan')">
                        {{ __('Attendance History') }}
                    </x-nav-link>
                    <x-nav-link :href="route('attendance.scan')" :active="request()->routeIs('attendance.scan')">
                        {{ __('Scanner') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-xl border border-violet-400/20 bg-violet-500/10 px-4 py-2 text-sm font-bold text-purple-100 hover:bg-violet-500/20 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-purple-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-violet-600 px-4 py-2 text-sm font-black text-white hover:bg-violet-500 transition">Login</a>
                @endauth
            </div>

            <button @click="open = ! open" class="sm:hidden rounded-xl p-2 text-purple-200 hover:bg-white/10">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-white/10 bg-[#080318] px-4 py-4 space-y-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')">Classes</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">Students</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">Attendance History</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">Reports</x-responsive-nav-link>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('login')">Login</x-responsive-nav-link>
        @endauth
    </div>
</nav>
