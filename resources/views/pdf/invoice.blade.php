<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1e293b; line-height: 1.5; }
        .container { padding: 40px; }
        
        /* Header */
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #1e40af; padding-bottom: 20px; margin-bottom: 30px; }
        .header-left { width: 60%; }
        .header-right { width: 35%; text-align: right; }
        .company-name { font-size: 22px; font-weight: bold; color: #1e40af; margin-bottom: 4px; }
        .company-desc { font-size: 10px; color: #64748b; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #1e40af; }
        .invoice-number { font-size: 13px; color: #475569; margin-top: 4px; }
        
        /* Info Section */
        .info-section { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .info-block { width: 48%; }
        .info-block h3 { font-size: 11px; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600; }
        .info-block p { font-size: 12px; color: #334155; margin-bottom: 3px; }
        .info-block .value { font-weight: 600; color: #0f172a; }
        
        /* Status Badge */
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-sent { background: #dbeafe; color: #1e40af; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-settled { background: #d1fae5; color: #065f46; }
        .status-draft { background: #f1f5f9; color: #475569; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        
        /* Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table thead th { background: #1e40af; color: #ffffff; padding: 10px 12px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        .items-table thead th:last-child,
        .items-table thead th:nth-child(2),
        .items-table thead th:nth-child(3) { text-align: right; }
        .items-table tbody td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        .items-table tbody td:last-child,
        .items-table tbody td:nth-child(2),
        .items-table tbody td:nth-child(3) { text-align: right; }
        .items-table tbody tr:last-child td { border-bottom: 2px solid #1e40af; }
        
        /* Totals */
        .totals { text-align: right; margin-bottom: 30px; }
        .totals table { margin-left: auto; width: 280px; }
        .totals td { padding: 6px 12px; font-size: 12px; }
        .totals .total-row td { font-size: 16px; font-weight: bold; color: #1e40af; border-top: 2px solid #1e40af; padding-top: 10px; }
        
        /* Notes */
        .notes { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 30px; }
        .notes h3 { font-size: 11px; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px; }
        .notes p { font-size: 11px; color: #64748b; }
        
        /* Footer */
        .footer { border-top: 1px solid #e2e8f0; padding-top: 16px; text-align: center; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <table style="width:100%; margin-bottom: 30px; border-bottom: 3px solid #1e40af; padding-bottom: 15px;">
            <tr>
                <td style="width:60%; vertical-align: top; padding-bottom: 15px;">
                    <div class="company-name">BAPEKOMDAG</div>
                    <div class="company-desc">Badan Pendidikan dan Pelatihan Keuangan Daerah</div>
                    <div class="company-desc">Jl. Kusumanegara No. 3, Yogyakarta 55166</div>
                    <div class="company-desc">Telp: (0274) 562811 | Email: layanan@bapekomdag.go.id</div>
                </td>
                <td style="width:40%; text-align: right; vertical-align: top; padding-bottom: 15px;">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">#{{ $invoice->invoice_number }}</div>
                </td>
            </tr>
        </table>

        <!-- Info -->
        <table style="width:100%; margin-bottom: 30px;">
            <tr>
                <td style="width:50%; vertical-align: top;">
                    <h3 style="font-size: 11px; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Ditagihkan Kepada</h3>
                    <p style="font-weight: 600; color: #0f172a; margin-bottom: 3px;">{{ $customer->name ?? '-' }}</p>
                    <p style="color: #334155; margin-bottom: 3px;">{{ $customer->email ?? '-' }}</p>
                    <p style="color: #334155; margin-bottom: 3px;">{{ $customer->phone ?? '-' }}</p>
                    @if($customer->origin_institution)
                        <p style="color: #334155;">{{ $customer->origin_institution }}</p>
                    @endif
                </td>
                <td style="width:50%; vertical-align: top; text-align: right;">
                    <h3 style="font-size: 11px; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Detail Invoice</h3>
                    <p style="color: #334155; margin-bottom: 3px;"><strong>Tanggal Terbit:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
                    <p style="color: #334155; margin-bottom: 3px;"><strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
                    <p style="color: #334155; margin-bottom: 3px;"><strong>Layanan:</strong> {{ $title }}</p>
                    <p style="margin-top: 8px;">
                        <span class="status-badge status-{{ $invoice->status->value }}">{{ $invoice->status->label() }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Deskripsi</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 20%;">Harga Satuan</th>
                    <th style="width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if($invoice->line_items)
                    @foreach($invoice->line_items as $item)
                        <tr>
                            <td>{{ $item['description'] ?? '-' }}</td>
                            <td style="text-align: right;">{{ $item['quantity'] ?? 1 }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
            <div class="notes">
                <h3>Catatan</h3>
                <p>{{ $invoice->notes }}</p>
            </div>
        @endif

        <!-- Payment Info -->
        <div class="notes">
            <h3>Informasi Pembayaran</h3>
            <p style="margin-bottom: 4px;"><strong>Bank:</strong> Bank BRI — Cabang Yogyakarta</p>
            <p style="margin-bottom: 4px;"><strong>Nomor Rekening:</strong> 0012-01-002345-30-8 (Rekening Kas BLU)</p>
            <p><strong>Atas Nama:</strong> Bendahara Penerimaan BAPEKOMDAG</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="margin-top: 20px;">
            <p>Invoice ini diterbitkan secara otomatis oleh sistem dan sah tanpa tanda tangan.</p>
            <p>Untuk informasi lebih lanjut, hubungi bagian Keuangan BAPEKOMDAG di (0274) 562811.</p>
        </div>
    </div>
</body>
</html>
