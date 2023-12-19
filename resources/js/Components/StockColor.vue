<script setup>
import { computed } from 'vue';

const props = defineProps({
    cantidad: {
        type: Number,
    },

});

const classes = computed(() =>{

    if(parseFloat(props.cantidad) <=10){
        return "bg-red-600";
    }
    if(parseFloat(props.cantidad) >10 &&parseFloat(props.cantidad) <=24){
        return "bg-yellow-400 text-black";
    }
    if(parseFloat(props.cantidad) >24){
        return "bg-green-600";
    }

}
);

</script>
<template>
 <div :class="classes +  ' p-0 flex m-0 justify-center items-center text-xs text-white font-normal w-9 h-9 rounded  mx-auto'">
    <slot />
 </div>
</template>
