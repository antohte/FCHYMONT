<script setup lang="ts">
import ClubAction from '@/components/club/ClubAction.vue';
import ClubAdminNavigation from '@/components/club/ClubAdminNavigation.vue';
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import FixtureFormDialog from '@/components/club/FixtureFormDialog.vue';
import MatchCard from '@/components/club/MatchCard.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { Fixture } from '@/types/calendar';
import { useForm } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import { ref, shallowRef } from 'vue';
defineProps<{ fixtures: Fixture[]; notice?: string | null }>();
const editing = ref<Fixture | null>(null);
const open = ref(false);
const deleting = ref<Fixture | null>(null);
const trigger = shallowRef<HTMLElement | null>(null);
const deletion = useForm({});
function edit(fixture: Fixture | null, event: MouseEvent) {
    trigger.value = event.currentTarget as HTMLElement;
    editing.value = fixture;
    open.value = true;
}
function askDelete(fixture: Fixture, event: MouseEvent) {
    trigger.value = event.currentTarget as HTMLElement;
    deleting.value = fixture;
}
function remove() {
    if (deleting.value)
        deletion.delete(route('admin.calendar.destroy', { fixture: deleting.value.id }), {
            preserveScroll: true,
            onSuccess: () => {
                deleting.value = null;
                trigger.value = document.querySelector<HTMLElement>('#ajouter-match');
            },
        });
}
</script>
<template>
    <ClubLayout active="calendar" title="Gestion du calendrier"
        ><section class="club-container club-calendar">
            <ClubAdminNavigation active="calendar" />
            <header class="calendar-heading">
                <div>
                    <p class="calendar-eyebrow">Administration / FC Hymont</p>
                    <h1>Le calendrier<span>.</span></h1>
                    <p>Préparer. Publier. Jouer.</p>
                </div>
                <ClubAction :href="route('calendar')" variant="secondary">Voir le calendrier public</ClubAction>
            </header>
            <p v-if="notice" role="status" class="calendar-notice">{{ notice }}</p>
            <div class="calendar-section-heading">
                <h2>{{ fixtures.length }} {{ fixtures.length === 1 ? 'rencontre' : 'rencontres' }}</h2>
                <Button id="ajouter-match" @click="edit(null, $event)"><Plus aria-hidden="true" :size="18" />Ajouter un match</Button>
            </div>
            <ul v-if="fixtures.length" class="calendar-match-list">
                <li v-for="match in fixtures" :key="match.id">
                    <MatchCard :fixture="match"
                        ><div class="calendar-admin-actions">
                            <span :class="{ 'is-published': match.published }">{{ match.published ? 'Publié' : 'Brouillon' }}</span
                            ><Button variant="outline" :aria-label="`Modifier le match contre ${match.opponent}`" @click="edit(match, $event)"
                                ><Pencil :size="15" aria-hidden="true" />Modifier</Button
                            ><Button
                                variant="ghost"
                                size="icon"
                                :aria-label="`Supprimer le match contre ${match.opponent}`"
                                @click="askDelete(match, $event)"
                                ><Trash2 :size="18" aria-hidden="true"
                            /></Button></div
                    ></MatchCard>
                </li>
            </ul>
            <ClubEmptyState
                v-else
                title="Le calendrier reste à écrire."
                description="Ajoutez une première rencontre, puis publiez-la pour la rendre visible sur le site."
            />
        </section>
        <FixtureFormDialog :open="open" :fixture="editing" @close="open = false" @restore-focus="trigger?.focus()" />
        <Dialog :open="!!deleting" @update:open="!$event && !deletion.processing && (deleting = null)"
            ><DialogContent class="club-theme calendar-dialog calendar-dialog--confirm" @close-auto-focus.prevent="trigger?.focus()"
                ><DialogHeader
                    ><DialogTitle>Supprimer cette rencontre ?</DialogTitle
                    ><DialogDescription
                        >Le match contre {{ deleting?.opponent }} sera supprimé définitivement du calendrier et du site.</DialogDescription
                    ></DialogHeader
                >
                <div class="calendar-form__actions">
                    <Button variant="outline" :disabled="deletion.processing" @click="deleting = null">Conserver</Button
                    ><Button variant="destructive" :disabled="deletion.processing" @click="remove">{{
                        deletion.processing ? 'Suppression…' : 'Supprimer'
                    }}</Button>
                </div></DialogContent
            ></Dialog
        >
    </ClubLayout>
</template>
