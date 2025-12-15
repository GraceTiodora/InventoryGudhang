<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code' => 'INV001',
                'name' => 'Laptop HP',
                'category' => 'Elektronik',
                'quantity' => 15,
                'unit' => 'pcs',
                'price' => 8500000,
                'supplier' => 'PT. Computerland',
                'description' => 'Laptop HP dengan spesifikasi standar',
            ],
            [
                'code' => 'INV002',
                'name' => 'Mouse Logitech',
                'category' => 'Aksesori',
                'quantity' => 50,
                'unit' => 'pcs',
                'price' => 150000,
                'supplier' => 'PT. Tech Store',
                'description' => 'Mouse wireless Logitech MX Master',
            ],
            [
                'code' => 'INV003',
                'name' => 'Keyboard Mekanik',
                'category' => 'Aksesori',
                'quantity' => 30,
                'unit' => 'pcs',
                'price' => 750000,
                'supplier' => 'PT. Gaming Gear',
                'description' => 'Keyboard mekanik RGB untuk gaming',
            ],
            [
                'code' => 'INV004',
                'name' => 'Monitor LED 24 inch',
                'category' => 'Elektronik',
                'quantity' => 8,
                'unit' => 'pcs',
                'price' => 2500000,
                'supplier' => 'PT. Display Tech',
                'description' => 'Monitor LED Full HD 24 inch',
            ],
            [
                'code' => 'INV005',
                'name' => 'Webcam HD',
                'category' => 'Aksesori',
                'quantity' => 5,
                'unit' => 'pcs',
                'price' => 450000,
                'supplier' => 'PT. Camera Pro',
                'description' => 'Webcam HD 1080p dengan auto focus',
            ],
            [
                'code' => 'INV006',
                'name' => 'Headphone Noise Cancelling',
                'category' => 'Aksesori',
                'quantity' => 0,
                'unit' => 'pcs',
                'price' => 3500000,
                'supplier' => 'PT. Audio Premium',
                'description' => 'Headphone dengan noise cancelling aktif',
            ],
            [
                'code' => 'INV007',
                'name' => 'USB Hub Type C',
                'category' => 'Aksesori',
                'quantity' => 25,
                'unit' => 'pcs',
                'price' => 250000,
                'supplier' => 'PT. USB Tech',
                'description' => 'USB Hub Type C dengan 7 port',
            ],
            [
                'code' => 'INV008',
                'name' => 'Cooling Pad Laptop',
                'category' => 'Aksesori',
                'quantity' => 12,
                'unit' => 'pcs',
                'price' => 350000,
                'supplier' => 'PT. Cooling Solution',
                'description' => 'Cooling pad dengan 4 fan untuk laptop',
            ],
            [
                'code' => 'INV009',
                'name' => 'SSD 512GB',
                'category' => 'Hardware',
                'quantity' => 20,
                'unit' => 'pcs',
                'price' => 650000,
                'supplier' => 'PT. Storage Comp',
                'description' => 'SSD 512GB NVMe M.2',
            ],
            [
                'code' => 'INV010',
                'name' => 'RAM DDR4 8GB',
                'category' => 'Hardware',
                'quantity' => 35,
                'unit' => 'pcs',
                'price' => 400000,
                'supplier' => 'PT. Memory Tech',
                'description' => 'RAM DDR4 8GB 3200MHz',
            ],
        ];

        foreach ($data as $item) {
            Inventory::create($item);
        }
    }
}
