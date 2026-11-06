<script setup lang="ts">
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import ClubNewsCard from '@/components/club/ClubNewsCard.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { ClubNews } from '@/types/news';
import { Head } from '@inertiajs/vue3';
defineProps<{ clubNews: ClubNews[] }>();
</script>

<template>
    <ClubLayout active="news" title="Actualités">
        <Head><meta name="description" content="Les actualités du FC Hymont : comptes rendus des rencontres et nouvelles du club." /></Head>
        <div class="club-container news-page">
            <header class="news-page__heading">
                <h1>Actualités<span>.</span></h1>
            </header>
            <ClubEmptyState v-if="!clubNews.length" title="Aucune actualité publiée." description="Les nouvelles du club seront publiées ici." />
            <div class="news-page__articles">
                <ClubNewsCard v-for="(article, index) in clubNews" :key="article.id" :article="article" :featured="index === 0" />
            </div>
        </div>
    </ClubLayout>
</template>
