<script setup lang="ts">
import ClubAction from '@/components/club/ClubAction.vue';
import ClubAdminNavigation from '@/components/club/ClubAdminNavigation.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
const sections = [
    { key: 'players', title: 'Joueurs', description: 'Cartes, portraits, identité, âge et statistiques.' },
    { key: 'selection', title: 'Convocation', description: 'Préparer le terrain, les remplaçants et publier la sélection.' },
    { key: 'calendar', title: 'Calendrier', description: 'Rencontres, dates, horaires, lieux et résultats.' },
    { key: 'news', title: 'Actualités', description: 'Rédiger, illustrer et publier les nouvelles du club.' },
    { key: 'sponsors', title: 'Sponsors', description: 'Bannières, logos, présentations et coordonnées.' },
    { key: 'contacts', title: 'Contacts', description: 'Adresse du stade et contacts téléphoniques.' },
    { key: 'social', title: 'Réseaux', description: 'Comptes Instagram et Facebook du club.' },
];
</script>
<template>
    <ClubLayout active="" title="Administration">
        <section class="club-container club-calendar">
            <ClubAdminNavigation active="index" />
            <header class="calendar-heading">
                <div>
                    <h1>Administration<span>.</span></h1>
                    <p>Gérez les contenus du FC Hymont.</p>
                </div>
            </header>
            <div class="admin-sections">
                <article v-for="section in sections" :key="section.key" class="admin-section">
                    <h2>{{ section.title }}</h2>
                    <p>{{ section.description }}</p>
                    <ClubAction :href="route(`admin.${section.key}.index`)" variant="secondary"
                        >Gérer
                        {{
                            section.key === 'calendar'
                                ? 'le calendrier'
                                : section.key === 'selection'
                                  ? 'la convocation'
                                  : 'les ' + section.title.toLocaleLowerCase('fr')
                        }}</ClubAction
                    >
                </article>
            </div>
        </section>
    </ClubLayout>
</template>
