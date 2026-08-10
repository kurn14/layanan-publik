<?php
$files = [
    'database/seeders/EmployeeSeeder.php',
    'database/seeders/CustomerSeeder.php',
    'database/seeders/RegistrationSeeder.php',
    'database/seeders/CertificateSeeder.php',
    'database/seeders/FacilityBookingSeeder.php',
    'database/seeders/InvoiceSeeder.php',
    'database/seeders/PaymentSeeder.php',
];
foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        $c = preg_replace("/\s*'metadata'\s*=>\s*\[.*?\],/s", "", $c);
        file_put_contents($f, $c);
    }
}
echo "Done\n";
