<script setup lang="ts">
import PlayerDetails from '@/components/club/PlayerDetails.vue';
import { Dialog, DialogContent, DialogDescription, DialogTitle } from '@/components/ui/dialog';
import type { PublicPlayer } from '@/types/player';

withDefaults(defineProps<{ player: PublicPlayer | null; variant?: 'portrait' | 'card' }>(), { variant: 'portrait' });
const emit = defineEmits<{ close: []; restoreFocus: [] }>();
function restoreFocus(event: Event) {
    event.preventDefault();
    emit('restoreFocus');
}
</script>

<template>
    <Dialog :open="player !== null" @update:open="!$event && emit('close')">
        <DialogContent class="club-player-dialog" @close-auto-focus="restoreFocus">
            <DialogTitle class="sr-only">Fiche de {{ player?.displayName }}</DialogTitle>
            <DialogDescription class="sr-only">Informations du joueur du Football Club Hymont.</DialogDescription>
            <PlayerDetails v-if="player" :player="player" :variant="variant" />
        </DialogContent>
    </Dialog>
</template>
