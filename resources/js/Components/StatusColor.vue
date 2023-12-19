<script setup>
import { computed } from 'vue';

const props = defineProps({
    texto: {
        type: String,
    },

});

const classes = computed(() =>{

    if(props.texto=="Asignado"){
        return "bg-yellow-300";
    }
    if(props.texto=="Cancelado"){
        return "bg-red-600";
    }
    if(props.texto=="Entregado"){
        return "bg-green-600";
    }

}
);

</script>
<template>
 <div :class="classes +  ' p-0 flex m-0 justify-center items-center text-xs text-white font-semibold h-5 rounded  mx-auto'">
    <slot />
 </div>
</template>
