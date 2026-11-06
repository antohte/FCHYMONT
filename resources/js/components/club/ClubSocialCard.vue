<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ArrowUpRight, Globe } from 'lucide-vue-next';

defineProps<{
    network: string;
    name: string;
    account: string;
    href: string;
}>();
</script>

<template>
    <article class="club-social-card" :class="`club-social-card--${network}`" :aria-labelledby="`social-${network}`">
        <div class="club-social-card__visual" aria-hidden="true">
            <svg v-if="network === 'instagram'" viewBox="0 0 100 100" fill="none">
                <rect x="14" y="14" width="72" height="72" rx="21" stroke="currentColor" stroke-width="6" />
                <circle cx="50" cy="50" r="18" stroke="currentColor" stroke-width="6" />
                <circle cx="73" cy="28" r="4.5" fill="currentColor" />
            </svg>
            <svg v-else-if="network === 'facebook'" viewBox="0 0 100 100" fill="currentColor">
                <path d="M60 90V55h12l2-15H60v-9c0-5 2-8 8-8h7V10c-3-.5-7-1-12-1-13 0-21 8-21 22v9H30v15h12v35z" />
            </svg>
            <Globe v-else :size="100" />
        </div>
        <div class="club-social-card__content">
            <h2 :id="`social-${network}`">{{ name }}</h2>
            <p>{{ account }}</p>
            <Button as-child size="lg" class="club-social-card__action">
                <a :href="href" target="_blank" rel="noopener noreferrer" :aria-label="`Ouvrir ${name} (nouvel onglet)`">
                    Ouvrir {{ name }}<ArrowUpRight :size="18" aria-hidden="true" />
                </a>
            </Button>
        </div>
    </article>
</template>
