<script setup lang="ts">
import ClubLayout from '@/layouts/ClubLayout.vue';
defineProps<{ title: string; active: string }>();
</script>
<template>
    <ClubLayout :active="active" :title="title"
        ><h1 class="sr-only">{{ title }}</h1></ClubLayout
    >
</template>
