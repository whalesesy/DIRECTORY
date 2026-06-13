<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In - Kisii County</title>
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
<body class="bg-kisii-surface min-h-screen flex flex-col justify-between">
    <!-- Header Flag tricolor -->
    <div class="flex h-1.5 w-full">
        <div class="flex-1 bg-kisii-blue"></div>
        <div class="flex-1 bg-white border-x border-kisii-border"></div>
        <div class="flex-1 bg-kisii-green"></div>
    </div>

    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl border border-kisii-border shadow-xl overflow-hidden">
            <div class="bg-kisii-blue p-8 text-center text-white relative">
                <!-- Seal -->
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full border-2 border-kisii-gold/60 bg-kisii-blue-dark/60 backdrop-blur mb-3 shadow-lg">
                    <span class="text-2xl">🦁</span>
                </div>
                <h2 class="text-2xl font-black tracking-tight">Kisii County Directory</h2>
                <p class="text-xs text-kisii-gold font-bold uppercase tracking-widest mt-1">Admin Portal</p>
            </div>

            <form action="{{ route('admin.login') }}" method="POST" class="p-8 space-y-6">
                @csrf

                @if($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/80 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/80 mb-2">Password</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                </div>

                <button type="submit" class="w-full bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all duration-200 mt-2">
                    Sign In to Dashboard
                </button>
            </form>
        </div>
    </main>

    <footer class="py-6 text-center text-xs text-kisii-text-muted border-t border-kisii-border bg-white">
        &copy; {{ date('Y') }} Kisii County Government. All rights reserved.
    </footer>
</body>
</html>
