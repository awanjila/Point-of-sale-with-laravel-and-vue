<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'product_name' => 'Brake Pads',
                'category_id' => 1,
                'supplier_id' => 1,
                'product_image' => 'brake_pads.jpg',
                'product_store' => 'AutoStore1',
                'sales_count' => 10,
                'product_code' => 'BP12345',
                'buying_date' => Carbon::parse('2023-01-01'),
                'expire_date' => Carbon::parse('2025-01-01'),
                'buying_price' => 25.50,
                'selling_price' => 45.00,
            ],
            [
                'product_name' => 'Oil Filter',
                'category_id' => 2,
                'supplier_id' => 2,
                'product_image' => 'oil_filter.jpg',
                'product_store' => 'AutoStore2',
                'sales_count' => 15,
                'product_code' => 'OF67890',
                'buying_date' => Carbon::parse('2023-02-01'),
                'expire_date' => Carbon::parse('2025-02-01'),
                'buying_price' => 10.00,
                'selling_price' => 20.00,
            ],
            [
                'product_name' => 'Air Filter',
                'category_id' => 2,
                'supplier_id' => 1,
                'product_image' => 'air_filter.jpg',
                'product_store' => 'AutoStore1',
                'sales_count' => 20,
                'product_code' => 'AF54321',
                'buying_date' => Carbon::parse('2023-03-01'),
                'expire_date' => Carbon::parse('2025-03-01'),
                'buying_price' => 15.00,
                'selling_price' => 30.00,
            ],
            [
                'product_name' => 'Spark Plug',
                'category_id' => 3,
                'supplier_id' => 3,
                'product_image' => 'spark_plug.jpg',
                'product_store' => 'AutoStore3',
                'sales_count' => 50,
                'product_code' => 'SP98765',
                'buying_date' => Carbon::parse('2023-04-01'),
                'expire_date' => Carbon::parse('2025-04-01'),
                'buying_price' => 5.00,
                'selling_price' => 10.00,
            ],
            [
                'product_name' => 'Battery',
                'category_id' => 4,
                'supplier_id' => 4,
                'product_image' => 'battery.jpg',
                'product_store' => 'AutoStore4',
                'sales_count' => 30,
                'product_code' => 'BT11223',
                'buying_date' => Carbon::parse('2023-05-01'),
                'expire_date' => Carbon::parse('2025-05-01'),
                'buying_price' => 75.00,
                'selling_price' => 150.00,
            ],
            [
                'product_name' => 'Headlight',
                'category_id' => 5,
                'supplier_id' => 5,
                'product_image' => 'headlight.jpg',
                'product_store' => 'AutoStore5',
                'sales_count' => 25,
                'product_code' => 'HL22456',
                'buying_date' => Carbon::parse('2023-06-01'),
                'expire_date' => Carbon::parse('2025-06-01'),
                'buying_price' => 40.00,
                'selling_price' => 80.00,
            ],
            [
                'product_name' => 'Windshield Wiper',
                'category_id' => 6,
                'supplier_id' => 1,
                'product_image' => 'windshield_wiper.jpg',
                'product_store' => 'AutoStore1',
                'sales_count' => 60,
                'product_code' => 'WW33457',
                'buying_date' => Carbon::parse('2023-07-01'),
                'expire_date' => Carbon::parse('2025-07-01'),
                'buying_price' => 8.00,
                'selling_price' => 16.00,
            ],
            [
                'product_name' => 'Radiator',
                'category_id' => 7,
                'supplier_id' => 2,
                'product_image' => 'radiator.jpg',
                'product_store' => 'AutoStore2',
                'sales_count' => 5,
                'product_code' => 'RD44578',
                'buying_date' => Carbon::parse('2023-08-01'),
                'expire_date' => Carbon::parse('2025-08-01'),
                'buying_price' => 90.00,
                'selling_price' => 180.00,
            ],
            [
                'product_name' => 'Timing Belt',
                'category_id' => 8,
                'supplier_id' => 3,
                'product_image' => 'timing_belt.jpg',
                'product_store' => 'AutoStore3',
                'sales_count' => 12,
                'product_code' => 'TB55689',
                'buying_date' => Carbon::parse('2023-09-01'),
                'expire_date' => Carbon::parse('2025-09-01'),
                'buying_price' => 35.00,
                'selling_price' => 70.00,
            ],
            [
                'product_name' => 'Clutch Kit',
                'category_id' => 9,
                'supplier_id' => 4,
                'product_image' => 'clutch_kit.jpg',
                'product_store' => 'AutoStore4',
                'sales_count' => 18,
                'product_code' => 'CK66790',
                'buying_date' => Carbon::parse('2023-10-01'),
                'expire_date' => Carbon::parse('2025-10-01'),
                'buying_price' => 120.00,
                'selling_price' => 240.00,
            ],
            [
                'product_name' => 'Fuel Pump',
                'category_id' => 10,
                'supplier_id' => 5,
                'product_image' => 'fuel_pump.jpg',
                'product_store' => 'AutoStore5',
                'sales_count' => 9,
                'product_code' => 'FP77801',
                'buying_date' => Carbon::parse('2023-11-01'),
                'expire_date' => Carbon::parse('2025-11-01'),
                'buying_price' => 65.00,
                'selling_price' => 130.00,
            ],
            [
                'product_name' => 'Alternator',
                'category_id' => 11,
                'supplier_id' => 1,
                'product_image' => 'alternator.jpg',
                'product_store' => 'AutoStore1',
                'sales_count' => 14,
                'product_code' => 'AL88912',
                'buying_date' => Carbon::parse('2023-12-01'),
                'expire_date' => Carbon::parse('2025-12-01'),
                'buying_price' => 110.00,
                'selling_price' => 220.00,
            ],
            [
                'product_name' => 'Exhaust Muffler',
                'category_id' => 12,
                'supplier_id' => 2,
                'product_image' => 'exhaust_muffler.jpg',
                'product_store' => 'AutoStore2',
                'sales_count' => 7,
                'product_code' => 'EM99023',
                'buying_date' => Carbon::parse('2024-01-01'),
                'expire_date' => Carbon::parse('2026-01-01'),
                'buying_price' => 85.00,
                'selling_price' => 170.00,
            ],
            [
                'product_name' => 'Turbocharger',
                'category_id' => 13,
                'supplier_id' => 3,
                'product_image' => 'turbocharger.jpg',
                'product_store' => 'AutoStore3',
                'sales_count' => 4,
                'product_code' => 'TC10134',
                'buying_date' => Carbon::parse('2024-02-01'),
                'expire_date' => Carbon::parse('2026-02-01'),
                'buying_price' => 300.00,
                'selling_price' => 600.00,
            ],
            [
                'product_name' => 'Catalytic Converter',
                'category_id' => 14,
                'supplier_id' => 4,
                'product_image' => 'catalytic_converter.jpg',
                'product_store' => 'AutoStore4',
                'sales_count' => 3,
                'product_code' => 'CC11245',
                'buying_date' => Carbon::parse('2024-03-01'),
                'expire_date' => Carbon::parse('2026-03-01'),
                'buying_price' => 200.00,
                'selling_price' => 400.00,
            ],
            [
                'product_name' => 'Wheel Bearing',
                'category_id' => 15,
                'supplier_id' => 5,
                'product_image' => 'wheel_bearing.jpg',
                'product_store' => 'AutoStore5',
                'sales_count' => 22,
                'product_code' => 'WB12356',
                'buying_date' => Carbon::parse('2024-04-01'),
                'expire_date' => Carbon::parse('2026-04-01'),
                'buying_price' => 45.00,
                'selling_price' => 90.00,
            ],
            [
                'product_name' => 'Shock Absorber',
                'category_id' => 16,
                'supplier_id' => 1,
                'product_image' => 'shock_absorber.jpg',
                'product_store' => 'AutoStore1',
                'sales_count' => 8,
                'product_code' => 'SA13467',
                'buying_date' => Carbon::parse('2024-05-01'),
                'expire_date' => Carbon::parse('2026-05-01'),
                'buying_price' => 70.00,
                'selling_price' => 140.00,
            ],
            [
                'product_name' => 'Ignition Coil',
                'category_id' => 17,
                'supplier_id' => 2,
                'product_image' => 'ignition_coil.jpg',
                'product_store' => 'AutoStore2',
                'sales_count' => 11,
                'product_code' => 'IC14578',
                'buying_date' => Carbon::parse('2024-06-01'),
                'expire_date' => Carbon::parse('2026-06-01'),
                'buying_price' => 55.00,
                'selling_price' => 110.00,
            ],
            [
                'product_name' => 'Fuel Injector',
                'category_id' => 18,
                'supplier_id' => 3,
                'product_image' => 'fuel_injector.jpg',
                'product_store' => 'AutoStore3',
                'sales_count' => 6,
                'product_code' => 'FI15689',
                'buying_date' => Carbon::parse('2024-07-01'),
                'expire_date' => Carbon::parse('2026-07-01'),
                'buying_price' => 90.00,
                'selling_price' => 180.00,
            ],
            [
                'product_name' => 'Steering Rack',
                'category_id' => 19,
                'supplier_id' => 4,
                'product_image' => 'steering_rack.jpg',
                'product_store' => 'AutoStore4',
                'sales_count' => 13,
                'product_code' => 'SR16790',
                'buying_date' => Carbon::parse('2024-08-01'),
                'expire_date' => Carbon::parse('2026-08-01'),
                'buying_price' => 140.00,
                'selling_price' => 280.00,
            ],
            [
                'product_name' => 'Starter Motor',
                'category_id' => 20,
                'supplier_id' => 5,
                'product_image' => 'starter_motor.jpg',
                'product_store' => 'AutoStore5',
                'sales_count' => 10,
                'product_code' => 'SM17801',
                'buying_date' => Carbon::parse('2024-09-01'),
                'expire_date' => Carbon::parse('2026-09-01'),
                'buying_price' => 125.00,
                'selling_price' => 250.00,
            ],
        ];

        // Insert the products into the database
        DB::table('products')->insert($products);
    }
}
