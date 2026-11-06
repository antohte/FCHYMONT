<script setup lang="ts">
import { Button } from '@/components/ui/button';
import type { Sponsor } from '@/types/sponsor';
import { ArrowUpRight, MapPin, Phone } from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';

defineProps<{ sponsor: Sponsor }>();
const panel = ref<HTMLElement | null>(null);
const revealed = ref(false);
let observer: IntersectionObserver | undefined;
onMounted(() => {
    if (!('IntersectionObserver' in window)) {
        revealed.value = true;
        return;
    }
    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                revealed.value = true;
                observer?.disconnect();
            }
        },
        { threshold: 0.15 },
    );
    if (panel.value) observer.observe(panel.value);
});
onBeforeUnmount(() => observer?.disconnect());
</script>

<template>
    <article
        :id="sponsor.id"
        ref="panel"
        class="sponsor-banner"
        :class="[`sponsor-banner--${sponsor.theme || sponsor.id}`, { 'is-revealed': revealed }]"
        :aria-labelledby="`sponsor-${sponsor.id}`"
    >
        <div class="sponsor-banner__visual">
            <img v-if="sponsor.photo" :src="sponsor.photo" :alt="`Photo de ${sponsor.name}`" class="sponsor-banner__photo" width="989" height="467" />
            <span v-if="(sponsor.theme || sponsor.id) === 'snack'" class="sponsor-banner__numeral" aria-hidden="true">51</span>
            <div v-if="(sponsor.theme || sponsor.id) === 'modern'" class="sponsor-banner__rays" aria-hidden="true"></div>
            <svg v-if="(sponsor.theme || sponsor.id) === 'someny'" class="sponsor-banner__house" viewBox="0 0 500 400" fill="none" aria-hidden="true">
                <path d="M35 210 250 40 465 210M90 170V360H410V170M180 360V245H270V360M315 220H365V275H315ZM35 385H465" />
            </svg>
            <div class="sponsor-banner__logo">
                <img :src="sponsor.logo" :alt="sponsor.name" :loading="(sponsor.theme || sponsor.id) === 'planb' ? 'eager' : 'lazy'" />
            </div>
        </div>
        <div class="sponsor-banner__content">
            <div class="sponsor-banner__identity">
                <h2 :id="`sponsor-${sponsor.id}`">{{ sponsor.name }}</h2>
                <span>{{ sponsor.category }}</span>
            </div>
            <p class="sponsor-banner__title">{{ sponsor.title }}</p>
            <p class="sponsor-banner__description">{{ sponsor.description }}</p>
            <ul v-if="sponsor.specialties.length" class="sponsor-banner__specialties" aria-label="SpÃ©cialitÃ©s">
                <li v-for="specialty in sponsor.specialties" :key="specialty">{{ specialty }}</li>
            </ul>
            <address v-if="sponsor.address || sponsor.phone" class="sponsor-banner__contact">
                <p v-if="sponsor.address"><MapPin :size="16" aria-hidden="true" />{{ sponsor.address }}</p>
                <a v-if="sponsor.phone" :href="`tel:+33${sponsor.phone.replaceAll(' ', '').slice(1)}`"
                    ><Phone :size="16" aria-hidden="true" />{{ sponsor.phone }}</a
                >
            </address>
            <Button v-if="sponsor.website" as-child class="sponsor-banner__action"
                ><a :href="sponsor.website" target="_blank" rel="noopener noreferrer" :aria-label="`DÃ©couvrir ${sponsor.name} (nouvel onglet)`"
                    >DÃ©couvrir {{ sponsor.name }}<ArrowUpRight :size="18" aria-hidden="true" /></a
            ></Button>
        </div>
    </article>
</template>
