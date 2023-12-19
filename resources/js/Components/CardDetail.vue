<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: false,
        default:"#"
    },
    active: {
        type: Boolean,
    },
    iconClass: {
        type: String
    },
    titulo: {
        type: String,
        default:"Titulo"
    },
    cantidad: {
        type: Number,
        default:null
    }
});


const icon = computed(() =>
    props.iconClass
        ? props.iconClass + ' text-gray-400/20 dark:text-gray-300/10'
        : props.iconClass + ' fas fa-dollar-sign fa-6x text-gray-400/20 dark:text-gray-300/10'
);
</script>
<template>
    <div class="relative flex p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="ml-1 p-1 z-20">
          <h3 class="text-xl font-bold text-gray-500 dark:text-gray-400">{{ titulo }}</h3>
              <p class="text-2xl font-bold leading-none text-gray-900 sm:text-4xl dark:text-white">{{ cantidad }}</p>
                <Link :href="href" class="mr-1.5  mt-3 text-sm font-bold text-green-500 dark:text-green-400">
                Más info
            </Link>
        </div>
        <div class="absolute z-0 top-1/2 right-5 transform  -translate-y-1/2">
            <i :class="icon"></i>
        </div>

      </div>
</template>
