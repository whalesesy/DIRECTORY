<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kisii County Admin Panel</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kisii: {
                            blue: '#1B4F8A',
                            'blue-dark': '#0F3460',
                            green: '#1F7A3A',
                            gold: '#D4A017',
                            'gold-light': '#E8C04A',
                            surface: '#F7FAFC',
                            border: '#E2E8F0',
                            text: '#1A2E44'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-kisii-surface text-kisii-text font-sans antialiased min-h-screen flex flex-col">
    <!-- Header Banner -->
    <div class="flex h-1.5 w-full">
        <div class="flex-1 bg-kisii-blue"></div>
        <div class="flex-1 bg-white border-x border-kisii-border"></div>
        <div class="flex-1 bg-kisii-green"></div>
    </div>

    <!-- Navigation / Layout -->
    <div class="flex-1 flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-kisii-blue text-white shrink-0 flex flex-col shadow-lg">
            <div class="p-6 bg-kisii-blue-dark flex items-center gap-3">
                <span class="text-2xl">🦁</span>
                <div>
                    <h1 class="font-extrabold text-lg tracking-tight">Kisii County</h1>
                    <p class="text-xs text-kisii-gold font-semibold uppercase tracking-wider">Directory Admin</p>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-kisii-gold font-bold' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.departments.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.departments.*') ? 'bg-white/10 text-kisii-gold font-bold' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                    Departments
                </a>
                <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.staff.*') ? 'bg-white/10 text-kisii-gold font-bold' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                    Staff Directory
                </a>
                <a href="{{ route('admin.county-lines.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.county-lines.*') ? 'bg-white/10 text-kisii-gold font-bold' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                    County Lines
                </a>
            </nav>

            <div class="p-4 border-t border-white/10 bg-kisii-blue-dark">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-white/80">{{ auth()->user()->name }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-kisii-gold hover:text-white hover:underline transition-all">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 md:p-10">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in">
                    <span class="text-lg">✓</span>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
