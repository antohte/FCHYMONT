<script setup lang="ts">
import MatchCard from '@/components/club/MatchCard.vue';
import { Dialog, DialogContent, DialogDescription, DialogTitle } from '@/components/ui/dialog';
import { formatMatchDate } from '@/lib/calendar';
import type { Fixture } from '@/types/calendar';
defineProps<{ fixture: Fixture | null }>();
const emit = defineEmits<{ close: []; restoreFocus: [] }>();
function restoreFocus(event: Event) {
    event.preventDefault();
    emit('restoreFocus');
}
</script>
<template>
    <Dialog :open="fixture !== null" @update:open="!$event && emit('close')">
        <DialogContent class="club-theme calendar-dialog match-details-dialog" @close-auto-focus="restoreFocus">
            <DialogTitle>La rencontre</DialogTitle>
            <DialogDescription class="sr-only"
                >FC Hymont vs {{ fixture?.opponent }}{{ fixture ? `, le ${formatMatchDate(fixture.date)}` : '' }}. Résultat, horaire et lieu de la
                rencontre.</DialogDescription
            >
            <MatchCard v-if="fixture" :fixture="fixture" />
        </DialogContent>
    </Dialog>
</template>
