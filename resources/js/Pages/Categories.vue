<script setup>

const props = defineProps({
    categories: Array
});

console.log(props.categories);
</script>
<template>
    <div class="ml-4 mt-6 flex  text-white max-w-full overflow-x-scroll">
        <div class="w-24 h-24 text-center shrink-0" v-for="category in props.categories">
            <img class='rounded-full w-20 h-20 mx-auto' :src="category.image">
            <p class="text-xs">{{ category.nom }}</p>
        </div>
    </div>
</template>
