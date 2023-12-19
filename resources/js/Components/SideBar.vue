<script>
import { onMounted, computed, watch } from "vue";
import NavLinkSideBar from '@/Components/NavLinkSideBar.vue';
import { usePage } from '@inertiajs/vue3';
import { useConfigStore } from '@/store/config.js'

export default {
    components: {
        NavLinkSideBar,
    },
    props: {
        isOpen: {
            type: Boolean,
            default: true,

        },

    },
    setup(props) {

        const { permissions } = usePage().props.auth
        const configStore = useConfigStore();
        const classes = computed(() => props.isOpen ? 'sm:translate-x-0' : 'sm:hidden sm:translate-x-0');
        const setMenu = (menu) => {
            configStore.showMenu(menu);
        }

        onMounted(() => {

        });

        watch(
            () => props.isOpen,
            () => {

                if (props.isOpen) {
                } else {
                }
            }
        );

        return {
            classes,
            configStore,
            setMenu,
            permissions
        }
    }
}


</script>

<template>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-56 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-1 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-1 font-normal">
                <li @click="setMenu('inicio')">

                    <NavLinkSideBar icon-class="fas fa-home"
                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('inicio')" :active="route().current('inicio')">
                        <span class="ml-3" sidebar-toggle-item>Inicio</span>

                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('usuario')" v-show="permissions.includes('lista-usuarios')">
                    <NavLinkSideBar icon-class="fas fa-user-friends"
                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('usuarios.index')" :active="route().current('usuarios.index')">
                        <span class="ml-3" sidebar-toggle-item>Usuarios</span>
                    </NavLinkSideBar>
                </li>
                <div class="pt-0 space-y-1 font-normal" v-show="permissions.includes('lista-inventarios')">
                    <ul>
                        <li>
                            <button type="button"
                                class="flex items-center w-full px-2 py-1.5 text-gray-900 transition duration-75 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                                aria-controls="inventario" data-collapse-toggle="inventario">
                                <i class="fas fa-boxes text-gray-500 group-hover:text-gray-900"></i>
                                <span class="flex-1 ml-3 text-sm text-left whitespace-nowrap"
                                    sidebar-toggle-item>Inventario</span>
                                <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul id="inventario" class=" py-2 space-y-1"
                                :class="configStore.getCurrentMenu == 'inventario' ? '' : 'hidden'">

                                <li v-show="permissions.includes('lista-productos')">
                                    <NavLinkSideBar @click="setMenu('inventario')"
                                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                        :href="route('productos.index')" :active="route().current('productos.index')">
                                        <span class="ml-3" sidebar-toggle-item>Productos</span>
                                    </NavLinkSideBar>
                                </li>
                                <li v-show="permissions.includes('entradas')">
                                    <NavLinkSideBar @click="setMenu('inventario')"
                                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                        :href="route('kardex.entrada')" :active="route().current('kardex.entrada')">
                                        <span class="ml-3" sidebar-toggle-item>Entrada</span>
                                    </NavLinkSideBar>
                                </li>
                                <li v-show="permissions.includes('kardex')">
                                    <NavLinkSideBar @click="setMenu('inventario')"
                                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                        :href="route('kardex.index')" :active="route().current('kardex.index')">
                                        <span class="ml-3" sidebar-toggle-item>Kardex</span>
                                    </NavLinkSideBar>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>
                <li @click="setMenu('devoluciones')" v-show="permissions.includes('devoluciones')">
                    <NavLinkSideBar icon-class="fas fa-box"
                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('kardex.devolucion')" :active="route().current('kardex.devolucion')">
                        <span class="ml-3" sidebar-toggle-item>Devoluciones </span>
                    </NavLinkSideBar>
                </li>

                <li @click="setMenu('clientes')" v-show="permissions.includes('lista-clientes')">
                    <NavLinkSideBar icon-class="fas fa-users"
                        class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('clientes.index')" :active="route().current('clientes.index')">
                        <span class="ml-3" sidebar-toggle-item>Clientes</span>
                    </NavLinkSideBar>
                </li>

            </ul>

            <div class="pt-0 space-y-1 font-normal" v-show="permissions.includes('lista-cotizaciones')">
                <ul>

                    <li>
                        <button type="button"
                            class="flex items-center w-full px-2 py-1.5 text-gray-900 transition duration-75 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="cotizaciones" data-collapse-toggle="cotizaciones">
                            <i class="fas fa-clipboard-list text-gray-500 group-hover:text-gray-900"></i>
                            <span class="flex-1 ml-3 text-sm text-left whitespace-nowrap"
                                sidebar-toggle-item>Cotizaciones</span>
                            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="cotizaciones" class=" py-2 space-y-1"
                            :class="configStore.getCurrentMenu == 'cotizaciones' ? '' : 'hidden'">

                            <li>
                                <NavLinkSideBar @click="setMenu('cotizaciones')"
                                    class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('cotizaciones.index')" :active="route().current('cotizaciones.index')">
                                    <span class="ml-3" sidebar-toggle-item>Administrar</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('cotizaciones')"
                                    class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('cotizaciones.create')" :active="route().current('cotizaciones.create')">
                                    <span class="ml-3" sidebar-toggle-item>Crear Cotización</span>
                                </NavLinkSideBar>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

            <div class="pt-0 space-y-1 font-normal" v-show="permissions.includes('lista-ventas')">
                <ul>
                    <li>
                        <button type="button"
                            class="flex items-center w-full px-2 py-1.5 text-gray-900 transition duration-75 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="ventas" data-collapse-toggle="ventas">
                            <i class="fa-solid fa-cash-register text-gray-500 group-hover:text-gray-900"></i>
                            <span class="flex-1 ml-3 text-sm text-left whitespace-nowrap" sidebar-toggle-item>Ventas</span>
                            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="ventas" class=" py-2 space-y-1"
                            :class="configStore.getCurrentMenu == 'ventas' ? '' : 'hidden'">

                            <li>
                                <NavLinkSideBar @click="setMenu('ventas')"
                                    class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('ventas.index')" :active="route().current('ventas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Administrar</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('ventas')"
                                    class="flex items-center px-2 py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('ventas.create')" :active="route().current('ventas.create')">
                                    <span class="ml-3" sidebar-toggle-item>Crear venta</span>
                                </NavLinkSideBar>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

            <ul class="space-y-1 font-normal">
                <li @click="setMenu('pedidos')" v-show="permissions.includes('lista-pedidos')">
                    <NavLinkSideBar icon-class="fa-solid fa-truck-fast"
                        class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('pedidos.index')" :active="route().current('pedidos.index')">
                        <span class="ml-3" sidebar-toggle-item>Bandeja de pedido a domicilio</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('envios')" v-show="permissions.includes('lista-envios')">
                    <NavLinkSideBar icon-class="fa-solid fa-boxes-packing"
                        class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('envios.index')" :active="route().current('envios.index')">
                        <span class="ml-3" sidebar-toggle-item>Bitácora de envíos</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('envios')" v-show="permissions.includes('lista-envios')">
                    <NavLinkSideBar icon-class="fab fa-cc-mastercard"
                        class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('retiros.index')" :active="route().current('retiros.index')">
                        <span class="ml-3" sidebar-toggle-item>Solicitudes de retiro</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('cortecaja')" v-show="permissions.includes('lista-cortes')">
                    <NavLinkSideBar icon-class="fa-solid fa-cash-register"
                        class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('cortecaja.index')" :active="route().current('cortecaja.index')">
                        <span class="ml-3" sidebar-toggle-item>Corte</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('abonos')" v-show="permissions.includes('lista-abonos')">
                    <NavLinkSideBar icon-class="fa-solid fa-file-circle-plus"
                        class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('abonos.index')" :active="route().current('abonos.index')">
                        <span class="ml-3" sidebar-toggle-item>Abonos</span>
                    </NavLinkSideBar>
                </li>
            </ul>
            <div class="pt-1 space-y-1 font-normal" v-show="permissions.includes('catalogos')">
                <ul>

                    <li>
                        <button type="button"
                            class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="productos" data-collapse-toggle="productos">
                            <i class="fas fa-money-check text-gray-500 group-hover:text-gray-900"></i>
                            <span class="flex-1 ml-3 text-sm text-left whitespace-nowrap"
                                sidebar-toggle-item>Catálogos</span>
                            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="productos" class=" py-2 space-y-2"
                            :class="configStore.getCurrentMenu == 'productos' ? '' : 'hidden'">
                            <!--
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('categorias.index')" :active="route().current('categorias.index')">
                                    <span class="ml-3" sidebar-toggle-item>Categorias</span>
                                </NavLinkSideBar>
                            </li>
                            -->
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('familias.index')" :active="route().current('familias.index')">
                                    <span class="ml-3" sidebar-toggle-item>Familias</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('subproductos.index')" :active="route().current('subproductos.index')">
                                    <span class="ml-3" sidebar-toggle-item>Sub Producto</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('marcas.index')" :active="route().current('marcas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Marcas</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('pesos.index')" :active="route().current('pesos.index')">
                                    <span class="ml-3" sidebar-toggle-item>Pesos</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('longitudes.index')" :active="route().current('longitudes.index')">
                                    <span class="ml-3" sidebar-toggle-item>Longitudes</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('curvas.index')" :active="route().current('curvas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Curvas</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('colores.index')" :active="route().current('colores.index')">
                                    <span class="ml-3" sidebar-toggle-item>Colores</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('diferenciadores.index')"
                                    :active="route().current('diferenciadores.index')">
                                    <span class="ml-3" sidebar-toggle-item>Diferenciadores</span>
                                </NavLinkSideBar>
                            </li>


                        </ul>
                    </li>
                </ul>
            </div>

            <ul class="p-1 space-y-1 font-normal">

                <li @click="setMenu('reportes')" v-show="permissions.includes('reporte-ventas')">
                    <NavLinkSideBar icon-class="fas fa-chart-pie"
                        class="flex items-center py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('reportes.index')" :active="route().current('reportes.index')">
                        <span class="ml-3" sidebar-toggle-item> Reporte de ventas</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('roles')" v-show="permissions.includes('ver-roles')">
                    <NavLinkSideBar icon-class="fas fa-user-tag"
                        class="flex items-center py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('roles.index')" :active="route().current('roles.index')">
                        <span class="ml-3" sidebar-toggle-item>Roles y Permisos</span>
                    </NavLinkSideBar>
                </li>
                <li>
                    <NavLinkSideBar icon-class="fas fa-sign-out-alt"
                        class="flex items-center py-1.5 text-sm text-gray-900 rounded hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('logout')" method="post">
                        <span class="ml-3" sidebar-toggle-item>Cerrar sesión</span>
                    </NavLinkSideBar>
                </li>

            </ul>

        </div>
    </aside>
</template>
