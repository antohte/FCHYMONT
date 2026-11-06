<script setup lang="ts">
import ClubAdminNavigation from '@/components/club/ClubAdminNavigation.vue';
import ClubContentForm from '@/components/club/ClubContentForm.vue';
import ClubEmptyState from '@/components/club/ClubEmptyState.vue';
import ClubSortableList from '@/components/club/ClubSortableList.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { ContentField, ContentItem } from '@/types/content';
import { router, useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { computed, ref, shallowRef } from 'vue';
const props = defineProps<{ kind: string; fields: ContentField[]; items: ContentItem[]; notice: string | null }>();
const titles: Record<string, string> = { news: 'Actualités', sponsors: 'Sponsors', contacts: 'Contacts', social: 'Réseaux' };
const singleton = computed(() => ['contacts', 'social'].includes(props.kind));
const sorting = ref(false);
const sortError = ref('');
function reorder(ids: number[]) {
    sorting.value = true;
    sortError.value = '';
    router.patch(
        route(`admin.${props.kind}.reorder`),
        { ids },
        {
            preserveScroll: true,
            onError: () => {
                sortError.value = 'L’ordre n’a pas pu être enregistré. La liste a été actualisée.';
                router.reload({ only: ['items'] });
            },
            onFinish: () => {
                sorting.value = false;
            },
        },
    );
}
const open = ref(false);
const editing = ref<ContentItem | null>(null);
const deleting = ref<ContentItem | null>(null);
const trigger = shallowRef<HTMLElement | null>(null);
const deletion = useForm({});
function edit(item: ContentItem | null, element: HTMLElement) {
    editing.value = item;
    trigger.value = element;
    open.value = true;
}
function remove() {
    if (!deleting.value) return;
    deletion.delete(route(`admin.${props.kind}.destroy`, { content: deleting.value.id }), {
        preserveScroll: true,
        onSuccess: () => {
            deleting.value = null;
            trigger.value = document.querySelector('#content-add');
        },
    });
}
</script>
<template>
    <ClubLayout active="" :title="`Gestion : ${titles[kind]}`">
        <section class="club-container club-calendar">
            <ClubAdminNavigation :active="kind" />
            <header class="calendar-heading">
                <div>
                    <h1>{{ titles[kind] }}<span>.</span></h1>
                    <p>
                        {{
                            singleton ? 'Modifiez les coordonnées visibles sur le site.' : 'Glissez les éléments pour choisir leur ordre sur le site.'
                        }}
                    </p>
                </div>
                <Button v-if="!singleton" id="content-add" :disabled="sorting" @click="edit(null, $event.currentTarget as HTMLElement)"
                    >Ajouter {{ kind === 'news' ? 'une actualité' : 'un sponsor' }}</Button
                >
            </header>
            <p v-if="notice" role="status" class="calendar-notice">{{ notice }}</p>
            <p v-if="sortError" role="alert">{{ sortError }}</p>
            <ClubSortableList v-if="items.length" :items="items" :sortable="!singleton" :disabled="sorting" @reorder="reorder" v-slot="{ item }">
                <img v-if="item.data.logo || item.data.photo" :src="String(item.data.logo || item.data.photo)" alt="" class="admin-content-thumb" />
                <div class="admin-content-summary">
                    <h2>{{ item.data.name || item.data.title || titles[kind] }}</h2>
                    <p v-if="item.data.excerpt">{{ item.data.excerpt }}</p>
                </div>
                <div class="admin-actions">
                    <Button variant="outline" :disabled="sorting" @click="edit(item, $event.currentTarget as HTMLElement)"
                        ><Plus v-if="singleton" class="size-4" aria-hidden="true" />{{ singleton ? 'Gérer les coordonnées' : 'Modifier'
                        }}<span class="sr-only"> {{ item.data.name || item.data.title || titles[kind] }}</span></Button
                    ><Button
                        v-if="!singleton"
                        :disabled="sorting"
                        variant="ghost"
                        @click="
                            deleting = item;
                            trigger = $event.currentTarget as HTMLElement;
                        "
                        >Supprimer<span class="sr-only"> {{ item.data.name || item.data.title }}</span></Button
                    >
                </div>
            </ClubSortableList>
            <ClubEmptyState v-else title="Aucun contenu." description="Ajoutez un premier contenu pour préparer sa publication." />
        </section>
        <ClubContentForm
            :key="kind"
            :open="open"
            :kind="kind"
            :fields="fields"
            :item="editing"
            @close="open = false"
            @restore-focus="trigger?.focus()"
        />
        <Dialog :open="!!deleting" @update:open="!$event && !deletion.processing && (deleting = null)"
            ><DialogContent class="club-theme calendar-dialog calendar-dialog--confirm" @close-auto-focus.prevent="trigger?.focus()"
                ><DialogHeader
                    ><DialogTitle>Supprimer cet élément ?</DialogTitle
                    ><DialogDescription
                        >Il sera retiré du site et ses images téléversées seront supprimées. Cette action est définitive.</DialogDescription
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
