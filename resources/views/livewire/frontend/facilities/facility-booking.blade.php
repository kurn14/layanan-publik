<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8 sm:p-12">
                <div class="mb-8 border-b border-slate-100 pb-8 text-center">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl mb-2">Formulir Pemesanan Fasilitas</h1>
                    <p class="text-slate-600 font-medium">{{ $facility->name }}</p>
                </div>

                @if (session()->has('message'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @error('general')
                    <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @enderror

                <form wire:submit="submit" class="space-y-8">
                    
                    <!-- Customer Data Section -->
                    @if(auth()->guard('customer')->check())
                        <div class="rounded-xl bg-slate-50 p-6 border border-slate-200 flex items-start gap-4 mb-8">
                            <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-xl font-bold shrink-0">
                                {{ strtoupper(substr(auth()->guard('customer')->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-1">Pemesanan dilakukan sebagai:</h3>
                                <p class="text-lg font-bold text-slate-900">{{ auth()->guard('customer')->user()->name }}</p>
                                <p class="text-sm text-slate-600 mt-1">{{ auth()->guard('customer')->user()->email }} &bull; {{ auth()->guard('customer')->user()->phone }}</p>
                                @if(auth()->guard('customer')->user()->institution_name)
                                    <p class="text-sm text-slate-600">{{ auth()->guard('customer')->user()->institution_name }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-slate-900 mb-4">Informasi Pemesan</h2>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                            <!-- Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium leading-6 text-slate-900">Nama Lengkap</label>
                                <div class="mt-2">
                                    <input type="text" wire:model="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-1">
                                <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email</label>
                                <div class="mt-2">
                                    <input type="email" wire:model="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="sm:col-span-1">
                                <label for="phone" class="block text-sm font-medium leading-6 text-slate-900">No. WhatsApp/Telepon</label>
                                <div class="mt-2">
                                    <input type="text" wire:model="phone" id="phone" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- NIK -->
                            <div class="sm:col-span-1">
                                <label for="nik" class="block text-sm font-medium leading-6 text-slate-900">NIK</label>
                                <div class="mt-2">
                                    <input type="text" wire:model="nik" id="nik" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Institution -->
                            <div class="sm:col-span-1">
                                <label for="institution" class="block text-sm font-medium leading-6 text-slate-900">Asal Instansi</label>
                                <div class="mt-2">
                                    <input type="text" wire:model="institution" id="institution" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('institution') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password Section -->
                            <div class="sm:col-span-2 pt-4 border-t border-slate-100 mt-2">
                                <p class="text-sm text-slate-500 mb-4">Buat password untuk akun Anda agar dapat mengelola pemesanan di Dashboard.</p>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Password</label>
                                <div class="mt-2">
                                    <input type="password" wire:model="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Konfirmasi Password</label>
                                <div class="mt-2">
                                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Booking Data Section -->
                    <div class="pt-6 border-t border-slate-100">
                        <h2 class="text-base font-semibold leading-7 text-slate-900 mb-4">Detail Pemesanan</h2>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                            <!-- Start Date -->
                            <div class="sm:col-span-1">
                                <label for="start_date" class="block text-sm font-medium leading-6 text-slate-900">Tanggal Mulai</label>
                                <div class="mt-2">
                                    <input type="date" wire:model="start_date" id="start_date" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6" min="{{ date('Y-m-d') }}">
                                </div>
                                @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- End Date -->
                            <div class="sm:col-span-1">
                                <label for="end_date" class="block text-sm font-medium leading-6 text-slate-900">Tanggal Selesai</label>
                                <div class="mt-2">
                                    <input type="date" wire:model="end_date" id="end_date" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6" min="{{ $start_date ?? date('Y-m-d') }}">
                                </div>
                                @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Purpose -->
                            <div class="sm:col-span-2">
                                <label for="purpose" class="block text-sm font-medium leading-6 text-slate-900">Tujuan Penggunaan</label>
                                <div class="mt-2">
                                    <textarea wire:model="purpose" id="purpose" rows="3" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6"></textarea>
                                </div>
                                @error('purpose') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Price Info (Livewire reactivity) -->
                    @if($start_date && $end_date)
                        @php
                            try {
                                $start = \Carbon\Carbon::parse($start_date);
                                $end = \Carbon\Carbon::parse($end_date);
                                if ($end->greaterThanOrEqualTo($start)) {
                                    $days = $start->diffInDays($end) + 1;
                                    $total = $days * $facility->price_per_day;
                                }
                            } catch (\Exception $e) {}
                        @endphp
                        @if(isset($total))
                        <div class="rounded-xl bg-slate-50 p-6 border border-slate-100 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-slate-600">Total Harga ({{ $days }} Hari)</p>
                                <p class="text-xs text-slate-500">Rp {{ number_format($facility->price_per_day, 0, ',', '.') }} / hari</p>
                            </div>
                            <div class="text-2xl font-bold text-slate-900">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </div>
                        </div>
                        @endif
                    @endif

                    <!-- Terms -->
                    <div class="sm:col-span-2 flex items-start pt-4">
                        <div class="flex h-6 items-center">
                            <input id="agree_terms" wire:model="agree_terms" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="agree_terms" class="font-medium text-slate-900">Syarat dan Ketentuan</label>
                            <p class="text-slate-500">Saya menyetujui syarat pemesanan fasilitas dan akan mematuhi peraturan yang berlaku selama penggunaan.</p>
                            @error('agree_terms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="rounded-md bg-emerald-600 px-8 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition" wire:loading.attr="disabled">
                            <span wire:loading.remove>Ajukan Pemesanan</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
