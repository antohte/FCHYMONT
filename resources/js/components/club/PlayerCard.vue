<script setup lang="ts">
import PlayerCardArtwork from '@/components/club/PlayerCardArtwork.vue';
import { Button } from '@/components/ui/button';
import type { PublicPlayer } from '@/types/player';

withDefaults(
    defineProps<{
        player: PublicPlayer;
        selected?: boolean;
        variant?: 'roster' | 'pitch';
        opensDialog?: boolean;
        controlsId?: string | null;
        actionLabel?: string;
        actionText?: string;
    }>(),
    {
        variant: 'roster',
        opensDialog: true,
        controlsId: 'selection-player-panel',
        actionText: 'Voir la fiche',
    },
);
const emit = defineEmits<{ select: [player: PublicPlayer, trigger: HTMLElement] }>();
</script>

<template>
    <Button
        type="button"
        variant="ghost"
        class="player-card"
        :class="{ 'player-card--selected': selected, 'player-card--pitch': variant === 'pitch' }"
        :aria-label="actionLabel ?? `Voir la fiche de ${player.displayName}, ${player.positionLabel}`"
        :aria-haspopup="opensDialog ? 'dialog' : undefined"
        :aria-pressed="variant === 'pitch' ? !!selected : undefined"
        :aria-controls="!opensDialog ? (controlsId ?? undefined) : undefined"
        @click="emit('select', player, $event.currentTarget as HTMLElement)"
    >
        <PlayerCardArtwork :player="player" />
        <span class="player-card__hint" aria-hidden="true">{{ actionText }} <span>↗</span></span>
    </Button>
</template>
