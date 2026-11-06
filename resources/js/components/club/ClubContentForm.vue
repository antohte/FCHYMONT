<script setup lang="ts">
import ClubDatePicker from '@/components/club/ClubDatePicker.vue';
import ClubEditableContacts from '@/components/club/ClubEditableContacts.vue';
import ClubFormField from '@/components/club/ClubFormField.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import type { ContentEntry, ContentField, ContentItem } from '@/types/content';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
const props = defineProps<{ open: boolean; kind: string; fields: ContentField[]; item: ContentItem | null }>();
const emit = defineEmits<{ close: []; restoreFocus: [] }>();
type Value = string | number | boolean | File | ContentEntry[] | null;
const initial: Record<string, Value> = { _method: 'post' };
for (const field of props.fields) {
    initial[field.key] = field.type === 'file' ? null : '';
    if (field.type === 'file') initial[`remove_${field.key}`] = false;
}
const form = useForm<Record<string, Value>>(initial);
watch(
    () => props.open,
    (open) => {
        if (!open) return;
        form.clearErrors();
        form.reset();
        form._method = props.item ? 'put' : 'post';
        for (const field of props.fields) {
            const value = props.item?.data[field.key];
            form[field.key] =
                field.type === 'collection'
                    ? ((value ?? []) as ContentEntry[]).map((entry) => ({ ...entry }))
                    : field.type === 'file'
                      ? null
                      : Array.isArray(value)
                        ? value.join(field.key === 'paragraphs' ? '\n\n' : '\n')
                        : String(value ?? '');
            if (field.type === 'file') form[`remove_${field.key}`] = false;
            if (field.type === 'date' && !value && !props.item) {
                const now = new Date();
                form[field.key] = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
            }
        }
    },
);
function submit() {
    const name = `admin.${props.kind}.${props.item ? 'update' : 'store'}`;
    form.transform((data) => ({ ...data, ...(Array.isArray(data.entries) ? { entries: JSON.stringify(data.entries) } : {}) })).post(
        route(name, props.item ? { content: props.item.id } : undefined),
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => emit('close'),
        },
    );
}
</script>
<template>
    <Dialog :open="open" @update:open="!$event && !form.processing && emit('close')">
        <DialogContent class="club-theme calendar-dialog admin-content-dialog" @close-auto-focus.prevent="emit('restoreFocus')">
            <DialogHeader
                ><DialogTitle>{{ item ? 'Modifier' : 'Ajouter' }}</DialogTitle
                ><DialogDescription>Les changements enregistrés sont immédiatement visibles sur le site.</DialogDescription></DialogHeader
            >
            <form class="admin-content-form" @submit.prevent="submit">
                <ClubFormField
                    v-for="field in fields"
                    :id="`content-${field.key}`"
                    :key="field.key"
                    :label="field.label + (field.required ? ' *' : '')"
                    :error="form.errors[field.key]"
                    v-slot="slot"
                >
                    <template v-if="field.type === 'file'">
                        <img
                            v-if="item?.data[field.key] && !form[`remove_${field.key}`]"
                            :src="String(item.data[field.key])"
                            :alt="field.label + ' — aperçu enregistré'"
                            class="admin-upload-preview"
                        />
                        <Input
                            :id="slot.id"
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            :aria-invalid="slot.invalid"
                            :aria-describedby="slot.describedby"
                            @change="form[field.key] = ($event.target as HTMLInputElement).files?.[0] ?? null"
                        />
                        <label v-if="item?.data[field.key]" class="admin-checkbox"
                            ><Checkbox
                                :checked="Boolean(form[`remove_${field.key}`])"
                                @update:checked="form[`remove_${field.key}`] = $event === true"
                            />Retirer cette image</label
                        >
                        <p class="admin-help">JPEG, PNG ou WebP · 4 Mo maximum.</p>
                    </template>
                    <Textarea
                        v-else-if="field.type === 'textarea'"
                        :id="slot.id"
                        :model-value="String(form[field.key] ?? '')"
                        :required="field.required"
                        :aria-invalid="slot.invalid"
                        :aria-describedby="slot.describedby"
                        :rows="field.key === 'paragraphs' ? 6 : 3"
                        @update:model-value="form[field.key] = String($event)"
                    />
                    <ClubDatePicker
                        v-else-if="field.type === 'date'"
                        :id="slot.id"
                        :model-value="String(form[field.key] ?? '')"
                        :invalid="slot.invalid"
                        :describedby="slot.describedby"
                        @update:model-value="form[field.key] = $event"
                    />
                    <ClubEditableContacts
                        v-else-if="field.type === 'collection'"
                        :kind="kind"
                        :model-value="(form[field.key] as ContentEntry[]) || []"
                        :errors="form.errors"
                        @update:model-value="form[field.key] = $event"
                    />
                    <Input
                        v-else
                        :id="slot.id"
                        :type="field.type"
                        :model-value="String(form[field.key] ?? '')"
                        :required="field.required"
                        :aria-invalid="slot.invalid"
                        :aria-describedby="slot.describedby"
                        @update:model-value="form[field.key] = String($event)"
                    />
                </ClubFormField>
                <p v-if="form.progress" role="status">Envoi : {{ form.progress.percentage }} %</p>
                <div class="calendar-form__actions">
                    <Button type="button" variant="outline" :disabled="form.processing" @click="emit('close')">Annuler</Button
                    ><Button type="submit" :disabled="form.processing">{{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}</Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
