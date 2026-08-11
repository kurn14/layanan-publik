<div>
    <div class="bg-white py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Fasilitas Kami</h2>
                <p class="mt-2 text-lg leading-8 text-slate-600">Jelajahi berbagai fasilitas yang dapat Anda pesan untuk mendukung kegiatan instansi Anda.</p>
            </div>
            
            <div class="mt-10 max-w-xl mx-auto">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari fasilitas..." class="block w-full rounded-md border-0 py-3 px-4 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @forelse ($facilities as $facility)
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
                        <div class="max-w-xl mt-6 w-full flex-grow flex flex-col">
                            <div class="flex items-center justify-between gap-x-4 text-xs">
                                <span class="relative z-10 rounded-full bg-emerald-50 px-3 py-1.5 font-medium text-emerald-600">{{ $facility->type->label() }}</span>
                                <span class="text-slate-500 font-semibold text-sm">Rp {{ number_format($facility->price_per_day, 0, ',', '.') }} / hari</span>
                            </div>
                            <div class="group relative mt-3 flex-grow">
                                <h3 class="text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
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
                            <div class="mt-6 z-10 relative">
                                <a href="/fasilitas/{{ $facility->id }}" class="block w-full rounded-md bg-white px-3 py-2 text-center text-sm font-semibold text-emerald-600 shadow-sm ring-1 ring-inset ring-emerald-600 hover:bg-emerald-50 transition">Lihat Detail Fasilitas</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-1 lg:col-span-3 text-center py-12">
                        <p class="text-slate-500">Tidak ada fasilitas yang sesuai dengan kriteria pencarian.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-10">
                {{ $facilities->links() }}
            </div>
        </div>
    </div>
</div>
