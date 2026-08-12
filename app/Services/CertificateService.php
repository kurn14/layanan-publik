<?php

namespace App\Services;

use App\Enums\CertificateStatus;
use App\Models\Certificate;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public static function generateCertificateNumber(): string
    {
        $prefix = 'CERT-' . date('Ym') . '-';
        $last = Certificate::where('certificate_number', 'like', $prefix . '%')
            ->orderBy('certificate_number', 'desc')
            ->lockForUpdate()
            ->first();

        if ($last) {
            $seq = intval(substr($last->certificate_number, -4)) + 1;
        } else {
            $seq = 1;
        }

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public static function createForRegistration(Registration $registration): Certificate
    {
        return DB::transaction(function () use ($registration) {
            $certNumber = self::generateCertificateNumber();

            $certificate = Certificate::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'certificate_number' => $certNumber,
                    'issued_date' => now(),
                    'status' => CertificateStatus::ISSUED,
                ]
            );

            // Generate PDF
            self::generatePdf($certificate);

            return $certificate;
        });
    }

    public static function generatePdf(Certificate $certificate): string
    {
        $certificate->load('registration.training', 'registration.customer');

        $pdf = Pdf::loadView('pdf.certificate', [
            'certificate' => $certificate,
            'registration' => $certificate->registration,
            'training' => $certificate->registration->training,
            'customer' => $certificate->registration->customer,
        ]);

        $pdf->setPaper('A4', 'landscape');

        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $certificate->update(['file_path' => $filename]);

        return $filename;
    }
}
