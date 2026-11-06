<script setup lang="ts">
import PlayerCardArtwork from '@/components/club/PlayerCardArtwork.vue';
import PlayerPortrait from '@/components/club/PlayerPortrait.vue';
import type { PublicPlayer } from '@/types/player';
import { computed } from 'vue';

const props = withDefaults(defineProps<{ player: PublicPlayer; variant?: 'portrait' | 'card' }>(), { variant: 'portrait' });

// Les noms importés sont abrégés : conserver uniquement les informations connues.
const abbreviatedName = computed(() => props.player.displayName.trim().match(/^(.+)\s+(\p{L})\.?$/u));
const firstName = computed(() => props.player.firstName?.trim() || abbreviatedName.value?.[1] || 'Non renseigné');
const lastName = computed(() => props.player.lastName?.trim() || abbreviatedName.value?.[2] || 'Non renseigné');
const lastNameLabel = computed(() => (!props.player.lastName?.trim() && abbreviatedName.value ? 'Nom (initiale)' : 'Nom'));
</script>

<template>
    <article class="player-details" :class="{ 'player-details--card': variant === 'card' }">
        <div v-if="variant === 'card'" class="player-details__card"><PlayerCardArtwork :player="player" /></div>
        <div v-else class="player-details__visual">
            <span class="player-details__number" aria-hidden="true">{{ player.number !== null ? `#${player.number}` : 'FCH' }}</span
            ><PlayerPortrait :src="player.photoUrl" :name="player.displayName" />
        </div>
        <p class="player-details__eyebrow">Football Club Hymont</p>
        <h2>{{ player.displayName }}</h2>
        <p class="player-details__position">{{ player.positionLabel }}</p>
        <dl>
            <div>
                <dt>Prénom</dt>
                <dd>{{ firstName }}</dd>
            </div>
            <div>
                <dt>{{ lastNameLabel }}</dt>
                <dd>{{ lastName }}</dd>
            </div>
            <div>
                <dt>Âge</dt>
                <dd>{{ player.age !== null ? `${player.age} ans` : 'Non renseigné' }}</dd>
            </div>
            <div>
                <dt>Numéro de maillot</dt>
                <dd>{{ player.number ?? 'Non renseigné' }}</dd>
            </div>
            <div v-for="statistic in player.statistics" :key="statistic.label" class="player-details__statistic">
                <dt>{{ statistic.label }}</dt>
                <dd>{{ statistic.value }}</dd>
            </div>
        </dl>
    </article>
</template>
