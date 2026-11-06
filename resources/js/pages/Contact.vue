<script setup lang="ts">
import ClubContactDetails from '@/components/club/ClubContactDetails.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import type { ContactDetails } from '@/types/content';
import { Head } from '@inertiajs/vue3';
defineProps<{ details: ContactDetails | null }>();
</script>

<template>
    <ClubLayout active="contact" title="Contact">
        <Head
            ><meta
                name="description"
                content="Contactez le FC Hymont : adresse du stade municipal d’Hymont et coordonnées téléphoniques de M. Ribeiro et M. Mangin."
        /></Head>
        <div class="club-container contact-page">
            <header class="contact-page__heading">
                <h1>Contact<span>.</span></h1>
                <p>Retrouvez-nous au stade ou contactez-nous par téléphone.</p>
            </header>
            <ClubContactDetails :details="details" />
        </div>
    </ClubLayout>
</template>
