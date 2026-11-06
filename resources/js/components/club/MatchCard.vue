<script setup lang="ts">
import { formatMatchDate } from '@/lib/calendar';
import { fixtureStatuses, type Fixture } from '@/types/calendar';
import { MapPin } from 'lucide-vue-next';
import { computed } from 'vue';
const props = defineProps<{ fixture: Fixture; featured?: boolean }>();
const result = computed(() => {
    if (props.fixture.status !== 'finished') return null;
    if (props.fixture.outcome) return { win: 'Victoire', draw: 'Match nul', loss: 'Défaite' }[props.fixture.outcome];
    const { clubScore, opponentScore } = props.fixture;
    if (clubScore === null || opponentScore === null) return 'Résultat non communiqué';
    return clubScore > opponentScore ? 'Victoire' : clubScore < opponentScore ? 'Défaite' : 'Match nul';
});
const sides = computed(() => {
    const club = { name: 'FC Hymont', club: true, score: props.fixture.clubScore };
    const opponent = { name: props.fixture.opponent, club: false, score: props.fixture.opponentScore };
    return props.fixture.home ? [club, opponent] : [opponent, club];
});
</script>
<template>
    <article class="match-card" :class="{ 'match-card--featured': featured }">
        <div class="match-card__top">
            <span>{{ fixture.competition }}</span
            ><span class="match-card__status" :data-status="fixture.status">{{ fixtureStatuses[fixture.status] }}</span>
        </div>
        <div class="match-card__date">
            <time :datetime="fixture.date">{{ formatMatchDate(fixture.date, { weekday: 'long', day: 'numeric', month: 'long' }) }}</time
            ><span>{{ fixture.home ? 'Domicile' : 'Extérieur' }}</span>
        </div>
        <div class="match-card__teams">
            <template v-for="(side, index) in sides" :key="index">
                <div class="match-card__team">
                    <img v-if="side.club" src="/images/club-logo.png" alt="" width="526" height="526" /><span
                        v-else
                        class="match-card__opponent"
                        aria-hidden="true"
                        >{{
                            side.name
                                .split(/\s+/)
                                .map((word) => word[0])
                                .slice(0, 3)
                                .join('')
                        }}</span
                    >
                    <h3>{{ side.name }}</h3>
                </div>
                <div v-if="index === 0" class="match-card__score">
                    <template v-if="fixture.status === 'finished' && fixture.clubScore !== null && fixture.opponentScore !== null"
                        ><span class="sr-only">Score : </span>{{ sides[0].score }} <span>–</span> {{ sides[1].score }}</template
                    ><template v-else-if="fixture.status === 'finished'"
                        ><strong>{{ result }}</strong
                        ><small>Score non communiqué</small></template
                    ><template v-else
                        ><strong>{{ fixture.time?.replace(':', ' h ') ?? 'VS' }}</strong
                        ><small v-if="!fixture.time">Horaire à confirmer</small></template
                    >
                </div>
            </template>
        </div>
        <p class="match-card__venue"><MapPin :size="14" aria-hidden="true" />{{ fixture.venue || 'Lieu à confirmer' }}</p>
        <slot />
    </article>
</template>
