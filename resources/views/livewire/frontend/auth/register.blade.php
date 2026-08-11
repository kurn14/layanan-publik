<div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-xl">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-slate-900">Daftar Akun Klien</h2>
            <p class="mt-2 text-center text-sm text-slate-600">
                Sudah punya akun?
                <a href="/login" class="font-semibold text-blue-600 hover:text-blue-500">Masuk di sini</a>
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-xl bg-white p-8 shadow-sm ring-1 ring-slate-200 rounded-xl">
            <form wire:submit="register" class="space-y-6">
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium leading-6 text-slate-900">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input wire:model="name" type="text" id="name" required class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Alamat Email <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input wire:model="email" type="email" id="email" required class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Password <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input wire:model="password" type="password" id="password" required class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input wire:model="password_confirmation" type="password" id="password_confirmation" required class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2 border-t border-slate-200 pt-6 mt-2">
                        <h3 class="text-sm font-semibold text-slate-900">Informasi Tambahan</h3>
                    </div>

                    <div>
                        <label for="id_number" class="block text-sm font-medium leading-6 text-slate-900">NIK / Nomor Identitas</label>
                        <div class="mt-2">
                            <input wire:model="id_number" type="text" id="id_number" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('id_number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium leading-6 text-slate-900">Nomor Telepon / WhatsApp</label>
                        <div class="mt-2">
                            <input wire:model="phone" type="text" id="phone" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="client_type" class="block text-sm font-medium leading-6 text-slate-900">Tipe Klien <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <select wire:model.live="client_type" id="client_type" required class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option value="INDIVIDUAL">Individu / Pribadi</option>
                                <option value="INSTITUTION">Instansi / Perusahaan</option>
                            </select>
                        </div>
                        @error('client_type') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium leading-6 text-slate-900">Jabatan <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                        <div class="mt-2">
                            <input wire:model="position" type="text" id="position" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('position') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="origin_institution" class="block text-sm font-medium leading-6 text-slate-900">Asal Instansi <span class="text-slate-400 font-normal text-xs" x-show="$wire.client_type === 'INDIVIDUAL'">(Opsional)</span><span class="text-red-500" x-show="$wire.client_type === 'INSTITUTION'">*</span></label>
                        <div class="mt-2">
                            <input wire:model="origin_institution" type="text" id="origin_institution" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('origin_institution') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="pt-4">
                    <button type="submit" class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span wire:loading.remove wire:target="register">Daftar Akun</span>
                        <span wire:loading wire:target="register">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
