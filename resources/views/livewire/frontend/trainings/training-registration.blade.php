<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8 sm:p-12">
                <div class="mb-8 border-b border-slate-100 pb-8 text-center">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl mb-2">Formulir Pendaftaran Pelatihan</h1>
                    <p class="text-slate-600 font-medium">{{ $training->name }}</p>
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

                <form wire:submit="submit" class="space-y-6">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                        <!-- Name -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium leading-6 text-slate-900">Nama Lengkap</label>
                            <div class="mt-2">
                                <input type="text" wire:model="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" @if(auth()->guard('customer')->check()) disabled @endif>
                            </div>
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-1">
                            <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email</label>
                            <div class="mt-2">
                                <input type="email" wire:model="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" @if(auth()->guard('customer')->check()) disabled @endif>
                            </div>
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="sm:col-span-1">
                            <label for="phone" class="block text-sm font-medium leading-6 text-slate-900">No. WhatsApp/Telepon</label>
                            <div class="mt-2">
                                <input type="text" wire:model="phone" id="phone" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" @if(auth()->guard('customer')->check()) disabled @endif>
                            </div>
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- NIK -->
                        <div class="sm:col-span-1">
                            <label for="nik" class="block text-sm font-medium leading-6 text-slate-900">NIK</label>
                            <div class="mt-2">
                                <input type="text" wire:model="nik" id="nik" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" @if(auth()->guard('customer')->check()) disabled @endif>
                            </div>
                            @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Institution -->
                        <div class="sm:col-span-1">
                            <label for="institution" class="block text-sm font-medium leading-6 text-slate-900">Asal Instansi</label>
                            <div class="mt-2">
                                <input type="text" wire:model="institution" id="institution" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" @if(auth()->guard('customer')->check()) disabled @endif>
                            </div>
                            @error('institution') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        @if(!auth()->guard('customer')->check())
                        <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                            <p class="text-sm text-slate-500 mb-4">Buat password untuk akun Anda. Akun ini dapat digunakan untuk masuk ke Dashboard dan melacak pendaftaran Anda di kemudian hari.</p>
                        </div>
                        
                        <!-- Password -->
                        <div class="sm:col-span-1">
                            <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Password</label>
                            <div class="mt-2">
                                <input type="password" wire:model="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="sm:col-span-1">
                            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Konfirmasi Password</label>
                            <div class="mt-2">
                                <input type="password" wire:model="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        @endif

                        <!-- Terms -->
                        <div class="sm:col-span-2 flex items-start pt-4">
                            <div class="flex h-6 items-center">
                                <input id="agree_terms" wire:model="agree_terms" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="agree_terms" class="font-medium text-slate-900">Syarat dan Ketentuan</label>
                                <p class="text-slate-500">Saya menyetujui bahwa data yang saya masukkan adalah benar dan bersedia mengikuti syarat pendaftaran yang berlaku.</p>
                                @error('agree_terms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="rounded-md bg-blue-600 px-8 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition" wire:loading.attr="disabled">
                            <span wire:loading.remove>Daftar Sekarang</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
