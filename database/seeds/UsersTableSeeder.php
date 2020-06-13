<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // permisos
        Permission::firstOrCreate(['name' => 'G. Usuarios']);
        Permission::firstOrCreate(['name' => 'G. Almacén']);
        Permission::firstOrCreate(['name' => 'G. Ventas']);

        // roles
        $role = Role::firstOrCreate(['name' => 'Administrador']);
        Role::firstOrCreate(['name' => 'Cliente']);
        Role::firstOrCreate(['name' => 'Vendedor']);
        $role->givePermissionTo(Permission::all());

        $user=User::where('email','admin@factur.com')->first();
        if(!$user){
            $user= User::firstOrCreate([
                'name' => 'Admin',
                'email' => 'admin@factur.com',
                'password' => Hash::make('@dmin_factur'),
                'nombres'=>'Admin',
                'apellidos'=>'Admin',
                'identificacion'=>'000000000',
                'telefono'=>'000000000',
                'direccion'=>'N/A',
            ]);
        }
        
      

        if(!User::where('email','consumidor_final@gmail.com')->first()){
            $consumidor= User::firstOrCreate([
                'name' => 'Consumidor Final',
                'email' => 'consumidor_final@gmail.com',
                'password' => Hash::make('consumidor_final@_2020'),
                'nombres'=>'Final',
                'apellidos'=>'Consumidor',
                'identificacion'=>'0000000000',
                'telefono'=>'0000000000',
                'direccion'=>'N/A',
            ]);
        }
        


        $user->assignRole($role);
    }
}
