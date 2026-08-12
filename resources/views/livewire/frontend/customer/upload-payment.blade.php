<div>
    <div class="bg-slate-50 py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 p-8 sm:p-12">
                <div class="mb-8 border-b border-slate-100 pb-8 text-center">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl mb-2">Upload Bukti Pembayaran</h1>
                    <p class="text-slate-600 font-medium">Invoice #{{ $invoice->invoice_number }}</p>
                </div>

                <!-- Invoice Summary -->
                <div class="rounded-xl bg-slate-50 p-6 border border-slate-200 mb-8">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-slate-500">Total Tagihan</span>
                        <span class="text-2xl font-bold text-slate-900">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-500">Jatuh Tempo</span>
                        <span class="text-sm font-medium text-slate-700">{{ $invoice->due_date->format('d M Y') }}</span>
                    </div>
                    @if($invoice->line_items)
                        <hr class="my-3 border-slate-200">
                        @foreach($invoice->line_items as $item)
                            <div class="flex justify-between items-center text-sm text-slate-600">
                                <span>{{ $item['description'] ?? '-' }}</span>
                                <span>Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Bank Info -->
                <div class="rounded-xl bg-blue-50 p-6 border border-blue-200 mb-8">
                    <h3 class="text-sm font-semibold text-blue-900 mb-3">Informasi Rekening Tujuan</h3>
                    <div class="space-y-1 text-sm text-blue-800">
                        <p><span class="font-medium">Bank:</span> Bank BRI — Cabang Yogyakarta</p>
                        <p><span class="font-medium">No. Rekening:</span> 0012-01-002345-30-8</p>
                        <p><span class="font-medium">Atas Nama:</span> Bendahara Penerimaan BAPEKOMDAG</p>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                        <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                    </div>
                @endif

                @error('general')
                    <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                        <p class="text-sm font-medium text-red-800">{{ $message }}</p>
                    </div>
                @enderror

                <form wire:submit="submit" class="space-y-6">
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium leading-6 text-slate-900">Metode Pembayaran</label>
                        <div class="mt-2">
                            <select wire:model="payment_method" id="payment_method" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                <option value="">— Pilih Metode —</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->value }}">{{ $method->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('payment_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Proof File -->
                    <div>
                        <label for="proof_file" class="block text-sm font-medium leading-6 text-slate-900">Bukti Pembayaran (Foto / Screenshot)</label>
                        <div class="mt-2">
                            <input type="file" wire:model="proof_file" id="proof_file" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        @error('proof_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="proof_file" class="mt-2 text-sm text-blue-600">Mengunggah...</div>
                        @if($proof_file)
                            <div class="mt-3">
                                <img src="{{ $proof_file->temporaryUrl() }}" class="h-40 rounded-lg border border-slate-200">
                            </div>
                        @endif
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium leading-6 text-slate-900">Catatan (Opsional)</label>
                        <div class="mt-2">
                            <textarea wire:model="notes" id="notes" rows="2" class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('dashboard') }}" class="mr-3 rounded-md bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-200 transition">Batal</a>
                        <button type="submit" class="rounded-md bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition" wire:loading.attr="disabled">
                            <span wire:loading.remove>Kirim Bukti Bayar</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
