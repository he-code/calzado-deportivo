<?php

use App\Models\Configuracion;
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
        $email_admin="jose.chanchicocha@gmail.com";
        $user=User::where('email',$email_admin)->first();
        if(!$user){
            $user= User::firstOrCreate([
                'name' => 'Admin',
                'email' => $email_admin,
                'password' => Hash::make($email_admin),
                'nombres'=>'Admin',
                'apellidos'=>'Admin',
                'identificacion'=>'000000000',
                'telefono'=>'000000000',
                'direccion'=>'SALCEDO',
            ]);
        }
        
      
        $email_cliente="consumidor_final@gmail.com";
        if(!User::where('email',$email_cliente)->first()){
            $consumidor= User::firstOrCreate([
                'name' => 'Consumidor Final',
                'email' => $email_cliente,
                'password' => Hash::make($email_cliente),
                'nombres'=>'Final',
                'apellidos'=>'Consumidor',
                'identificacion'=>'0000000000',
                'telefono'=>'0000000000',
                'direccion'=>'SALCEDO',
            ]);
        }
        


        $user->assignRole($role);

        $conf=Configuracion::first();
        if(!$conf){
            $conf=new Configuracion();
            $conf->iva=12;
            $conf->save();
        }
    }
}
