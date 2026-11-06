<script setup lang="ts">
import ClubFormField from '@/components/club/ClubFormField.vue';
import ClubSelect from '@/components/club/ClubSelect.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { fixtureStatuses, type Fixture, type FixtureStatus } from '@/types/calendar';
import { useForm } from '@inertiajs/vue3';
import { nextTick, watch } from 'vue';
const props = defineProps<{ open: boolean; fixture: Fixture | null }>();
const emit = defineEmits<{ close: []; restoreFocus: [] }>();
const form = useForm({
    outcome: '',
    opponent_name: '',
    match_date: '',
    kickoff_time: '',
    competition: '',
    venue: '',
    is_home: true as boolean,
    status: 'scheduled' as FixtureStatus,
    club_score: '' as string | number,
    opponent_score: '' as string | number,
    is_published: false as boolean,
});
const fields = [
    { key: 'opponent_name', label: 'Adversaire *', type: 'text', max: 120 },
    { key: 'competition', label: 'Compétition *', type: 'text', max: 120 },
    { key: 'match_date', label: 'Date *', type: 'date', max: 10 },
    { key: 'kickoff_time', label: 'Heure (facultative)', type: 'time', max: 5 },
    { key: 'venue', label: 'Lieu (facultatif)', type: 'text', max: 160 },
] as const;
watch(
    () => props.open,
    (open) => {
        if (!open) return;
        const match = props.fixture;
        form.reset();
        form.clearErrors();
        if (match)
            Object.assign(form, {
                outcome: match.outcome ?? '',
                opponent_name: match.opponent,
                match_date: match.date,
                kickoff_time: match.time ?? '',
                competition: match.competition,
                venue: match.venue ?? '',
                is_home: match.home,
                status: match.status,
                club_score: match.clubScore ?? '',
                opponent_score: match.opponentScore ?? '',
                is_published: match.published ?? false,
            });
    },
);
watch(
    () => form.status,
    (status) => {
        if (status !== 'finished') {
            form.outcome = '';
            form.club_score = '';
            form.opponent_score = '';
        }
    },
);
function save() {
    const options = {
        preserveScroll: true,
        onSuccess: () => emit('close'),
        onError: () => nextTick(() => document.querySelector<HTMLElement>('.calendar-dialog [aria-invalid="true"]')?.focus()),
    };
    form.transform((data) => ({
        ...data,
        outcome: data.outcome || null,
        club_score: data.club_score === '' ? null : Number(data.club_score),
        opponent_score: data.opponent_score === '' ? null : Number(data.opponent_score),
    }));
    if (props.fixture) form.put(route('admin.calendar.update', { fixture: props.fixture.id }), options);
    else form.post(route('admin.calendar.store'), options);
}
</script>
<template>
    <Dialog :open="open" @update:open="!$event && !form.processing && emit('close')"
        ><DialogContent class="club-theme calendar-dialog" @close-auto-focus.prevent="emit('restoreFocus')"
            ><DialogHeader
                ><DialogTitle>{{ fixture ? 'Modifier la rencontre' : 'Ajouter une rencontre' }}</DialogTitle
                ><DialogDescription>Les champs marqués * sont obligatoires. Les horaires sont ceux de Paris.</DialogDescription></DialogHeader
            >
            <form @submit.prevent="save" class="calendar-form">
                <div class="calendar-form__grid">
                    <ClubFormField
                        v-for="field in fields"
                        :id="`match-${field.key}`"
                        :key="field.key"
                        :label="field.label"
                        :error="form.errors[field.key]"
                        v-slot="attrs"
                        ><Input
                            v-bind="attrs"
                            v-model="form[field.key]"
                            :type="field.type"
                            :maxlength="field.max"
                            :aria-invalid="attrs.invalid || undefined"
                            :aria-describedby="attrs.describedby"
                            :required="['opponent_name', 'competition', 'match_date'].includes(field.key)"
                    /></ClubFormField>
                    <ClubFormField id="match-home" label="Terrain" v-slot="attrs"
                        ><ClubSelect
                            v-bind="attrs"
                            :model-value="form.is_home ? 'home' : 'away'"
                            :options="[
                                { value: 'home', label: 'À domicile' },
                                { value: 'away', label: 'À l’extérieur' },
                            ]"
                            @update:model-value="form.is_home = $event === 'home'"
                    /></ClubFormField>
                    <ClubFormField id="match-status" label="État de la rencontre" :error="form.errors.status" v-slot="attrs"
                        ><ClubSelect
                            v-bind="attrs"
                            :model-value="form.status"
                            :options="Object.entries(fixtureStatuses).map(([value, label]) => ({ value, label }))"
                            @update:model-value="form.status = $event as FixtureStatus"
                    /></ClubFormField>
                    <template v-if="form.status === 'finished'"
                        ><ClubFormField
                            v-for="side in [
                                { key: 'club_score', label: `Buts du FC Hymont${form.outcome ? '' : ' *'}` },
                                { key: 'opponent_score', label: `Buts adverses${form.outcome ? '' : ' *'}` },
                            ] as const"
                            :key="side.key"
                            :id="`match-${side.key}`"
                            :label="side.label"
                            :error="form.errors[side.key]"
                            v-slot="attrs"
                            ><Input
                                v-bind="attrs"
                                v-model="form[side.key]"
                                type="number"
                                min="0"
                                max="99"
                                step="1"
                                :required="!form.outcome"
                                :aria-invalid="attrs.invalid || undefined"
                                :aria-describedby="attrs.describedby" /></ClubFormField
                    ></template>
                    <ClubFormField
                        v-if="form.status === 'finished'"
                        id="match-outcome"
                        label="Résultat sans score"
                        :error="form.errors.outcome"
                        v-slot="attrs"
                        ><ClubSelect
                            v-bind="attrs"
                            :model-value="form.outcome || 'score'"
                            :options="[
                                { value: 'score', label: 'Renseigner le score' },
                                { value: 'win', label: 'Victoire' },
                                { value: 'draw', label: 'Match nul' },
                                { value: 'loss', label: 'Défaite' },
                            ]"
                            @update:model-value="form.outcome = $event === 'score' ? '' : $event"
                    /></ClubFormField>
                    <ClubFormField id="match-published" label="Visibilité" :error="form.errors.is_published" v-slot="attrs"
                        ><ClubSelect
                            v-bind="attrs"
                            :model-value="form.is_published ? 'published' : 'draft'"
                            :options="[
                                { value: 'draft', label: 'Brouillon — privé' },
                                { value: 'published', label: 'Publié — visible sur le site' },
                            ]"
                            @update:model-value="form.is_published = $event === 'published'"
                    /></ClubFormField>
                </div>
                <div class="calendar-form__actions">
                    <Button variant="outline" type="button" :disabled="form.processing" @click="emit('close')">Annuler</Button
                    ><Button type="submit" :disabled="form.processing">{{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}</Button>
                </div>
            </form></DialogContent
        ></Dialog
    >
</template>
