<script setup lang="ts">
import ClubFormField from '@/components/club/ClubFormField.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { ContentEntry } from '@/types/content';
import { Plus, Trash2 } from 'lucide-vue-next';
const props = defineProps<{ kind: string; errors: Partial<Record<string, string>> }>();
const entries = defineModel<ContentEntry[]>({ required: true });
function add() {
    entries.value = [...entries.value, props.kind === 'contacts' ? { name: '', phone: '' } : { name: '', account: '', url: '' }];
}
function remove(index: number) {
    entries.value = entries.value.filter((_, i) => i !== index);
}
</script>
<template>
    <div class="admin-editable-contacts">
        <div v-for="(entry, index) in entries" :key="index" class="admin-editable-contacts__row">
            <ClubFormField
                v-for="key in kind === 'contacts' ? ['name', 'phone'] : ['name', 'account', 'url']"
                :id="`entry-${index}-${key}`"
                :key="key"
                :label="
                    key === 'name'
                        ? kind === 'contacts'
                            ? 'Nom du contact'
                            : 'Nom du réseau'
                        : key === 'phone'
                          ? 'Téléphone'
                          : key === 'account'
                            ? 'Nom du compte'
                            : 'Lien du profil'
                "
                :error="errors[`entries.${index}.${key}`]"
                v-slot="slot"
            >
                <Input
                    :id="slot.id"
                    v-model="entry[key]"
                    :type="key === 'phone' ? 'tel' : key === 'url' ? 'url' : 'text'"
                    :required="key !== 'account'"
                    :aria-invalid="slot.invalid"
                    :aria-describedby="slot.describedby"
                />
            </ClubFormField>
            <Button
                type="button"
                variant="ghost"
                size="icon"
                :aria-label="`Supprimer ${entry.name || (kind === 'contacts' ? 'ce contact' : 'ce réseau')}`"
                @click="remove(index)"
                ><Trash2 class="size-4" aria-hidden="true"
            /></Button>
        </div>
        <Button
            type="button"
            variant="outline"
            size="icon"
            :aria-label="kind === 'contacts' ? 'Ajouter un contact' : 'Ajouter un réseau'"
            :title="kind === 'contacts' ? 'Ajouter un contact' : 'Ajouter un réseau'"
            @click="add"
            ><Plus class="size-5" aria-hidden="true"
        /></Button>
    </div>
</template>
