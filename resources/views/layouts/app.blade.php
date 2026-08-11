<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Layanan Publik' }} - Bapekomdag Yogya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex min-h-full flex-col text-slate-800">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl group-hover:bg-blue-700 transition">B</div>
                            <span class="font-bold text-xl text-slate-900 tracking-tight">Bapekomdag</span>
                        </a>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="/pelatihan" class="{{ request()->is('pelatihan*') ? 'border-blue-500 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition">
                            Pelatihan
                        </a>
                        <a href="/fasilitas" class="{{ request()->is('fasilitas*') ? 'border-blue-500 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition">
                            Fasilitas
                        </a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    @auth('customer')
                        <div class="flex items-center gap-4">
                            <a href="{{ route('dashboard') }}" class="text-sm font-semibold leading-6 text-slate-900 hover:text-blue-600 transition">Dashboard</a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="text-sm font-semibold leading-6 text-red-600 hover:text-red-800 transition">Log out</button>
                            </form>
                        </div>
                    @else
                        <a href="/login" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Log in</a>
                        <a href="/register" class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-white mt-auto border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center space-x-6 md:order-2">
                    <p class="text-sm text-slate-500">
                        Pusat Pelatihan Teknis Perdagangan
                    </p>
                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-sm text-slate-500">&copy; {{ date('Y') }} Balai Pengembangan Kompetensi Perdagangan Yogyakarta. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
