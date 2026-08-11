<div>
    <!-- Hero Section -->
    <div class="relative isolate overflow-hidden bg-white">
        <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40">
            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl lg:flex-shrink-0 lg:pt-8">
                <h1 class="mt-10 text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl">Layanan Pelatihan & Fasilitas</h1>
                <p class="mt-6 text-lg leading-8 text-slate-600">Selamat datang di Portal Klien Balai Pengembangan Kompetensi Perdagangan Yogyakarta. Temukan dan daftar pelatihan terkini, serta pesan fasilitas terbaik kami untuk kebutuhan instansi Anda secara mudah dan cepat.</p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="/pelatihan" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition">Lihat Pelatihan</a>
                    <a href="/fasilitas" class="text-sm font-semibold leading-6 text-slate-900">Jelajah Fasilitas <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
                <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                    <div class="rounded-xl bg-slate-900/5 p-2 ring-1 ring-inset ring-slate-900/10 lg:-m-4 lg:rounded-2xl lg:p-4">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Training App screenshot" width="2432" height="1442" class="w-[40rem] rounded-md shadow-2xl ring-1 ring-slate-900/10">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pelatihan Terbaru -->
    <div class="bg-slate-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Pelatihan Terkini</h2>
                <p class="mt-2 text-lg leading-8 text-slate-600">Pilih program pelatihan terbaik yang sedang membuka pendaftaran untuk meningkatkan kompetensi Anda.</p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($trainings as $training)
                    <article class="flex flex-col items-start justify-between bg-white p-6 rounded-2xl shadow-sm ring-1 ring-slate-200">
                        <div class="relative w-full">
                            @if($training->image)
                                <img src="/storage/{{ $training->image }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-slate-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            @else
                                <div class="aspect-[16/9] w-full rounded-2xl bg-slate-100 flex items-center justify-center sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <span class="text-slate-400">No Image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-slate-900/10"></div>
                        </div>
                        <div class="max-w-xl mt-6">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $training->start_date->format('Y-m-d') }}" class="text-slate-500">{{ $training->start_date->format('d M Y') }}</time>
                                <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-600 hover:bg-blue-100">{{ $training->type->label() }}</span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
                                    <a href="/pelatihan/{{ $training->id }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $training->name }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600">{{ $training->description }}</p>
                            </div>
                            <div class="mt-4 flex gap-4 text-sm text-slate-500">
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $training->duration_days }} Hari
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    {{ $training->filled_quota }}/{{ $training->max_quota }} Peserta
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if(count($trainings) === 0)
                <p class="text-center text-slate-500 mt-10">Belum ada pelatihan yang membuka pendaftaran saat ini.</p>
            @endif
        </div>
    </div>

    <!-- Fasilitas Terbaru -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Fasilitas Kami</h2>
                <p class="mt-2 text-lg leading-8 text-slate-600">Pesan ruangan atau fasilitas lainnya untuk mendukung kegiatan instansi Anda di lingkungan kami.</p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($facilities as $facility)
                    <article class="flex flex-col items-start justify-between p-6 rounded-2xl ring-1 ring-slate-200">
                        <div class="relative w-full">
                            @if($facility->photos->count() > 0)
                                <img src="/storage/{{ $facility->photos->first()->path }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-slate-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            @else
                                <div class="aspect-[16/9] w-full rounded-2xl bg-slate-100 flex items-center justify-center sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <span class="text-slate-400">No Image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-slate-900/10"></div>
                        </div>
                        <div class="max-w-xl mt-6 w-full">
                            <div class="flex items-center justify-between gap-x-4 text-xs">
                                <span class="relative z-10 rounded-full bg-emerald-50 px-3 py-1.5 font-medium text-emerald-600 hover:bg-emerald-100">{{ $facility->type->label() }}</span>
                                <span class="text-slate-500 font-semibold text-sm">Rp {{ number_format($facility->price_per_day, 0, ',', '.') }} / hari</span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
                                    <a href="/fasilitas/{{ $facility->id }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $facility->name }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600">{{ $facility->description }}</p>
                            </div>
                            <div class="mt-4 flex items-center gap-1 text-sm text-slate-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Kapasitas: {{ $facility->capacity }} Orang
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if(count($facilities) === 0)
                <p class="text-center text-slate-500 mt-10">Belum ada fasilitas yang ditambahkan saat ini.</p>
            @endif
        </div>
    </div>
</div>
