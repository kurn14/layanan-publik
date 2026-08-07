<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $reg5 = Registration::where('registration_code', 'REG-202607-0005')->first();
        $reg6 = Registration::where('registration_code', 'REG-202607-0006')->first();

        if ($reg5) {
            $startDate = Carbon::parse('2026-07-20');
            for ($i = 0; $i < 5; $i++) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                Attendance::updateOrCreate(
                    [
                        'registration_id' => $reg5->id,
                        'date' => $date,
                    ],
                    [
                        'status' => AttendanceStatus::PRESENT,
                        'check_in_time' => sprintf('07:%02d:00', rand(40, 58)),
                        'check_out_time' => sprintf('16:%02d:00', rand(30, 45)),
                        'remarks' => 'Hadir tepat waktu di Lab Komputer.',
                    ]
                );
            }
        }

        if ($reg6) {
            $startDate = Carbon::parse('2026-07-20');
            for ($i = 0; $i < 5; $i++) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                $isPermitted = ($i === 2); // izin di hari ke-3
                Attendance::updateOrCreate(
                    [
                        'registration_id' => $reg6->id,
                        'date' => $date,
                    ],
                    [
                        'status' => $isPermitted ? AttendanceStatus::PERMITTED : AttendanceStatus::PRESENT,
                        'check_in_time' => $isPermitted ? null : sprintf('07:%02d:00', rand(45, 59)),
                        'check_out_time' => $isPermitted ? null : sprintf('16:%02d:00', rand(30, 40)),
                        'remarks' => $isPermitted ? 'Izin menghadiri rapat pimpinan dinas mendesak.' : 'Hadir penuh.',
                    ]
                );
            }
        }
    }
}
