<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;


class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::insert([
            [
                'name' => 'Spaza Shop 1',
                'location' => 'Cape Town',
                'owner_name' => 'John Doe',
                'contact_number' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spaza Shop 2',
                'location' => 'Johannesburg',
                'owner_name' => 'Jane Smith',
                'contact_number' => '0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spaza Shop 3',
                'location' => 'Durban',
                'owner_name' => 'David Johnson',
                'contact_number' => '1122334455',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spaza Shop 4',
                'location' => 'Pretoria',
                'owner_name' => 'Sarah Adams',
                'contact_number' => '5566778899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
