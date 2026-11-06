<script setup lang="ts">
import ClubCallToAction from '@/components/club/ClubCallToAction.vue';
import SponsorBanner from '@/components/club/SponsorBanner.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { Sponsor } from '@/types/sponsor';
import { Head } from '@inertiajs/vue3';
defineProps<{ sponsors: Sponsor[] }>();
</script>

<template>
    <ClubLayout active="sponsors" title="Sponsors">
        <Head><meta name="description" content="Découvrez les partenaires du FC Hymont : Le Plan B, Snack51, Modern Sport et Someny." /></Head>
        <div class="club-container sponsors-page">
            <header class="sponsors-heading">
                <h1>Nos sponsors<span>.</span></h1>
                <p>Ils accompagnent le FC Hymont.</p>
            </header>
            <div class="sponsors-list"><SponsorBanner v-for="sponsor in sponsors" :key="sponsor.id" :sponsor="sponsor" /></div>
            <ClubCallToAction
                title="Devenez partenaire du FC Hymont"
                description="Soutenez le football local et bénéficiez d’une visibilité auprès de toute notre communauté. Contactez-nous pour construire ensemble un partenariat sur mesure."
                :href="route('contact')"
                action-label="Nous contacter"
            />
        </div>
    </ClubLayout>
</template>
