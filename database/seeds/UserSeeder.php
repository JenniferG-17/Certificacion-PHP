<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->nombre = 'jenni';
        $user->tipo_documento = '1';
        $user->num_documento = '2';
        $user->telefono = '253';
        $user->email = 'jenni@gmail.com';
        $user->direccion = 'olopa';
        $user->usuario = 'jenni';
        $user->password = bcrypt('12345');
        $user->condicion = '1';
        $user->idrol = '1';
        $user->save();

    }
}
