<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Models\FacilityBooking;
use App\Models\Invoice;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Ym') . '-';
        $last = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->lockForUpdate()
            ->first();

        if ($last) {
            $seq = intval(substr($last->invoice_number, -4)) + 1;
        } else {
            $seq = 1;
        }

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public static function createForRegistration(Registration $registration): Invoice
    {
        return DB::transaction(function () use ($registration) {
            $registration->load('training', 'customer');
            $training = $registration->training;

            $invoiceNumber = self::generateInvoiceNumber();
            $totalAmount = $training->price ?? 0;

            $invoice = Invoice::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'invoice_number' => $invoiceNumber,
                    'total_amount' => $totalAmount,
                    'status' => InvoiceStatus::SENT,
                    'due_date' => Carbon::parse($training->start_date)->subDays(7),
                    'line_items' => [
                        [
                            'description' => 'Biaya Kepesertaan ' . $training->name . ' (' . $training->duration_days . ' Hari)',
                            'quantity' => 1,
                            'unit_price' => $totalAmount,
                            'total' => $totalAmount,
                        ],
                    ],
                    'notes' => 'Invoice otomatis — batas pembayaran H-7 sebelum pelatihan dimulai.',
                ]
            );

            self::generatePdf($invoice);

            return $invoice;
        });
    }

    public static function createForBooking(FacilityBooking $booking): Invoice
    {
        return DB::transaction(function () use ($booking) {
            $booking->load('facility', 'customer');
            $facility = $booking->facility;

            $invoiceNumber = self::generateInvoiceNumber();
            $startDate = Carbon::parse($booking->start_date);
            $endDate = Carbon::parse($booking->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1;

            $invoice = Invoice::updateOrCreate(
                ['facility_booking_id' => $booking->id],
                [
                    'invoice_number' => $invoiceNumber,
                    'total_amount' => $booking->total_cost,
                    'status' => InvoiceStatus::SENT,
                    'due_date' => $startDate->copy()->subDays(7),
                    'line_items' => [
                        [
                            'description' => 'Sewa ' . $facility->name . ' (' . $totalDays . ' Hari)',
                            'quantity' => $totalDays,
                            'unit_price' => $facility->price_per_day,
                            'total' => $booking->total_cost,
                        ],
                    ],
                    'notes' => 'Invoice otomatis — batas pembayaran H-7 sebelum tanggal mulai sewa.',
                ]
            );

            self::generatePdf($invoice);

            return $invoice;
        });
    }

    public static function generatePdf(Invoice $invoice): string
    {
        $invoice->load([
            'registration.training',
            'registration.customer',
            'facilityBooking.facility',
            'facilityBooking.customer',
        ]);

        // Determine customer from either registration or booking
        $customer = $invoice->registration?->customer ?? $invoice->facilityBooking?->customer;
        $title = $invoice->registration
            ? $invoice->registration->training->name
            : $invoice->facilityBooking->facility->name;

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'customer' => $customer,
            'title' => $title,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'invoices/' . $invoice->invoice_number . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }
}
