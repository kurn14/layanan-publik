<?php

namespace App\Filament\Widgets;

use App\Models\FacilityBooking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestFacilityBookingsWidget extends BaseWidget
{
    protected static ?string $heading = '10 Pemesanan Fasilitas Terakhir';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FacilityBooking::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Pemesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facility.name')
                    ->label('Fasilitas'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('export_excel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $records = \App\Models\FacilityBooking::query()->latest()->limit(10)->get();
                        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();

                        $sheet->setCellValue('A1', 'Pemesan');
                        $sheet->setCellValue('B1', 'Fasilitas');
                        $sheet->setCellValue('C1', 'Tanggal Mulai');
                        $sheet->setCellValue('D1', 'Tanggal Selesai');
                        $sheet->setCellValue('E1', 'Status');

                        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

                        $row = 2;
                        foreach ($records as $record) {
                            $sheet->setCellValue('A' . $row, $record->customer->name ?? '-');
                            $sheet->setCellValue('B' . $row, $record->facility->name ?? '-');
                            $sheet->setCellValue('C' . $row, $record->start_date->format('Y-m-d'));
                            $sheet->setCellValue('D' . $row, $record->end_date->format('Y-m-d'));
                            $sheet->setCellValue('E' . $row, $record->status->label());
                            $row++;
                        }

                        foreach (range('A', 'E') as $col) {
                            $sheet->getColumnDimension($col)->setAutoSize(true);
                        }

                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                        $fileName = 'latest_facility_bookings_' . date('Y-m-d_His') . '.xlsx';

                        return response()->streamDownload(function () use ($writer) {
                            $writer->save('php://output');
                        }, $fileName, [
                            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]);
                    }),
            ])
            ->paginated(false);
    }
}
