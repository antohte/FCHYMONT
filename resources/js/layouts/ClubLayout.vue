<script setup lang="ts">
import ClubBrand from '@/components/club/ClubBrand.vue';
import ClubHeader from '@/components/club/ClubHeader.vue';
import { Head, Link } from '@inertiajs/vue3';
defineProps<{ active: string; title: string }>();
</script>
<template>
    <Head :title="title"><link rel="icon" type="image/png" href="/images/club-logo.png" /></Head>
    <div class="club-theme">
        <a href="#contenu" class="club-skip-link">Aller au contenu</a>
        <ClubHeader :active="active" />
        <main id="contenu" tabindex="-1" class="club-main"><slot /></main>
        <footer class="club-footer">
            <div class="club-container club-footer__row">
                <Link :href="route('home')" aria-label="FC Hymont, accueil"><ClubBrand compact /></Link>
                <span class="club-footer__colors" aria-hidden="true"><i></i><i></i><i></i></span>
            </div>
        </footer>
    </div>
</template>
