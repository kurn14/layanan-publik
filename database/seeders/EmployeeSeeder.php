<?php

namespace Database\Seeders;

use App\Enums\EmployeeRole;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Administrator Utama',
                'email' => 'admin@bpkp.go.id',
                'password' => Hash::make('password'),
                'role' => EmployeeRole::ADMIN,
                'phone' => '081234567890',
                'is_active' => true,
                'avatar_url' => null,
                'metadata' => [
                    'nip' => '198501152010011002',
                    'unit' => 'Bagian Tata Usaha & Pengelolaan Data',
                ],
            ],
            [
                'name' => 'Ahmad Fauzi, S.Kom.',
                'email' => 'operator@bpkp.go.id',
                'password' => Hash::make('password'),
                'role' => EmployeeRole::OPERATOR,
                'phone' => '081298765432',
                'is_active' => true,
                'avatar_url' => null,
                'metadata' => [
                    'nip' => '199203202015021004',
                    'unit' => 'Subbag Pelayanan Publik & Pelatihan',
                ],
            ],
            [
                'name' => 'Siti Rahmawati, S.E.',
                'email' => 'operator2@bpkp.go.id',
                'password' => Hash::make('password'),
                'role' => EmployeeRole::OPERATOR,
                'phone' => '081345678901',
                'is_active' => true,
                'avatar_url' => null,
                'metadata' => [
                    'nip' => '199407122019012003',
                    'unit' => 'Subbag Sarana & Prasarana',
                ],
            ],
            [
                'name' => 'Drs. Bambang Sudiro, Ak., M.M., CA., CFrA.',
                'email' => 'kepala@bpkp.go.id',
                'password' => Hash::make('password'),
                'role' => EmployeeRole::LEADER,
                'phone' => '081122334455',
                'is_active' => true,
                'avatar_url' => null,
                'metadata' => [
                    'nip' => '196805141993031001',
                    'position' => 'Kepala Perwakilan BPKP DIY',
                ],
            ],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['email' => $employee['email']],
                $employee
            );
        }
    }
}
