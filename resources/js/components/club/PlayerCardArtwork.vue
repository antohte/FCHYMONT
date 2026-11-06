<script setup lang="ts">
import PlayerPortrait from '@/components/club/PlayerPortrait.vue';
import type { PublicPlayer } from '@/types/player';

defineProps<{ player: PublicPlayer }>();
</script>

<template>
    <span class="player-card__art" aria-hidden="true">
        <span class="player-card__frame">
            <span class="player-card__surface">
                <span class="player-card__top">
                    <span class="player-card__number"
                        ><small>Maillot</small><strong>{{ player.number !== null ? `#${player.number}` : '—' }}</strong
                        ><span>{{ player.positionCode }}</span></span
                    >
                    <img class="player-card__crest" src="/images/club-logo.png" alt="" />
                </span>
                <PlayerPortrait :src="player.photoUrl" :name="player.displayName" />
                <span class="player-card__identity"
                    ><strong>{{ player.displayName }}</strong
                    ><span>{{ player.positionLabel }}</span></span
                >
                <span class="player-card__footer"></span>
            </span>
        </span>
    </span>
</template>
