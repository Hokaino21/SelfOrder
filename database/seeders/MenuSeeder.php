<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            // Makanan Berat
            ['name' => 'Nasi Goreng Spesial', 'category' => 'Makanan Berat', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran', 'price' => 45000, 'is_available' => true],
            ['name' => 'Mie Goreng', 'category' => 'Makanan Berat', 'description' => 'Mie goreng dengan cabai dan kerupuk', 'price' => 35000, 'is_available' => true],
            ['name' => 'Nasi Kuning', 'category' => 'Makanan Berat', 'description' => 'Nasi kuning dengan aroma kunyit dan kelapa', 'price' => 40000, 'is_available' => true],
            ['name' => 'Ayam Bakar', 'category' => 'Makanan Berat', 'description' => 'Ayam bakar dengan bumbu khas', 'price' => 55000, 'is_available' => true],
            ['name' => 'Ikan Goreng', 'category' => 'Makanan Berat', 'description' => 'Ikan goreng renyah dengan nasi dan sambal', 'price' => 50000, 'is_available' => true],
            
            // Makanan Ringan
            ['name' => 'Lumpia', 'category' => 'Makanan Ringan', 'description' => 'Lumpia goreng isi daging dan sayuran', 'price' => 20000, 'is_available' => true],
            ['name' => 'Perkedel', 'category' => 'Makanan Ringan', 'description' => 'Perkedel kentang goreng', 'price' => 15000, 'is_available' => true],
            ['name' => 'Tahu Goreng', 'category' => 'Makanan Ringan', 'description' => 'Tahu goreng dengan saus cabai', 'price' => 18000, 'is_available' => true],
            ['name' => 'Bakso Goreng', 'category' => 'Makanan Ringan', 'description' => 'Bakso goreng dengan bumbu spesial', 'price' => 25000, 'is_available' => true],
            
            // Minuman
            ['name' => 'Es Jeruk', 'category' => 'Minuman', 'description' => 'Es jeruk segar dengan gula batu', 'price' => 12000, 'is_available' => true],
            ['name' => 'Es Teh Manis', 'category' => 'Minuman', 'description' => 'Es teh dengan pemanis alami', 'price' => 10000, 'is_available' => true],
            ['name' => 'Es Cendol', 'category' => 'Minuman', 'description' => 'Es cendol dengan santan dan gula merah', 'price' => 15000, 'is_available' => true],
            ['name' => 'Kopi Hitam', 'category' => 'Minuman', 'description' => 'Kopi hitam panas atau dingin', 'price' => 18000, 'is_available' => true],
            ['name' => 'Susu Coklat', 'category' => 'Minuman', 'description' => 'Susu coklat panas atau dingin', 'price' => 20000, 'is_available' => true],
            
            // Dessert
            ['name' => 'Pisang Goreng', 'category' => 'Dessert', 'description' => 'Pisang goreng dengan saus coklat', 'price' => 22000, 'is_available' => true],
            ['name' => 'Es Krim', 'category' => 'Dessert', 'description' => 'Es krim vanilla atau coklat', 'price' => 18000, 'is_available' => true],
            ['name' => 'Puding Coklat', 'category' => 'Dessert', 'description' => 'Puding coklat dengan whipped cream', 'price' => 20000, 'is_available' => true],
        ];

        foreach ($menuItems as $item) {
            \App\Models\MenuItem::create($item);
        }
    }
}
