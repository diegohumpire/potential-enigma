<?php

use App\Supplier;
use App\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $supplier1 = factory(Supplier::class)->create();
        $product1_supplier1 = factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
        ]);
        $product2_supplier1 = factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
        ]);

        $supplier2 = factory(Supplier::class)->create();
        $product2_supplier2 = factory(Product::class)->create([
            'supplier_id' => $supplier2->id,
        ]);
        $product2_supplier2 = factory(Product::class)->create([
            'supplier_id' => $supplier2->id,
        ]);
    }
}
