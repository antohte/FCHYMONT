<script setup lang="ts">
import ClubCheckbox from '@/components/club/ClubCheckbox.vue';
import ClubFormField from '@/components/club/ClubFormField.vue';
import ClubSelect from '@/components/club/ClubSelect.vue';
import PlayerCardArtwork from '@/components/club/PlayerCardArtwork.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import type { AdminPlayer } from '@/types/admin';
import type { PlayerPositionOption } from '@/types/player';
import { useForm } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';
const props = defineProps<{ open: boolean; player: AdminPlayer | null; positions: PlayerPositionOption[] }>();
const emit = defineEmits<{ close: []; restoreFocus: [] }>();
const form = useForm({
    _method: 'put',
    display_name: '',
    first_name: '',
    last_name: '',
    birth_date: '',
    position: 'defender',
    position_label: '',
    number: '' as string | number,
    show_goals: false,
    show_saves: false,
    goals: '' as string | number,
    saves: '' as string | number,
    is_published: false as boolean,
    photo: null as File | null,
    remove_photo: false as boolean,
});
const fields = [
    { key: 'display_name', label: 'Nom sur la carte *', type: 'text' },
    { key: 'first_name', label: 'Prénom', type: 'text' },
    { key: 'last_name', label: 'Nom de famille', type: 'text' },
    { key: 'birth_date', label: 'Date de naissance (âge calculé automatiquement)', type: 'date' },
    { key: 'position_label', label: 'Poste détaillé *', type: 'text' },
    { key: 'number', label: 'Numéro de maillot', type: 'number' },
    { key: 'goals', label: 'Total de buts', type: 'number' },
    { key: 'saves', label: 'Total d’arrêts', type: 'number' },
] as const;
const imageUrl = ref<string | null>(null);
function clearPreview() {
    if (imageUrl.value) URL.revokeObjectURL(imageUrl.value);
    imageUrl.value = null;
}
onBeforeUnmount(clearPreview);
watch(
    () => props.open,
    (open) => {
        if (!open) return;
        clearPreview();
        form.reset();
        form.clearErrors();
        if (props.player)
            Object.assign(form, {
                display_name: props.player.displayName,
                first_name: props.player.firstName ?? '',
                last_name: props.player.lastName ?? '',
                birth_date: props.player.birthDate ?? '',
                position: props.player.position,
                position_label: props.player.positionLabel,
                number: props.player.number ?? '',
                show_goals: props.player.showGoals,
                show_saves: props.player.showSaves,
                goals: props.player.goals ?? '',
                saves: props.player.saves ?? '',
                is_published: props.player.published,
            });
    },
);
const preview = computed(() => ({
    id: props.player?.id ?? 0,
    displayName: form.display_name || 'Votre joueur',
    firstName: form.first_name || null,
    lastName: form.last_name || null,
    age: null,
    position: form.position,
    positionCode: ({ goalkeeper: 'G', defender: 'DÉF', midfielder: 'MIL', forward: 'ATT' } as Record<string, string>)[form.position],
    positionLabel: form.position_label || 'Poste',
    number: form.number === '' ? null : Number(form.number),
    photoUrl: imageUrl.value ?? (form.remove_photo ? null : (props.player?.photoUrl ?? null)),
}));
function choosePhoto(event: Event) {
    clearPreview();
    form.photo = (event.target as HTMLInputElement).files?.[0] ?? null;
    if (form.photo) {
        imageUrl.value = URL.createObjectURL(form.photo);
        form.remove_photo = false;
    }
}
function save() {
    form.transform((data) => ({
        ...data,
        _method: props.player ? 'put' : 'post',
        number: data.number === '' ? null : Number(data.number),
        goals: data.goals === '' ? null : Number(data.goals),
        saves: data.saves === '' ? null : Number(data.saves),
    }));
    form.post(props.player ? route('admin.players.update', { player: props.player.id }) : route('admin.players.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => emit('close'),
        onError: () => nextTick(() => document.querySelector<HTMLElement>('.calendar-dialog [aria-invalid="true"]')?.focus()),
    });
}
</script>
<template>
    <Dialog :open="open" @update:open="!$event && !form.processing && emit('close')"
        ><DialogContent class="club-theme calendar-dialog admin-player-dialog" @close-auto-focus.prevent="emit('restoreFocus')">
            <DialogHeader
                ><DialogTitle>{{ player ? 'Modifier le joueur' : 'Ajouter un joueur' }}</DialogTitle
                ><DialogDescription
                    >Renseignez uniquement les informations connues. Le nom sur la carte peut rester abrégé.</DialogDescription
                ></DialogHeader
            >
            <div class="admin-player-editor">
                <div class="admin-player-preview"><PlayerCardArtwork :player="preview" /></div>
                <form class="calendar-form" @submit.prevent="save">
                    <div class="calendar-form__grid">
                        <ClubFormField
                            v-for="field in fields"
                            :key="field.key"
                            :id="`player-${field.key}`"
                            :label="field.label"
                            :error="form.errors[field.key]"
                            v-slot="attrs"
                            ><Input
                                v-bind="attrs"
                                v-model="form[field.key]"
                                :type="field.type"
                                :required="['display_name', 'position_label'].includes(field.key)"
                                :aria-invalid="attrs.invalid || undefined"
                                :aria-describedby="attrs.describedby"
                                :min="field.key === 'number' ? 1 : 0"
                            />
                            <ClubCheckbox
                                v-if="field.key === 'goals' || field.key === 'saves'"
                                :id="`player-show-${field.key}`"
                                v-model="form[field.key === 'goals' ? 'show_goals' : 'show_saves']"
                                :label="
                                    field.key === 'goals' ? 'Afficher les buts sur la fiche publique' : 'Afficher les arrêts sur la fiche publique'
                                "
                                :error="form.errors[field.key === 'goals' ? 'show_goals' : 'show_saves']"
                            />
                        </ClubFormField>
                        <ClubFormField id="player-position" label="Famille de poste" :error="form.errors.position" v-slot="attrs"
                            ><ClubSelect v-bind="attrs" v-model="form.position" :options="positions"
                        /></ClubFormField>
                        <ClubFormField id="player-published" label="Visibilité" :error="form.errors.is_published" v-slot="attrs"
                            ><ClubSelect
                                v-bind="attrs"
                                :model-value="form.is_published ? 'published' : 'draft'"
                                :options="[
                                    { value: 'draft', label: 'Brouillon' },
                                    { value: 'published', label: 'Publié' },
                                ]"
                                @update:model-value="form.is_published = $event === 'published'"
                        /></ClubFormField>
                        <ClubFormField id="player-photo" label="Portrait (JPEG, PNG, WebP, 4 Mo maximum)" :error="form.errors.photo" v-slot="attrs"
                            ><Input
                                v-bind="attrs"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                :aria-invalid="attrs.invalid || undefined"
                                :aria-describedby="attrs.describedby"
                                @change="choosePhoto"
                        /></ClubFormField>
                        <Button
                            v-if="player?.photoUrl"
                            type="button"
                            variant="outline"
                            :aria-pressed="form.remove_photo"
                            @click="
                                form.remove_photo = !form.remove_photo;
                                form.photo = null;
                                clearPreview();
                            "
                            >{{ form.remove_photo ? 'Conserver le portrait' : 'Retirer le portrait' }}</Button
                        >
                    </div>
                    <div class="calendar-form__actions">
                        <Button type="button" variant="outline" :disabled="form.processing" @click="emit('close')">Annuler</Button
                        ><Button type="submit" :disabled="form.processing">{{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}</Button>
                    </div>
                </form>
            </div>
        </DialogContent></Dialog
    >
</template>
