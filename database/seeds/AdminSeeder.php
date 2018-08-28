<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
            'name' => 'VENDE MAIS FÁCIL',
            'trade_name' => 'VENDE MAIS FÁCIL',
            'cnpj' => '12312312312312',
            'ie' => '12312311',
            'cep' => '38030210',
            'address' => 'RUA COBALTO',
            'number' => '35',
            'district' => 'LEBLON',
            'city' => 'UBERABA',
            'state' => 'MG',
            'phone' => '3433445566',
            'mobile_phone' => '34999887766',
            'interest' => 0
        ]);
        DB::table('users')->insert([
            'name' => 'Administrador',
            'cpf' => '12312312311',
            'rg' => '12312311',
            'role' => 'ADMINISTRADOR',
            'store_id' => 1,
            'cep' => '38030210',
            'address' => 'RUA COBALTO',
            'number' => '35',
            'district' => 'LEBLON',
            'city' => 'UBERABA',
            'state' => 'MG',
            'phone' => '3433445566',
            'mobile_phone' => '34999887766',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'Gerente',
            'cpf' => '11122233300',
            'rg' => '12312311',
            'role' => 'GERENTE',
            'store_id' => 1,
            'cep' => '38030210',
            'address' => 'RUA COBALTO',
            'number' => '35',
            'district' => 'LEBLON',
            'city' => 'UBERABA',
            'state' => 'MG',
            'phone' => '3433445566',
            'mobile_phone' => '34999887766',
            'email' => 'gerente@gerente.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'Proprietário',
            'cpf' => '11111111111',
            'rg' => '12312311',
            'role' => 'PROPRIETÁRIO',
            'store_id' => 1,
            'cep' => '38030210',
            'address' => 'RUA COBALTO',
            'number' => '35',
            'district' => 'LEBLON',
            'city' => 'UBERABA',
            'state' => 'MG',
            'phone' => '3433445566',
            'mobile_phone' => '34999887766',
            'email' => 'proprietario@proprietario.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'Vendedor',
            'cpf' => '22222222222',
            'rg' => '12312311',
            'role' => 'VENDEDOR',
            'store_id' => 1,
            'cep' => '38030210',
            'address' => 'RUA COBALTO',
            'number' => '35',
            'district' => 'LEBLON',
            'city' => 'UBERABA',
            'state' => 'MG',
            'phone' => '3433445566',
            'mobile_phone' => '34999887766',
            'email' => 'vendedor@vendedor.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
