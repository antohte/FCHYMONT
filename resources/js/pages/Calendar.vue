<script setup lang="ts">
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import MatchCard from '@/components/club/MatchCard.vue';
import MatchMonth from '@/components/club/MatchMonth.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import { shiftMonth } from '@/lib/calendar';
import type { Fixture } from '@/types/calendar';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const props = defineProps<{ fixtures: Fixture[]; today: string; currentTime: string }>();
const month = ref(props.today.slice(0, 7));
const nextMatch = computed(() =>
    props.fixtures.find(
        (match) =>
            match.status === 'scheduled' &&
            (match.date > props.today || (match.date === props.today && (!match.time || match.time >= props.currentTime))),
    ),
);
function move(offset: number) {
    month.value = shiftMonth(month.value, offset);
}
</script>
<template>
    <ClubLayout active="calendar" title="Calendrier"
        ><Head
            ><meta
                name="description"
                head-key="description"
                content="Le calendrier du FC Hymont : prochains matchs, rencontres à domicile et à l’extérieur, résultats et horaires."
        /></Head>
        <section class="club-container club-calendar" aria-labelledby="calendrier-titre">
            <header class="calendar-heading">
                <div>
                    <p class="calendar-eyebrow">La saison / FC Hymont</p>
                    <h1 id="calendrier-titre">Calendrier<span>.</span></h1>
                    <p>Les rendez-vous du collectif.</p>
                </div>
            </header>
            <section class="calendar-next" aria-labelledby="prochain-match">
                <div class="calendar-next__intro">
                    <p class="calendar-eyebrow">À l’affiche</p>
                    <h2 id="prochain-match">Prochain <br />rendez-vous<span>.</span></h2>
                </div>
                <MatchCard v-if="nextMatch" :fixture="nextMatch" featured /><ClubEmptyState
                    v-else
                    title="Le prochain rendez-vous se prépare."
                    description="La prochaine rencontre apparaîtra ici dès sa publication."
                />
            </section>
            <div class="calendar-section-heading">
                <h2>Le programme</h2>
            </div>
            <MatchMonth :month="month" :today="today" :fixtures="fixtures" @move="move" @today="month = today.slice(0, 7)" />
        </section>
    </ClubLayout>
</template>
