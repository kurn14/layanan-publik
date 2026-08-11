<div>
    <div class="bg-slate-50 py-12 sm:py-24 min-h-screen">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-8">Dashboard Pelanggan</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profil Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">{{ $customer->name }}</h2>
                                <p class="text-sm text-slate-500">{{ $customer->client_type->label() ?? 'Personal' }}</p>
                            </div>
                        </div>
                        
                        <dl class="space-y-4 text-sm text-slate-600">
                            <div>
                                <dt class="font-medium text-slate-900">Email</dt>
                                <dd>{{ $customer->email }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-slate-900">Telepon</dt>
                                <dd>{{ $customer->phone }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-slate-900">Instansi</dt>
                                <dd>{{ $customer->origin_institution ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-slate-900">Jabatan</dt>
                                <dd>{{ $customer->position ?? '-' }}</dd>
                            </div>
                            <div class="pt-4 mt-4 border-t border-slate-100">
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- History Tabs -->
                <div class="lg:col-span-2">
                    <!-- Pelatihan -->
                    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8 mb-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Riwayat Pelatihan</h2>
                        @if($customer->registrations->count() > 0)
                            <ul role="list" class="divide-y divide-slate-100">
                                @foreach($customer->registrations as $reg)
                                    <li class="py-5 flex justify-between gap-x-6">
                                        <div class="flex min-w-0 gap-x-4">
                                            <div class="min-w-0 flex-auto">
                                                <p class="text-sm font-semibold leading-6 text-slate-900">{{ $reg->training->name }}</p>
                                                <p class="mt-1 truncate text-xs leading-5 text-slate-500">Didaftarkan: {{ $reg->registered_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 flex flex-col items-end">
                                            <p class="text-sm leading-6 text-slate-900">
                                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                                    @if($reg->status === \App\Enums\RegistrationStatus::PENDING) bg-yellow-50 text-yellow-800 ring-yellow-600/20
                                                    @elseif($reg->status === \App\Enums\RegistrationStatus::CONFIRMED) bg-green-50 text-green-700 ring-green-600/20
                                                    @elseif($reg->status === \App\Enums\RegistrationStatus::REJECTED) bg-red-50 text-red-700 ring-red-600/10
                                                    @else bg-slate-50 text-slate-600 ring-slate-500/10
                                                    @endif
                                                ">
                                                    {{ $reg->status->label() }}
                                                </span>
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-6">
                                <p class="text-sm text-slate-500">Belum ada riwayat pendaftaran pelatihan.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Fasilitas -->
                    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Riwayat Pemesanan Fasilitas</h2>
                        @if($customer->facilityBookings->count() > 0)
                            <ul role="list" class="divide-y divide-slate-100">
                                @foreach($customer->facilityBookings as $booking)
                                    <li class="py-5 flex justify-between gap-x-6">
                                        <div class="flex min-w-0 gap-x-4">
                                            <div class="min-w-0 flex-auto">
                                                <p class="text-sm font-semibold leading-6 text-slate-900">{{ $booking->facility->name }}</p>
                                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - 
                                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                                    ({{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} Hari)
                                                </p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 flex flex-col items-end">
                                            <p class="text-sm font-semibold leading-6 text-slate-900 mb-1">Rp {{ number_format($booking->total_cost, 0, ',', '.') }}</p>
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                                @if($booking->status === \App\Enums\BookingStatus::PENDING) bg-yellow-50 text-yellow-800 ring-yellow-600/20
                                                @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED) bg-green-50 text-green-700 ring-green-600/20
                                                @elseif($booking->status === \App\Enums\BookingStatus::ONGOING) bg-blue-50 text-blue-700 ring-blue-700/10
                                                @elseif($booking->status === \App\Enums\BookingStatus::CANCELLED) bg-red-50 text-red-700 ring-red-600/10
                                                @else bg-slate-50 text-slate-600 ring-slate-500/10
                                                @endif
                                            ">
                                                {{ $booking->status->label() }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-6">
                                <p class="text-sm text-slate-500">Belum ada riwayat pemesanan fasilitas.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
