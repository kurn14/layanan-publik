<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmployeeSeeder::class,
            CustomerSeeder::class,
            TrainingSeeder::class,
            FacilitySeeder::class,
            RegistrationSeeder::class,
            AttendanceSeeder::class,
            CertificateSeeder::class,
            FacilityBookingSeeder::class,
            InvoiceSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
