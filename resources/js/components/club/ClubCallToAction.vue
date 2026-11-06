<script setup lang="ts">
import ClubAction from '@/components/club/ClubAction.vue';

defineProps<{ title: string; description: string; href: string; actionLabel: string }>();
</script>

<template>
    <section class="club-call-to-action">
        <div class="club-call-to-action__copy">
            <h2>{{ title }}</h2>
            <p>{{ description }}</p>
        </div>
        <ClubAction :href="href">{{ actionLabel }}</ClubAction>
    </section>
</template>
