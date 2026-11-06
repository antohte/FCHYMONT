<script setup lang="ts">
import ClubAdminNavigation from '@/components/club/ClubAdminNavigation.vue';
import SelectionEditor from '@/components/club/SelectionEditor.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { PitchSlot, Placement } from '@/types/admin';
import type { PublicPlayer } from '@/types/player';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps<{
    players: PublicPlayer[];
    placements: Placement[];
    slots: PitchSlot[];
    publishedAt: string | null;
    hasDraft: boolean;
    notice: string | null;
}>();
const form = useForm({ placements: props.placements.map((entry) => ({ ...entry })), action: 'draft' });
const withdrawing = useForm({});
const confirm = ref(false);
function save(action: 'draft' | 'publish') {
    form.action = action;
    form.put(route('admin.selection.save'), {
        preserveScroll: true,
        onSuccess: () => {
            confirm.value = false;
        },
    });
}
</script>
<template>
    <ClubLayout active="selection" title="Gestion de la convocation"
        ><section class="club-container club-calendar club-admin-selection">
            <ClubAdminNavigation active="selection" />
            <header class="calendar-heading">
                <div>
                    <h1>La convocation<span>.</span></h1>
                    <p>
                        {{ publishedAt ? 'Une composition est publiée.' : 'Aucune composition publiée.' }}
                        {{ hasDraft ? 'Un brouillon est enregistré.' : '' }}
                    </p>
                </div>
            </header>
            <p v-if="notice" class="calendar-notice" role="status">{{ notice }}</p>
            <form @submit.prevent="save('draft')">
                <SelectionEditor v-model="form.placements" :players="players" :slots="slots" :disabled="form.processing" />
                <ul v-if="Object.keys(form.errors).length" class="club-form-error" role="alert">
                    <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
                </ul>
                <div class="admin-publication">
                    <p>Le brouillon reste privé. Publier remplace la composition visible sur le site.</p>
                    <div class="admin-actions">
                        <Button type="submit" variant="outline" :disabled="form.processing">{{
                            form.processing ? 'Enregistrement…' : 'Enregistrer le brouillon'
                        }}</Button
                        ><Button type="button" :disabled="form.processing || !form.placements.length" @click="confirm = true"
                            >Publier la convocation</Button
                        ><Button
                            v-if="publishedAt"
                            type="button"
                            variant="ghost"
                            :disabled="withdrawing.processing || form.processing"
                            @click="withdrawing.delete(route('admin.selection.unpublish'), { preserveScroll: true })"
                            >Retirer du site</Button
                        >
                    </div>
                </div>
            </form>
        </section>
        <Dialog :open="confirm" @update:open="!$event && !form.processing && (confirm = false)"
            ><DialogContent class="club-theme calendar-dialog calendar-dialog--confirm"
                ><DialogHeader
                    ><DialogTitle>Publier cette convocation ?</DialogTitle
                    ><DialogDescription
                        >Cette composition remplacera immédiatement celle du site. Vérifiez les titulaires et les remplaçants.</DialogDescription
                    ></DialogHeader
                >
                <div class="calendar-form__actions">
                    <Button variant="outline" :disabled="form.processing" @click="confirm = false">Annuler</Button
                    ><Button :disabled="form.processing" @click="save('publish')">{{
                        form.processing ? 'Publication…' : 'Confirmer la publication'
                    }}</Button>
                </div></DialogContent
            ></Dialog
        ></ClubLayout
    >
</template>
