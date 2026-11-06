<script setup lang="ts">
import PitchLines from '@/components/club/PitchLines.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from 'lucide-vue-next';
defineProps<{ href: string; title: string; description: string; illustration: 'cards' | 'pitch' }>();
</script>
<template>
    <Link :href="href" class="club-section-link">
        <div class="club-section-link__visual" :class="`club-section-link__visual--${illustration}`" aria-hidden="true">
            <template v-if="illustration === 'cards'">
                <span v-for="index in 3" :key="index" class="mini-club-card"
                    ><img src="/images/club-logo.png" alt="" width="526" height="526" loading="lazy"
                /></span>
            </template>
            <PitchLines v-else />
        </div>
        <div class="club-section-link__copy">
            <h2>{{ title }}</h2>
            <p>{{ description }}</p>
        </div>
        <ArrowUpRight class="club-section-link__arrow" aria-hidden="true" />
    </Link>
</template>
