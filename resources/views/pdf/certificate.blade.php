<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1e293b;
            width: 297mm;
            height: 210mm;
            background: #ffffff;
        }
        
        .container {
            padding: 12mm 15mm;
            width: 297mm;
            height: 210mm;
        }

        .border-outer {
            border: 3px solid #1e3a8a;
            padding: 4px;
            width: 100%;
            height: 186mm;
        }

        .border-inner {
            border: 1px solid #93c5fd;
            padding: 8mm 12mm;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        
        /* Header */
        .cert-header { margin-bottom: 6px; }
        .cert-institution {
            font-size: 14px;
            color: #1e40af;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .cert-institution-sub {
            font-size: 9px;
            color: #64748b;
            letter-spacing: 1px;
        }
        
        /* Title */
        .cert-title {
            font-size: 26px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 6px;
            text-transform: uppercase;
            margin: 6px 0 2px;
        }
        .cert-subtitle {
            font-size: 10px;
            color: #64748b;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        
        /* Separator */
        .separator {
            width: 80px;
            height: 2px;
            background: #1e40af;
            margin: 0 auto 10px;
        }
        
        /* Body */
        .cert-body-text {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .cert-name {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin: 4px 0;
            padding-bottom: 3px;
            border-bottom: 2px solid #1e40af;
            display: inline-block;
        }
        .cert-origin {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 6px;
        }
        .cert-training-name {
            font-size: 13px;
            font-weight: bold;
            color: #1e40af;
            margin: 4px 0;
        }
        .cert-details {
            font-size: 9px;
            color: #475569;
            margin-bottom: 2px;
        }
        
        /* Certificate Number */
        .cert-number {
            font-size: 9px;
            color: #94a3b8;
            letter-spacing: 1px;
            margin-top: 6px;
        }
        
        /* Signature Section */
        .signature-table {
            width: 100%;
            margin-top: 8px;
        }
        .signature-block {
            text-align: center;
            width: 40%;
        }
        .signature-line {
            width: 170px;
            border-bottom: 1px solid #1e293b;
            margin: 22px auto 4px;
        }
        .signature-name {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
        }
        .signature-title {
            font-size: 8px;
            color: #64748b;
        }
        .signature-date {
            font-size: 8px;
            color: #64748b;
            margin-bottom: 2px;
        }
        
        /* Footer */
        .cert-footer {
            margin-top: 6px;
            text-align: center;
            font-size: 7.5px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="border-outer">
            <div class="border-inner">
                <!-- Header -->
                <div class="cert-header">
                    <div class="cert-institution">BAPEKOMDAG</div>
                    <div class="cert-institution-sub">Badan Pendidikan dan Pelatihan Keuangan Daerah</div>
                    <div class="cert-institution-sub">Provinsi Daerah Istimewa Yogyakarta</div>
                </div>

                <!-- Title -->
                <div class="cert-title">SERTIFIKAT</div>
                <div class="cert-subtitle">Certificate of Completion</div>
                <div class="separator"></div>

                <!-- Body -->
                <div class="cert-body-text">Dengan ini menerangkan bahwa:</div>
                <div class="cert-name">{{ $customer->name }}</div>
                @if($customer->origin_institution)
                    <div class="cert-origin">{{ $customer->origin_institution }}</div>
                @endif

                <div class="cert-body-text" style="margin-top: 8px;">Telah mengikuti dan dinyatakan <strong>LULUS</strong> dalam:</div>
                <div class="cert-training-name">{{ $training->name }}</div>
                <div class="cert-details">
                    Dilaksanakan pada {{ $training->start_date->translatedFormat('d F Y') }} s.d. {{ $training->end_date->translatedFormat('d F Y') }}
                </div>
                <div class="cert-details">Durasi: {{ $training->duration_days }} Hari Pelatihan</div>
                <div class="cert-details">Lokasi: {{ $training->location }}</div>

                <!-- Certificate Number -->
                <div class="cert-number">No. {{ $certificate->certificate_number }}</div>

                <!-- Signature -->
                <table class="signature-table">
                    <tr>
                        <td style="width: 30%;">&nbsp;</td>
                        <td class="signature-block">
                            <div class="signature-date">Yogyakarta, {{ $certificate->issued_date->translatedFormat('d F Y') }}</div>
                            <div class="signature-title">Kepala BAPEKOMDAG DIY</div>
                            <div class="signature-line"></div>
                            <div class="signature-name">Dr. H. Supriyadi, M.M.</div>
                            <div class="signature-title">NIP. 197205141998031002</div>
                        </td>
                        <td style="width: 30%;">&nbsp;</td>
                    </tr>
                </table>

                <div class="cert-footer">
                    Sertifikat ini diterbitkan secara elektronik dan sah tanpa tanda tangan basah.
                    Verifikasi: {{ config('app.url') }}/verifikasi/{{ $certificate->certificate_number }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
