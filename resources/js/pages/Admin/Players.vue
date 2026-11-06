<script setup lang="ts">
import ClubAdminNavigation from '@/components/club/ClubAdminNavigation.vue';
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import ClubSearchField from '@/components/club/ClubSearchField.vue';
import PlayerCard from '@/components/club/PlayerCard.vue';
import PlayerFormDialog from '@/components/club/PlayerFormDialog.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { AdminPlayer } from '@/types/admin';
import type { PlayerPositionOption } from '@/types/player';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, shallowRef } from 'vue';
const props = defineProps<{ players: AdminPlayer[]; positions: PlayerPositionOption[]; notice: string | null }>();
const search = ref('');
const open = ref(false);
const editing = ref<AdminPlayer | null>(null);
const deleting = ref<AdminPlayer | null>(null);
const trigger = shallowRef<HTMLElement | null>(null);
const deletion = useForm({});
const filtered = computed(() =>
    props.players.filter((player) => player.displayName.toLocaleLowerCase('fr').includes(search.value.toLocaleLowerCase('fr'))),
);
function edit(player: AdminPlayer | null, element: HTMLElement) {
    editing.value = player;
    trigger.value = element;
    open.value = true;
}
function remove() {
    if (deleting.value)
        deletion.delete(route('admin.players.destroy', { player: deleting.value.id }), {
            preserveScroll: true,
            onSuccess: () => {
                deleting.value = null;
                trigger.value = document.querySelector('#ajouter-joueur');
            },
        });
}
</script>
<template>
    <ClubLayout active="team" title="Gestion des joueurs"
        ><section class="club-container club-calendar">
            <ClubAdminNavigation active="players" />
            <header class="calendar-heading">
                <div>
                    <h1>L’effectif<span>.</span></h1>
                    <p>Les cartes et les informations de vos joueurs.</p>
                </div>
                <Button id="ajouter-joueur" @click="edit(null, $event.currentTarget as HTMLElement)">Ajouter un joueur</Button>
            </header>
            <p v-if="notice" role="status" class="calendar-notice">{{ notice }}</p>
            <ClubSearchField id="admin-recherche" v-model="search" label="Rechercher un joueur" placeholder="Rechercher un joueur…" />
            <ul v-if="filtered.length" class="admin-roster">
                <li v-for="player in filtered" :key="player.id">
                    <PlayerCard
                        :player="player"
                        action-text="Modifier"
                        :action-label="`Modifier ${player.displayName}`"
                        @select="(_, element) => edit(player, element)"
                    />
                    <div class="admin-roster-actions">
                        <span>{{ player.published ? 'Publié' : 'Brouillon' }}</span
                        ><Button variant="outline" @click="edit(player, $event.currentTarget as HTMLElement)">Modifier</Button
                        ><Button
                            variant="ghost"
                            :aria-label="`Supprimer ${player.displayName}`"
                            @click="
                                deleting = player;
                                trigger = $event.currentTarget as HTMLElement;
                            "
                            >Supprimer</Button
                        >
                    </div>
                </li>
            </ul>
            <ClubEmptyState v-else title="Aucun joueur trouvé." description="Ajoutez un joueur ou modifiez votre recherche." />
        </section>
        <PlayerFormDialog :open="open" :player="editing" :positions="positions" @close="open = false" @restore-focus="trigger?.focus()" />
        <Dialog :open="!!deleting" @update:open="!$event && !deletion.processing && (deleting = null)"
            ><DialogContent class="club-theme calendar-dialog calendar-dialog--confirm" @close-auto-focus.prevent="trigger?.focus()"
                ><DialogHeader
                    ><DialogTitle>Supprimer {{ deleting?.displayName }} ?</DialogTitle
                    ><DialogDescription
                        >Le joueur, son portrait et ses placements seront supprimés. Cette action est définitive.</DialogDescription
                    ></DialogHeader
                >
                <div class="calendar-form__actions">
                    <Button variant="outline" :disabled="deletion.processing" @click="deleting = null">Conserver</Button
                    ><Button variant="destructive" :disabled="deletion.processing" @click="remove">Supprimer</Button>
                </div></DialogContent
            ></Dialog
        >
    </ClubLayout>
</template>
