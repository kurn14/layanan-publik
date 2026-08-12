<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $certificate->certificate_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; }
        
        .certificate-page {
            width: 100%;
            height: 100%;
            position: relative;
            padding: 50px 70px;
            background: #ffffff;
        }
        
        /* Decorative Border */
        .border-outer {
            border: 3px solid #1e3a8a;
            padding: 8px;
            height: 100%;
        }
        .border-inner {
            border: 1px solid #93c5fd;
            padding: 40px 50px;
            height: 100%;
            text-align: center;
        }
        
        /* Corner decorations */
        .corner-tl, .corner-tr, .corner-bl, .corner-br {
            position: absolute;
            width: 60px;
            height: 60px;
            border-color: #1e40af;
        }
        
        /* Header */
        .cert-header { margin-bottom: 15px; }
        .cert-institution {
            font-size: 14px;
            color: #1e40af;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .cert-institution-sub {
            font-size: 10px;
            color: #64748b;
            letter-spacing: 1px;
        }
        
        /* Title */
        .cert-title {
            font-size: 36px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 8px;
            text-transform: uppercase;
            margin: 20px 0 8px;
        }
        .cert-subtitle {
            font-size: 12px;
            color: #64748b;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
        }
        
        /* Separator */
        .separator {
            width: 120px;
            height: 3px;
            background: #1e40af;
            margin: 0 auto 25px;
        }
        
        /* Body */
        .cert-body-text {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
        }
        .cert-name {
            font-size: 26px;
            font-weight: bold;
            color: #0f172a;
            margin: 10px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #1e40af;
            display: inline-block;
        }
        .cert-origin {
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 15px;
        }
        .cert-training-name {
            font-size: 15px;
            font-weight: bold;
            color: #1e40af;
            margin: 8px 0;
        }
        .cert-details {
            font-size: 11px;
            color: #475569;
            margin-bottom: 4px;
        }
        
        /* Certificate Number */
        .cert-number {
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 1px;
            margin-top: 15px;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 30px;
        }
        .signature-section table { width: 100%; }
        .signature-block {
            text-align: center;
            width: 40%;
        }
        .signature-line {
            width: 180px;
            border-bottom: 1px solid #1e293b;
            margin: 50px auto 8px;
        }
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
        }
        .signature-title {
            font-size: 10px;
            color: #64748b;
        }
        .signature-date {
            font-size: 10px;
            color: #94a3b8;
            margin-bottom: 5px;
        }
        
        /* Footer */
        .cert-footer {
            position: absolute;
            bottom: 65px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="certificate-page">
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

                <div class="cert-body-text" style="margin-top: 15px;">Telah mengikuti dan dinyatakan <strong>LULUS</strong> dalam:</div>
                <div class="cert-training-name">{{ $training->name }}</div>
                <div class="cert-details">
                    Dilaksanakan pada {{ $training->start_date->translatedFormat('d F Y') }} s.d. {{ $training->end_date->translatedFormat('d F Y') }}
                </div>
                <div class="cert-details">Durasi: {{ $training->duration_days }} Hari Pelatihan</div>
                <div class="cert-details">Lokasi: {{ $training->location }}</div>

                <!-- Certificate Number -->
                <div class="cert-number">No. {{ $certificate->certificate_number }}</div>

                <!-- Signature -->
                <div class="signature-section">
                    <table>
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
                </div>
            </div>
        </div>

        <div class="cert-footer">
            Sertifikat ini diterbitkan secara elektronik dan sah tanpa tanda tangan basah.
            Verifikasi: {{ config('app.url') }}/verifikasi/{{ $certificate->certificate_number }}
        </div>
    </div>
</body>
</html>
