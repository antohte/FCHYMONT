<script setup lang="ts">
import ClubLayout from '@/layouts/ClubLayout.vue';
defineProps<{ title?: string; description?: string }>();
</script>
<template>
    <ClubLayout active="auth" :title="title ?? 'Connexion'">
        <section class="club-auth">
            <header>
                <h1>{{ title }}</h1>
                <p>{{ description }}</p>
            </header>
            <slot />
        </section>
    </ClubLayout>
</template>
