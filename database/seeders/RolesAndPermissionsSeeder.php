<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{

    private $permissions, $user_permissions;

    public function __construct()
    {
        /*
        set the default permissions
        */
        $this->permissions =  [

            //Usuarios
            ['name' => 'lista-usuarios', 'description' => 'Ver Lista Usuarios'],
            ['name' => 'crear-usuarios', 'description' => 'Crear Usuarios'],
            ['name' => 'editar-usuarios', 'description' => 'Editar Usuarios'],
            ['name' => 'eliminar-usuarios', 'description' => 'Eliminar Usuarios'],

            //Clientes
            ['name' => 'lista-clientes', 'description' => 'Ver Lista Clientes'],
            ['name' => 'crear-clientes', 'description' => 'Crear Clientes'],
            ['name' => 'editar-clientes', 'description' => 'Editar Clientes'],
            ['name' => 'eliminar-clientes', 'description' => 'Eliminar Clientes'],

            //Productos
            ['name' => 'lista-productos', 'description' => 'Ver Lista Productos'],
            ['name' => 'crear-productos', 'description' => 'Crear Productos'],
            ['name' => 'editar-productos', 'description' => 'Editar Productos'],
            ['name' => 'eliminar-productos', 'description' => 'Eliminar Productos'],

            //Inventario
            ['name' => 'lista-inventarios', 'description' => 'Ver Inventario'],

            //Devoluciones
            ['name' => 'entradas', 'description' => 'Entrada'],
            ['name' => 'kardex', 'description' => 'Kardex'],
            ['name' => 'devoluciones', 'description' => 'Devoluciones'],

            //catalogos
            ['name' => 'catalogos', 'description' => 'Cátalogos'],

            //Categorias
            ['name' => 'lista-categorias', 'description' => 'Ver Lista Categorias'],
            ['name' => 'crear-categorias', 'description' => 'Crear Categorias'],
            ['name' => 'editar-categorias', 'description' => 'Editar Categorias'],
            ['name' => 'eliminar-categorias', 'description' => 'Eliminar Categorias'],

            //Ventas
            ['name' => 'lista-ventas', 'description' => 'Ver Lista Ventas'],
            ['name' => 'crear-ventas', 'description' => 'Crear Ventas'],
            ['name' => 'imprimir-ventas', 'description' => 'Imprimir Ticket Ventas'],
            ['name' => 'editar-ventas', 'description' => 'Editar Ventas'],
            ['name' => 'eliminar-ventas', 'description' => 'Eliminar Ventas'],

            //Cotizaciones
            ['name' => 'lista-cotizaciones', 'description' => 'Ver Lista Cotizaciones'],
            ['name' => 'crear-cotizaciones', 'description' => 'Crear Cotizaciones'],
            ['name' => 'editar-cotizaciones', 'description' => 'Editar Cotizaciones'],
            ['name' => 'eliminar-cotizaciones', 'description' => 'Eliminar Cotizaciones'],

            //Bandeja de pedido a domicilio
            ['name' => 'lista-pedidos', 'description' => 'Ver Lista Bandeja de pedido a domicilio'],
            ['name' => 'editar-pedidos', 'description' => 'Editar pedido a domicilio'],
            ['name' => 'asignar-ruta', 'description' => 'Asignar Ruta'],
            ['name' => 'asignar-repartidor', 'description' => 'Asignar Repartidor'],

            //Bitácora de envíos
            ['name' => 'lista-envios', 'description' => 'Ver Lista Bitácora de envíos'],
            ['name' => 'editar-envios', 'description' => 'Editar Bitácora de envíos'],

            //cortes
            ['name' => 'lista-cortes', 'description' => 'Corte'],

            //Abonos
            ['name' => 'lista-abonos', 'description' => 'Abonos'],
            ['name' => 'crear-abonos', 'description' => 'Agregar Abonos'],

            //report de ventas
            ['name' => 'reporte-ventas', 'description' => 'Reporte de ventas'],

            //Roles y permisos
            ['name' => 'ver-roles', 'description' => 'Ver Roles y permisos'],

            //grafico
            ['name' => 'cuadros', 'description' => 'Cuadros estadísticos'],
            ['name' => 'graf-ventas', 'description' => 'Gráfico de Ventas'],
            ['name' => 'graf-clientes', 'description' => 'Gráfico Clientes con más compras'],
            ['name' => 'graf-vendedores', 'description' => 'Gráfico Vendedores con más ventas'],
            ['name' => 'graf-vendidos', 'description' => 'Gráfico Productos más vendidos'],
            ['name' => 'graf-agregados', 'description' => 'Productos agregados recientemente'],


        ];
    }

    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        foreach ($this->permissions as $permission) {
            Permission::create($permission);
        }

        // create the admin role and set all default permissions
        $role = Role::create(['name' => 'Super Administrador']);

        foreach ($this->permissions as $value) {
            $role->givePermissionTo($value['name']);
        }

        $adm = Role::create(['name' => 'Administrador']);
        foreach ($this->permissions as $key=>$value) {
            $adm->givePermissionTo($this->permissions[$key]['name']);
        }

        $gen = Role::create(['name' => 'Gerente']);
        //$gen->givePermissionTo($this->permissions[0]['name']);

        $ven = Role::create(['name' => 'Ventas']);
        //$ven->givePermissionTo($this->permissions[0]['name']);

        $ped = Role::create(['name' => 'Administrador de pedidos']);
        //$ped->givePermissionTo($this->permissions[0]['name']);

        $inv = Role::create(['name' => 'Inventario']);
        //$inv->givePermissionTo($this->permissions[0]['name']);

        $rep = Role::create(['name' => 'Repartidor']);
        //$rep->givePermissionTo($this->permissions[0]['name']);

    }
}
