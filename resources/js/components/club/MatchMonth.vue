<script setup lang="ts">
import MatchDetailsDialog from '@/components/club/MatchDetailsDialog.vue';
import { Button } from '@/components/ui/button';
import { formatMatchDate, monthDays } from '@/lib/calendar';
import type { Fixture } from '@/types/calendar';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';
const props = defineProps<{ month: string; today: string; fixtures: Fixture[] }>();
defineEmits<{ move: [offset: number]; today: [] }>();
const days = computed(() => monthDays(props.month));
const fixturesByDay = computed(() => {
    const map = new Map<string, Fixture[]>();
    for (const match of props.fixtures) map.set(match.date, [...(map.get(match.date) ?? []), match]);
    return map;
});
const selected = ref<Fixture | null>(null);
let trigger: HTMLElement | null = null;
function openMatch(match: Fixture, event: MouseEvent) {
    trigger = event.currentTarget as HTMLElement;
    selected.value = match;
}
function restoreFocus() {
    trigger?.focus();
    trigger = null;
}
</script>
<template>
    <section class="match-month" aria-labelledby="mois-titre">
        <header class="match-month__header">
            <h2 id="mois-titre" aria-live="polite">{{ formatMatchDate(`${month}-01`, { month: 'long', year: 'numeric' }) }}</h2>
            <div>
                <Button variant="ghost" size="icon" aria-label="Mois précédent" @click="$emit('move', -1)"><ChevronLeft aria-hidden="true" /></Button>
                <Button variant="ghost" @click="$emit('today')">Aujourd’hui</Button>
                <Button variant="ghost" size="icon" aria-label="Mois suivant" @click="$emit('move', 1)"><ChevronRight aria-hidden="true" /></Button>
            </div>
        </header>
        <div class="match-month__scroll" role="region" aria-label="Calendrier mensuel, défilement horizontal sur petit écran" tabindex="0">
            <div class="match-month__grid">
                <div class="match-month__week" aria-hidden="true">
                    <span v-for="day in ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']" :key="day">{{ day }}</span>
                </div>
                <div class="match-month__days">
                    <template v-for="(day, index) in days" :key="index">
                        <div v-if="day" class="match-month__day" :class="{ 'has-match': fixturesByDay.has(day), 'is-today': day === today }">
                            <time :datetime="day" :aria-current="day === today ? 'date' : undefined" :aria-label="formatMatchDate(day)">{{
                                Number(day.slice(-2))
                            }}</time>
                            <Button
                                v-for="match in fixturesByDay.get(day) ?? []"
                                :key="match.id"
                                variant="ghost"
                                class="match-month__fixture"
                                aria-haspopup="dialog"
                                :aria-label="`${formatMatchDate(day)} : FC Hymont vs ${match.opponent}, voir les détails`"
                                @click="openMatch(match, $event)"
                            >
                                <span>FC HYMONT <span class="match-month__versus">vs</span> {{ match.opponent }}</span>
                            </Button>
                        </div>
                        <span v-else class="match-month__blank" aria-hidden="true"></span>
                    </template>
                </div>
            </div>
        </div>
        <MatchDetailsDialog :fixture="selected" @close="selected = null" @restore-focus="restoreFocus" />
    </section>
</template>
