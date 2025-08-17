<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Samsung Electronics',
                'contact_person' => 'Marie Dubois',
                'email' => 'marie.dubois@samsung.fr',
                'phone' => '+33 1 23 45 67 89',
                'address' => '123 Rue de la Technologie, 75001 Paris'
            ],
            [
                'name' => 'Apple France',
                'contact_person' => 'Jean Martin',
                'email' => 'jean.martin@apple.fr',
                'phone' => '+33 1 34 56 78 90',
                'address' => '456 Avenue des Innovations, 75008 Paris'
            ],
            [
                'name' => 'Dell Technologies',
                'contact_person' => 'Sophie Leclerc',
                'email' => 'sophie.leclerc@dell.fr',
                'phone' => '+33 1 45 67 89 01',
                'address' => '789 Boulevard du Numérique, 92100 Boulogne'
            ],
            [
                'name' => 'Sony France',
                'contact_person' => 'Pierre Moreau',
                'email' => 'pierre.moreau@sony.fr',
                'phone' => '+33 1 56 78 90 12',
                'address' => '321 Rue de l\'Audio, 75015 Paris'
            ],
            [
                'name' => 'Logitech Europe',
                'contact_person' => 'Lucie Bernard',
                'email' => 'lucie.bernard@logitech.com',
                'phone' => '+33 1 67 89 01 23',
                'address' => '654 Place des Périphériques, 69000 Lyon'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        $this->command->info('Fournisseurs créés avec succès !');
    }
}
