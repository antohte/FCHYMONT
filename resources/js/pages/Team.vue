<script setup lang="ts">
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import ClubPositionFilters from '@/components/club/ClubPositionFilters.vue';
import ClubSearchField from '@/components/club/ClubSearchField.vue';
import PlayerCard from '@/components/club/PlayerCard.vue';
import PlayerDetailsDialog from '@/components/club/PlayerDetailsDialog.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { PlayerPositionOption, PublicPlayer } from '@/types/player';
import { Head } from '@inertiajs/vue3';
import { computed, ref, shallowRef } from 'vue';

const props = defineProps<{ players: PublicPlayer[]; positions: PlayerPositionOption[] }>();
const activePosition = ref('all');
const search = ref('');
const selectedPlayer = ref<PublicPlayer | null>(null);
const trigger = shallowRef<HTMLElement | null>(null);
const options = computed(() => [
    { value: 'all', label: 'Tous', count: props.players.length },
    ...props.positions.map((position) => ({ ...position, count: props.players.filter((player) => player.position === position.value).length })),
]);
const normalize = (text: string) =>
    text
        .normalize('NFD')
        .replace(/\p{Diacritic}/gu, '')
        .toLocaleLowerCase('fr');
const filteredPlayers = computed(() =>
    props.players.filter(
        (player) =>
            (activePosition.value === 'all' || player.position === activePosition.value) &&
            normalize([player.displayName, player.firstName, player.lastName].filter(Boolean).join(' ')).includes(normalize(search.value.trim())),
    ),
);
function selectPlayer(player: PublicPlayer, element: HTMLElement) {
    selectedPlayer.value = player;
    trigger.value = element;
}
function resetFilters() {
    activePosition.value = 'all';
    search.value = '';
}
</script>

<template>
    <ClubLayout active="team" title="L’équipe">
        <Head
            ><meta
                name="description"
                head-key="description"
                content="Découvrez l’effectif du FC Hymont : les cartes des joueurs, leurs postes et leurs fiches."
        /></Head>
        <section class="club-container club-team" aria-labelledby="equipe-titre">
            <header class="club-team__heading">
                <div>
                    <p class="club-team__eyebrow"><span></span>Le collectif / FC Hymont</p>
                    <h1 id="equipe-titre">L’équipe<span>.</span></h1>
                    <p class="club-team__intro">Les joueurs qui portent nos couleurs.</p>
                </div>
            </header>
            <div v-if="players.length" class="club-team__toolbar">
                <ClubPositionFilters :active="activePosition" :options="options" @change="activePosition = $event" />
                <ClubSearchField id="recherche-joueur" v-model="search" label="Rechercher un joueur" placeholder="Rechercher un joueur…" />
            </div>
            <div class="club-team__grid-heading">
                <p role="status" aria-live="polite" aria-atomic="true">
                    {{ filteredPlayers.length }} {{ filteredPlayers.length === 1 ? 'joueur' : 'joueurs' }}
                </p>
                <span aria-hidden="true">Rouge. Noir. Blanc.</span>
            </div>
            <ul v-if="filteredPlayers.length" class="club-roster-grid" aria-label="Effectif du FC Hymont">
                <li v-for="player in filteredPlayers" :key="player.id">
                    <PlayerCard :player="player" :selected="selectedPlayer?.id === player.id" @select="selectPlayer" />
                </li>
            </ul>
            <ClubEmptyState
                v-else-if="players.length"
                title="Aucun joueur trouvé."
                description="Essayez un autre nom ou un autre poste."
                resettable
                @reset="resetFilters"
            />
            <ClubEmptyState v-else title="L’effectif arrive bientôt." description="Retrouvez ici les joueurs du FC Hymont dès leur publication." />
        </section>
        <PlayerDetailsDialog :player="selectedPlayer" @close="selectedPlayer = null" @restore-focus="trigger?.focus()" />
    </ClubLayout>
</template>
