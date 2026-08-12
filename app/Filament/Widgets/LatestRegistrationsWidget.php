<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrationsWidget extends BaseWidget
{
    protected static ?string $heading = '10 Pendaftar Pelatihan Terakhir';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Registration::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('registration_code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Peserta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('training.name')
                    ->label('Pelatihan'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('export_excel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $records = \App\Models\Registration::query()->latest()->limit(10)->get();
                        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();

                        $sheet->setCellValue('A1', 'Kode Registrasi');
                        $sheet->setCellValue('B1', 'Peserta');
                        $sheet->setCellValue('C1', 'Pelatihan');
                        $sheet->setCellValue('D1', 'Status');
                        $sheet->setCellValue('E1', 'Kelulusan');
                        $sheet->setCellValue('F1', 'Tanggal Daftar');

                        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

                        $row = 2;
                        foreach ($records as $record) {
                            $sheet->setCellValue('A' . $row, $record->registration_code);
                            $sheet->setCellValue('B' . $row, $record->customer->name ?? '-');
                            $sheet->setCellValue('C' . $row, $record->training->name ?? '-');
                            $sheet->setCellValue('D' . $row, $record->status->label());
                            $sheet->setCellValue('E' . $row, $record->graduation_status->label());
                            $sheet->setCellValue('F' . $row, $record->created_at->format('Y-m-d H:i'));
                            $row++;
                        }

                        foreach (range('A', 'F') as $col) {
                            $sheet->getColumnDimension($col)->setAutoSize(true);
                        }

                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                        $fileName = 'latest_registrations_' . date('Y-m-d_His') . '.xlsx';

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
