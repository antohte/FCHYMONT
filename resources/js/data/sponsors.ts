import type { Sponsor } from '@/types/sponsor';

// Sources et date de vérification : DESIGN.md, section Sponsors.
export const sponsors: Sponsor[] = [
    {
        id: 'planb',
        name: 'Le Plan B',
        logo: '/images/sponsors/le-plan-b.png',
        category: 'Restaurant à Mirecourt',
        title: 'Une cuisine de saison.',
        description:
            'Des produits frais, une carte évolutive et une terrasse pour prendre le temps. Le Plan B propose aussi des prestations traiteur et la privatisation du restaurant.',
        specialties: ['Cuisine de saison', 'Terrasse', 'Traiteur'],
        website: 'https://restaurantleplanb.fr/?lang=fr',
        address: '3 rue Georges Clemenceau, 88500 Mirecourt',
        phone: '03 54 04 35 81',
        photo: '/images/sponsors/le-plan-b-terrasse.png',
    },
    {
        id: 'snack',
        name: 'Snack51',
        logo: '/images/sponsors/snack51.png',
        category: 'Restauration à Mirecourt',
        title: 'Smash. Tacos. Kebab.',
        description:
            'Smash burgers, tacos et kebabs à retrouver chez le partenaire du club. Consultez la carte et les possibilités de commande directement sur son site.',
        specialties: ['Smash burgers', 'Tacos', 'Kebab'],
        website: 'https://snack51.com/',
        address: '6 rue Germini, 88500 Mirecourt',
        phone: '03 29 29 52 34',
    },
    {
        id: 'modern',
        name: 'Modern Sport',
        logo: '/images/sponsors/modern-sport.png',
        category: 'Partenaire du FC Hymont',
        title: 'Laxenaire & Fils.',
        description: 'Modern Sport accompagne le FC Hymont. Retrouvez ici les couleurs et la signature de notre partenaire.',
        specialties: [],
    },
    {
        id: 'someny',
        name: 'Someny',
        logo: '/images/sponsors/someny.png',
        category: 'Rénovation énergétique',
        title: 'Du confort pour votre habitat.',
        description: 'Chauffage, climatisation, isolation et audit énergétique : Someny accompagne les projets de rénovation de l’habitat.',
        specialties: ['Chauffage', 'Climatisation', 'Isolation'],
        website: 'https://www.someny.fr/',
        address: '2 avenue Nelson Mandela, 54510 Tomblaine',
        phone: '03 74 72 88 88',
    },
];
