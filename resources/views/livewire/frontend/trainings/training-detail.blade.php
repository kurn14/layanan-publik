<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                @if($training->image)
                    <img src="/storage/{{ $training->image }}" alt="{{ $training->name }}" class="w-full h-96 object-cover bg-slate-100">
                @else
                    <div class="w-full h-64 bg-slate-100 flex items-center justify-center">
                        <span class="text-slate-400">Tidak ada gambar</span>
                    </div>
                @endif
                
                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-x-4 text-sm mb-6">
                        <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-600">{{ $training->type->label() }}</span>
                        <span class="text-slate-500 {{ $training->status === \App\Enums\TrainingStatus::OPEN ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">{{ $training->status->label() }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl mb-4">{{ $training->name }}</h1>
                    
                    <p class="text-lg leading-8 text-slate-600 mb-8">{{ $training->description }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-b py-8 my-8 border-slate-100">
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-2">Informasi Jadwal</h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                    {{ $training->start_date->format('d M Y') }} - {{ $training->end_date->format('d M Y') }}
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Durasi: {{ $training->duration_days }} Hari
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                    {{ $training->location ?? 'Belum ditentukan' }}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-2">Kuota & Persyaratan</h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                    Terisi: {{ $training->filled_quota }} dari {{ $training->max_quota }} Peserta
                                </li>
                                @if($training->requirements)
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-slate-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                                    <span>Syarat: {{ $training->requirements }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="/pelatihan/{{ $training->id }}/daftar" class="rounded-md bg-blue-600 px-8 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition {{ $training->status !== \App\Enums\TrainingStatus::OPEN ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                            {{ $training->status === \App\Enums\TrainingStatus::OPEN ? 'Daftar Pelatihan Ini' : 'Pendaftaran Ditutup' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
