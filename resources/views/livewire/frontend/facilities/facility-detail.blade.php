<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                
                @if($facility->photos->count() > 0)
                    <div x-data="{ currentSlide: 0, totalSlides: {{ $facility->photos->count() }} }" class="relative w-full h-96 bg-slate-100 overflow-hidden group">
                        @foreach($facility->photos as $index => $photo)
                            <img x-show="currentSlide === {{ $index }}"
                                 x-transition:enter="transition ease-in-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in-out duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 src="/storage/{{ $photo->path }}" alt="{{ $facility->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @endforeach
                        
                        @if($facility->photos->count() > 1)
                            <!-- Controls -->
                            <button @click="currentSlide = (currentSlide === 0) ? totalSlides - 1 : currentSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full p-2 transition opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none z-10">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="currentSlide = (currentSlide === totalSlides - 1) ? 0 : currentSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full p-2 transition opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none z-10">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif

                        <div class="absolute bottom-4 right-4 bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium z-10">
                            <span x-text="currentSlide + 1"></span> / {{ $facility->photos->count() }} Foto
                        </div>
                    </div>
                @else
                    <div class="w-full h-64 bg-slate-100 flex items-center justify-center">
                        <span class="text-slate-400">Tidak ada gambar</span>
                    </div>
                @endif
                
                <div class="p-8 sm:p-12">
                    <div class="flex items-center justify-between gap-x-4 mb-6 border-b pb-6">
                        <span class="relative z-10 rounded-full bg-emerald-50 px-3 py-1.5 font-medium text-emerald-600">{{ $facility->type->label() }}</span>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-slate-900">Rp {{ number_format($facility->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-sm text-slate-500 block">per hari</span>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl mb-4">{{ $facility->name }}</h1>
                    
                    <p class="text-lg leading-8 text-slate-600 mb-8">{{ $facility->description }}</p>
                    
                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                        <h3 class="font-semibold text-slate-900 mb-4">Spesifikasi Fasilitas</h3>
                        <ul class="space-y-3 text-sm text-slate-600">
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                Kapasitas: {{ $facility->capacity ? $facility->capacity . ' Orang' : 'Tidak spesifik' }}
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="/fasilitas/{{ $facility->id }}/pesan" class="rounded-md bg-emerald-600 px-8 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition">
                            Ajukan Pemesanan
                        </a>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div>
