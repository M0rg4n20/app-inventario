<script setup>
import CardDetail from '@/Components/CardDetail.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import { ref, onMounted, reactive } from 'vue';
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import { endOfMonth, endOfYear, startOfMonth, subDays, startOfYear } from 'date-fns';
import moment from 'moment';
import 'vue-datepicker-next/locale/es.es.js';
import VueApexCharts from "vue3-apexcharts";
const datos_vendidos = reactive([]);
const { total_productos } = usePage().props
const { total_categorias } = usePage().props
const { total_clientes } = usePage().props
const { total_ventas } = usePage().props
const { datos_grafico_ventas } = usePage().props
const { datos_grafico_vendidos } = usePage().props
const { ultimos_productos } = usePage().props
const { vendedores_mas_ventas } = usePage().props
const { clientes_mas_compras } = usePage().props

onMounted(() => {
    datos_vendidos.data = datos_grafico_vendidos;
})

//*datepicker  */
const shortcuts = [
    {
        text: 'Hoy',
        onClick() {
            const date = [new Date(), new Date()];
            return date;
        },
    },
    {
        text: 'Ayer',
        onClick() {
            const date = [subDays(new Date(), 1), subDays(new Date(), 1)];
            //date.setTime(date.getTime() - 3600 * 1000 * 24);

            return date;
        },
    },
    {
        text: 'Este mes',
        onClick() {
            const date = [startOfMonth(new Date()), endOfMonth(new Date())];

            return date;
        },
    },
    {
        text: 'Este año',
        onClick() {
            const date = [startOfYear(new Date()), endOfYear(new Date())];

            return date;
        },
    },
]

//const date = ref([ moment(new Date()).format('YYYY-MM-DD'), moment(new Date()).format('YYYY-MM-DD')]);
const date = ref([new Date(), new Date()]);

//filtrado
const filtrado = (value) => {
    router.get(
        "/",
        {
            inicio: moment(value[0]).format('YYYY-MM-DD'),
            fin: moment(value[1]).format('YYYY-MM-DD')
        },
        {
            preserveState: false,
        }
    );
}


//grafico total ventas
const totalVentasLinea = ref({
    chart: {
        type: "area",
        stacked: false,
        toolbar: {
            show: true,
            offsetX: 0,
            offsetY: 0,
            tools: {
                download: true,
                selection: false,
                zoom: false,
                zoomin: false,
                zoomout: false,
                pan: false,
                reset: false,
                customIcons: []
            },
            export: {
                csv: {
                    filename: "ventas",
                    columnDelimiter: ',',
                    headerCategory: 'anio',
                    headerValue: 'value',
                    dateFormatter(timestamp) {
                        return new Date(timestamp).toDateString()
                    }
                },
                svg: {
                    filename: "ventas",
                },
                png: {
                    filename: "ventas",
                }
            },
        },
    },
    dataLabels: {
        enabled: false,
        formatter: function (val) {
            return "$ " + val.toFixed(2)
        },
        offsetY: -6,
        style: {
            fontSize: '10px',
            colors: ["#304758"]
        }
    },
    markers: {
        size: 3,
        strokeWidth: 2
    },
    series: [

        {
            name: "Ventas",
            data: datos_grafico_ventas.datos
        }
    ],
    stroke: {
        width: [2, 2],
        curve: 'straight'

    },

    xaxis: {
        categories: datos_grafico_ventas.categoria
    },
    plotOptions: {
        bar: {
            horizontal: false
        }
    },
    yaxis: [
        {
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: true,
                //  color: "#0EA5E9"
            },

            labels: {
                formatter: function (val) {
                    return "$ " + val.toFixed(2)
                }
            },
            title: {
                text: "Ventas",
                style: {
                    //color: "#0EA5E9"
                }
            }
        }
    ],

    legend: {
        horizontalAlign: "left",
        offsetX: 20
    },

})

const totalVendidos = ref({

    series: datos_grafico_vendidos.datos,
    theme: {
        palette: 'palette1' // upto palette10
    },

    chart: {

        type: "donut",
        toolbar: {
            show: true,
            offsetX: -20,
            offsetY: -10,
            tools: {
                download: true,
                selection: false,
                zoom: false,
                zoomin: false,
                zoomout: false,
                pan: false,
                reset: false,
                customIcons: []
            },
            export: {
                csv: {
                    filename: "Productos vendidos",
                    columnDelimiter: ',',
                    headerCategory: 'productos',
                    headerValue: 'value',
                    dateFormatter(timestamp) {
                        return new Date(timestamp).toDateString()
                    }
                },
                svg: {
                    filename: "Productos vendidos",
                },
                png: {
                    filename: "Productos vendidos",
                }
            },
        },
    },

    labels: datos_grafico_vendidos.categoria,
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: "bottom"
                }
            }
        }
    ],

    plotOptions: {

        pie: {

            size: 400,
            donut: {
                size: '50%'
            }
        }
    }
})

