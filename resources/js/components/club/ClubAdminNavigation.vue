<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Link, router } from '@inertiajs/vue3';
import { ArrowLeft, LogOut } from 'lucide-vue-next';
defineProps<{ active: string }>();
</script>
<template>
    <nav class="club-admin-nav" aria-label="Administration du club">
        <Button
            class="club-admin-nav__logout"
            size="icon"
            aria-label="Se déconnecter"
            title="Se déconnecter"
            type="button"
            variant="ghost"
            @click="router.post(route('logout'))"
            ><LogOut class="size-5" aria-hidden="true"
        /></Button>
        <Button v-if="active !== 'index'" as-child variant="ghost" size="icon" class="club-admin-nav__back">
            <Link :href="route('admin.index')" aria-label="Retour à l’accueil de l’administration" title="Retour à l’administration">
                <ArrowLeft class="size-5" aria-hidden="true" />
            </Link>
        </Button>
    </nav>
</template>
