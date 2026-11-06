<script setup lang="ts">
import ClubBrand from '@/components/club/ClubBrand.vue';
import ClubNavigation from '@/components/club/ClubNavigation.vue';
import { Button } from '@/components/ui/button';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { Link } from '@inertiajs/vue3';
import { Menu, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';
const props = defineProps<{ active: string }>();
const open = ref(false);
watch(
    () => props.active,
    () => {
        open.value = false;
    },
);
</script>
<template>
    <header class="club-header">
        <Collapsible v-model:open="open" @keydown.esc="open = false">
            <div class="club-container club-header__row">
                <Link :href="route('home')" aria-label="FC Hymont, accueil" class="club-home-link"><ClubBrand /></Link>
                <ClubNavigation :active="active" class="club-header__desktop" />
                <CollapsibleTrigger as-child>
                    <Button variant="ghost" size="icon" class="club-menu-toggle" :aria-label="open ? 'Fermer le menu' : 'Ouvrir le menu'">
                        <X v-if="open" aria-hidden="true" /><Menu v-else aria-hidden="true" />
                    </Button>
                </CollapsibleTrigger>
            </div>
            <CollapsibleContent class="club-header__mobile">
                <div class="club-container"><ClubNavigation :active="active" mobile @navigate="open = false" /></div>
            </CollapsibleContent>
        </Collapsible>
    </header>
</template>
