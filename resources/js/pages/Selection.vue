<script setup lang="ts">
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import PlayerCard from '@/components/club/PlayerCard.vue';
import PlayerDetails from '@/components/club/PlayerDetails.vue';
import PlayerDetailsDialog from '@/components/club/PlayerDetailsDialog.vue';
import SelectionPitch from '@/components/club/SelectionPitch.vue';
import { Button } from '@/components/ui/button';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { PublicPlayer, SelectionEntry } from '@/types/player';
import { Head } from '@inertiajs/vue3';
import { useMediaQuery } from '@vueuse/core';
import { X } from 'lucide-vue-next';
import { computed, nextTick, ref, shallowRef, watch } from 'vue';

const props = defineProps<{ entries: SelectionEntry[]; preview: boolean }>();
const starters = computed(() => props.entries.filter((entry) => !entry.bench));
const substitutes = computed(() => props.entries.filter((entry) => entry.bench));
const mobile = useMediaQuery('(max-width: 900px)');
const selectedId = ref<number | null>(null);
const selectedPlayer = computed(() => props.entries.find((entry) => entry.player.id === selectedId.value)?.player ?? null);
const dialogOpen = ref(false);
const trigger = shallowRef<HTMLElement | null>(null);
function selectPlayer(player: PublicPlayer, element: HTMLElement) {
    selectedId.value = player.id;
    trigger.value = element;
    dialogOpen.value = mobile.value;
}
function closePlayer() {
    selectedId.value = null;
    dialogOpen.value = false;
    nextTick(() => trigger.value?.focus({ preventScroll: true }));
}
watch(mobile, () => (dialogOpen.value = false));
watch(
    () => props.entries,
    (entries) => {
        if (!entries.some((entry) => entry.player.id === selectedId.value)) selectedId.value = null;
        dialogOpen.value = false;
    },
);
</script>

<template>
    <ClubLayout active="selection" title="Convocation">
        <Head
            ><meta name="description" head-key="description" content="La convocation du FC Hymont : les joueurs sur le terrain et leurs fiches."
        /></Head>
        <section class="club-container club-selection" aria-labelledby="convocation-titre">
            <header class="selection-heading">
                <h1 id="convocation-titre">Convocation<span>.</span></h1>
            </header>
            <div v-if="entries.length" class="selection-layout" :class="{ 'selection-layout--with-player': selectedPlayer && !mobile }">
                <div class="selection-lineup">
                    <SelectionPitch :entries="starters" :selected-id="selectedId ?? undefined" :opens-dialog="mobile" @select="selectPlayer" />
                    <section v-if="substitutes.length" class="selection-bench" aria-labelledby="remplacants-titre">
                        <div class="selection-bench__heading">
                            <h2 id="remplacants-titre">Remplaçants</h2>
                            <span>{{ substitutes.length }} joueurs</span>
                        </div>
                        <ul>
                            <li v-for="entry in substitutes" :key="entry.player.id">
                                <PlayerCard
                                    :player="entry.player"
                                    variant="pitch"
                                    :selected="entry.player.id === selectedId"
                                    :opens-dialog="mobile"
                                    @select="selectPlayer"
                                />
                            </li>
                        </ul>
                    </section>
                </div>
                <aside
                    v-if="selectedPlayer && !mobile"
                    id="selection-player-panel"
                    class="selection-player-panel"
                    aria-label="Fiche du joueur sélectionné"
                    @keydown.esc="closePlayer"
                >
                    <div class="selection-player-panel__heading">
                        <span>Fiche joueur</span>
                        <Button type="button" variant="ghost" size="icon" aria-label="Fermer la fiche du joueur" @click="closePlayer"
                            ><X aria-hidden="true"
                        /></Button>
                    </div>
                    <div class="sr-only" role="status" aria-live="polite">
                        {{ selectedPlayer ? `Joueur sélectionné : ${selectedPlayer.displayName}` : '' }}
                    </div>
                    <Transition name="selection-detail" mode="out-in"
                        ><PlayerDetails v-if="selectedPlayer" :key="selectedPlayer.id" :player="selectedPlayer" variant="card"
                    /></Transition>
                </aside>
            </div>
            <ClubEmptyState
                v-else
                title="La convocation arrive bientôt."
                description="Les joueurs retenus et leur placement apparaîtront ici après publication."
            />
        </section>
        <PlayerDetailsDialog
            variant="card"
            :player="mobile && dialogOpen ? selectedPlayer : null"
            @close="closePlayer"
            @restore-focus="trigger?.focus()"
        />
    </ClubLayout>
</template>
