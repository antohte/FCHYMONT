<script setup lang="ts">
import ClubAction from '@/components/club/ClubAction.vue';
import ClubEmblemCard from '@/components/club/ClubEmblemCard.vue';
import ClubSectionLink from '@/components/club/ClubSectionLink.vue';
import PitchLines from '@/components/club/PitchLines.vue';
import ClubLayout from '@/layouts/ClubLayout.vue';
import { Head } from '@inertiajs/vue3';
import { UsersRound } from 'lucide-vue-next';
</script>
<template>
    <ClubLayout active="home" title="Accueil">
        <Head
            ><meta
                name="description"
                head-key="description"
                content="Le Football Club Hymont en rouge, noir et blanc. Découvrez l’équipe et retrouvez la convocation du club."
        /></Head>
        <section class="club-hero" aria-labelledby="accueil-titre">
            <div class="club-hero__wordmark" aria-hidden="true">HYMONT</div>
            <div class="club-container club-hero__grid">
                <div class="club-hero__copy">
                    <p class="club-hero__intro"><span aria-hidden="true"></span>Football Club Hymont</p>
                    <h1 id="accueil-titre">Un club.<br />Un collectif.</h1>
                    <p class="club-hero__description">Les mêmes couleurs. La même passion.<br />Tout commence sur le terrain.</p>
                    <div class="club-hero__actions">
                        <ClubAction :href="route('team')"><UsersRound aria-hidden="true" />Découvrir l’équipe</ClubAction>
                        <ClubAction :href="route('selection')" variant="secondary">Voir la convocation</ClubAction>
                    </div>
                </div>
                <div class="club-hero__art">
                    <div class="club-hero__pitch"><PitchLines /></div>
                    <div class="club-hero__orbit" aria-hidden="true"></div>
                    <ClubEmblemCard />
                    <div class="club-hero__art-caption" aria-hidden="true"><span>FCH</span><span>Football Club Hymont</span></div>
                </div>
            </div>
        </section>
        <section class="club-container club-destinations" aria-label="Retrouver le collectif">
            <ClubSectionLink :href="route('team')" title="L’équipe" description="Les joueurs qui portent nos couleurs." illustration="cards" />
            <ClubSectionLink
                :href="route('selection')"
                title="La convocation"
                description="Le collectif, prêt à entrer sur le terrain."
                illustration="pitch"
            />
        </section>
    </ClubLayout>
</template>
