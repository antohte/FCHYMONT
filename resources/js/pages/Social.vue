<script setup lang="ts">
import ClubSocialCard from '@/components/club/ClubSocialCard.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{ networks: { network: string; name: string; account: string; href: string }[] }>();
</script>

<template>
    <ClubLayout active="social" title="Réseaux">
        <Head><meta name="description" content="Retrouvez le FC Hymont sur les réseaux sociaux." /></Head>
        <div class="club-container social-page">
            <header class="social-page__heading">
                <h1>Réseaux<span>.</span></h1>
                <p>Retrouvez le FC Hymont sur les réseaux sociaux.</p>
            </header>
            <div class="social-page__networks">
                <ClubSocialCard v-for="network in networks" :key="network.network" v-bind="network" />
            </div>
        </div>
    </ClubLayout>
</template>
