import type { ClubNews } from '@/types/news';

// Articles du site du club, consultés le 6 novembre 2026.
// La source n’affiche pas d’année : seules les dates publiées sont reprises.
export const clubNews: ClubNews[] = [
    {
        id: 'derby-mirecourt',
        title: 'Derby remporté facilement',
        day: '01',
        month: 'novembre',
        category: 'Championnat',
        excerpt: 'Le FCH s’impose 4–1 face à Mirecourt et conserve la tête de son groupe.',
        paragraphs: [
            'Le FCH s’impose 4–1 en toute logique face à Mirecourt.',
            'Félicitations à toute l’équipe pour ce match. Le FCH reste leader avec autant de victoires que de matchs joués.',
        ],
        score: '4–1',
        opponent: 'Mirecourt',
    },
    {
        id: 'victoire-dogneville',
        title: 'Victoire 6–1 face à Dogneville',
        day: '18',
        month: 'octobre',
        category: 'Championnat',
        excerpt: 'Un déplacement maîtrisé chez le deuxième du groupe.',
        paragraphs: [
            'Ce dimanche, le FCH se déplaçait à Dogneville, deuxième du groupe.',
            'Match maîtrisé de la part de nos joueurs, qui conservent la première place du championnat.',
        ],
    },
    {
        id: 'leader-octobre',
        title: 'Le FCH consolide sa place de leader',
        day: '04',
        month: 'octobre',
        category: 'Championnat',
        excerpt: 'Une victoire arrachée en fin de match, et le soutien du club à Octobre rose.',
        paragraphs: [
            'Victoire ! À la suite d’un match très compliqué, avec beaucoup d’absents et des approximations techniques qu’il faudra corriger, le FCH empoche les trois points en fin de match grâce à une superbe tête de Gianni.',
            'L’essentiel est assuré et le FCH consolide sa place en tête de son groupe. Grosse pensée pour Sami et Théo !',
            'Nos Hymontais porteront fièrement le logo Octobre rose ce mois-ci pour soutenir cette cause qui nous tient à cœur.',
        ],
    },
    {
        id: 'coupe-vosges',
        title: 'Hymont tombe en Coupe des Vosges',
        day: '27',
        month: 'septembre',
        category: 'Coupe des Vosges',
        excerpt: 'Une élimination aux tirs au but face à l’ASF Saulxures.',
        paragraphs: [
            'Ce dimanche, nos Hymontais se sont inclinés aux tirs au but face à l’ASF Saulxures.',
            'Mention spéciale pour Alexis, notre gardien du jour. Place au championnat !',
        ],
    },
    {
        id: 'leader-septembre',
        title: 'Hymont leader de son groupe !',
        day: '20',
        month: 'septembre',
        category: 'Championnat',
        excerpt: 'Le succès face à l’AS Dompaire 2 propulse le FCH en tête.',
        paragraphs: ['À la suite du succès face à l’AS Dompaire 2, le FC Hymont s’empare de la première place de son groupe en championnat.'],
    },
    {
        id: 'depart-championnat',
        title: 'Départ parfait en championnat',
        day: '13',
        month: 'septembre',
        category: 'Championnat',
        excerpt: 'À Pouxeux, le FCH réussit son premier rendez-vous officiel en championnat.',
        paragraphs: [
            'Dimanche parfait pour le FCH ! Premier match officiel en championnat pour nos Hymontais sur le terrain de Pouxeux.',
            'Nos joueurs ont su s’adapter rapidement après un début de rencontre assez compliqué. Une réaction rapide de l’équipe dès la 15e minute a permis de reprendre la main sur le match et de dérouler son football sur le reste de la rencontre.',
            'Merci à SRPJ (Sports réunis Pouxeux-Jarménil) pour l’accueil. Nous leur souhaitons une bonne saison.',
        ],
    },
];