//total ventas vendedores
const totalVentasVendedor = ref({

    series: [{
        name: 'Ventas',
        data: vendedores_mas_ventas.datos
    }],
    chart: {

        type: 'bar',
        height: 350,
    },
    toolbar: {
        show: true,
        offsetX: -20,
        offsetY: -10,

        export: {
            csv: {
                filename: "Vendedores",
                columnDelimiter: ',',
                headerCategory: 'Vendedores',
                headerValue: 'value',
                dateFormatter(timestamp) {
                    return new Date(timestamp).toDateString()
                }
            },
            svg: {
                filename: "Vendedores",
            },
            png: {
                filename: "Vendedores",
            }
        },
    },

    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            distributed: true,
            endingShape: 'rounded',
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return "$ " + val.toFixed(2)
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        labels: {
            rotate: -45
        },
        categories: vendedores_mas_ventas.categoria,

    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return "$ " + val
            }
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val.toFixed(2)
            }
        }

    },



})
//total ventas vendedores
const totalComprasCliente = ref({

    series: [{
        name: 'Compras',
        data: clientes_mas_compras.datos
    }],
    chart: {

        type: 'bar',
        height: 350,
    },
    toolbar: {
        show: true,
        offsetX: -20,
        offsetY: -10,

        export: {
            csv: {
                filename: "Clientes",
                columnDelimiter: ',',
                headerCategory: 'Clientes',
                headerValue: 'value',
                dateFormatter(timestamp) {
                    return new Date(timestamp).toDateString()
                }
            },
            svg: {
                filename: "Clientes",
            },
            png: {
                filename: "Clientes",
            }
        },
    },

    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            distributed: true,
            endingShape: 'rounded',
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return "$ " + val.toFixed(2)
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        labels: {
            rotate: -45
        },
        categories: clientes_mas_compras.categoria,

    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return "$ " + val
            }
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val.toFixed(2)
            }
        }

    },



})

onMounted(() => {

})

</script>

<template>
    <Head title="Panel" />

    <AuthenticatedLayout>
        <div class="ml-4 col-span-full">
                <Breadcrumb>
                    <BreadcrumbItem href="/" home>
                        Inicio
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        Reporte de ventas
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
        <div class="px-5 col-span-full flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">  Reporte de ventas</h1>
        </div>

        <div class="grid grid-cols-1 col-span-full gap-4 xl:grid-cols-12 xl:gap-4 mt-0 2xl:grid-cols-12">
            <div class="col-span-1 md:col-span-3  xl:col-span-3">
                <date-picker @change="filtrado" type="date" range value-type="YYYY-MM-DD" format="DD/MM/YYYY" v-model:value="date"
                    :shortcuts="shortcuts" lang="es" placeholder="seleccione Fecha"></date-picker>
            </div>
        </div>

        <!--graficos-->
        <div class="grid grid-cols-1  col-span-full gap-4 xl:grid-cols-12 xl:gap-4 mt-0 2xl:grid-cols-12">
            <!--total ventas-->
            <div
                class="col-span-1 md:col-span-12  xl:col-span-12 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Gráfico de Ventas
                </h3>
                <VueApexCharts height="350px" :options="totalVentasLinea" :series="totalVentasLinea.series"></VueApexCharts>
            </div>



            <!--Clientes con mas compras-->
            <div
                class="col-span-1 md:col-span-6  xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Clientes con más
                    compras</h3>
                <div class="border-t border-gray-200 dark:border-gray-600">
                    <VueApexCharts height="350px" :options="totalComprasCliente" :series="totalComprasCliente.series">
                    </VueApexCharts>
                </div>
            </div>
            <!--Vendedores con mas ventas-->
            <div
                class="col-span-1 md:col-span-6  xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Vendedores con más
                    ventas</h3>
                <div class="border-t border-gray-200 dark:border-gray-600">
                    <VueApexCharts height="350px" :options="totalVentasVendedor" :series="totalVentasVendedor.series">
                    </VueApexCharts>
                </div>
            </div>
            <!--total vendedidos-->
            <div
                class="col-span-1 md:col-span-6  xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Productos más
                    vendidos</h3>
                <VueApexCharts height="350px" :options="totalVendidos" :series="totalVendidos.series"></VueApexCharts>

                <div class="border-t border-gray-200 dark:border-gray-600">
                    <div class="pt-2" id="faq" role="tabpanel" aria-labelledby="faq-tab">

                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">

                            <li v-for="item, index in datos_grafico_vendidos.tabla" class="py-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0">
                                        <img class="flex-shrink-0 w-8 h-8" :src="item.imagen" alt="image">
                                        <div class="ml-3">
                                            <p class="font-normal  text-sm text-gray-900 truncate dark:text-white">
                                                {{ item.nombre }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center  text-sm font-normal text-gray-900 dark:text-white">
                                        {{ item.porcentaje }}
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>

        </div>
        <!--/graficos-->
    </AuthenticatedLayout>
</template>
<style type="text/css"></style>
