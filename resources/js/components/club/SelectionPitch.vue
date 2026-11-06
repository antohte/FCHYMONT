<script setup lang="ts">
import PitchLines from '@/components/club/PitchLines.vue';
import PlayerCard from '@/components/club/PlayerCard.vue';
import { Button } from '@/components/ui/button';
import type { PitchSlot } from '@/types/admin';
import type { PublicPlayer, SelectionEntry } from '@/types/player';

defineProps<{
    entries: SelectionEntry[];
    selectedId?: number;
    opensDialog: boolean;
    editing?: boolean;
    slots?: PitchSlot[];
    targetSlot?: string;
    draggingId?: number;
    disabled?: boolean;
}>();
const emit = defineEmits<{ select: [player: PublicPlayer, trigger: HTMLElement]; place: [slot: PitchSlot] }>();
</script>

<template>
    <div class="selection-pitch" role="group" aria-label="Joueurs sur le terrain">
        <img class="selection-pitch__crest" src="/images/club-logo.png" alt="FC Hymont" />
        <div class="selection-pitch__surface" aria-hidden="true"><PitchLines stretch /></div>
        <ul v-if="editing && slots" class="selection-pitch__players selection-pitch__slots" aria-label="Places prédéfinies">
            <li
                v-for="slot in slots"
                :key="slot.id"
                :data-slot-id="slot.id"
                :style="{ left: `${slot.x}%`, top: `${slot.y}%` }"
                :class="{ 'selection-slot--target': targetSlot === slot.id }"
            >
                <Button
                    type="button"
                    variant="ghost"
                    class="selection-slot"
                    :disabled="disabled || !selectedId"
                    :aria-label="`Placer le joueur sélectionné : ${slot.label}`"
                    @click="emit('place', slot)"
                >
                    <span aria-hidden="true">+</span><span class="selection-slot__label">{{ slot.label.split(' · ')[0] }}</span>
                </Button>
            </li>
        </ul>
        <ul class="selection-pitch__players">
            <li
                v-for="entry in entries"
                :key="entry.player.id"
                :data-player-id="editing ? entry.player.id : undefined"
                :class="{ 'selection-player--dragging': draggingId === entry.player.id }"
                :style="{ left: `${entry.x}%`, top: `${entry.y}%` }"
            >
                <PlayerCard
                    :player="entry.player"
                    :controls-id="editing ? 'composition-controls' : undefined"
                    :action-label="editing ? `Sélectionner ${entry.player.displayName}` : undefined"
                    variant="pitch"
                    :selected="entry.player.id === selectedId"
                    :opens-dialog="opensDialog"
                    @select="(player, trigger) => emit('select', player, trigger)"
                />
            </li>
        </ul>
    </div>
</template>
