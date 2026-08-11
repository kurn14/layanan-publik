<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Daftar Pelatihan</h2>
                <p class="mt-2 text-lg leading-8 text-slate-600">Jelajahi berbagai program pelatihan untuk meningkatkan kompetensi dan kemampuan Anda.</p>
            </div>
            
            <div class="mt-10 max-w-xl mx-auto">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pelatihan..." class="block w-full rounded-md border-0 py-3 px-4 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @forelse ($trainings as $training)
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
                                <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-600">{{ $training->type->label() }}</span>
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
                            <div class="mt-6 z-10 relative">
                                <a href="/pelatihan/{{ $training->id }}" class="block w-full rounded-md bg-white px-3 py-2 text-center text-sm font-semibold text-blue-600 shadow-sm ring-1 ring-inset ring-blue-600 hover:bg-blue-50 transition">Lihat Detail Pelatihan</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-1 lg:col-span-3 text-center py-12">
                        <p class="text-slate-500">Tidak ada pelatihan yang sesuai dengan kriteria pencarian.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-10">
                {{ $trainings->links() }}
            </div>
        </div>
    </div>
</div>
