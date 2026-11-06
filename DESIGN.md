# Direction artistique du FC Hymont

## Calendrier et gestion — 6 novembre 2026

Une grille mensuelle sobre, des dates très lisibles et des cartes de rencontre communes au public et à la gestion. Prochain match en tête, repères rouges pour les jours de rencontre, filtres Tous / À venir / Résultats. Palette existante et titres Impact conservés. Sur téléphone, grille compacte et liste détaillée sous le mois. Administration dans le même cadre : formulaire accessible partagé, brouillons et publication explicite ; aucune rencontre fictive ajoutée.

Un accueil de club pensé comme l'entrée dans un jeu de football : une carte du véritable blason au premier plan et un terrain en perspective. Les cartes des joueurs viendront au bloc 3. Aucun effectif, match ni résultat fictif.

## Palette

- Noir du club `#000000` : carte et blason.
- Noir de tribune `#101114` : fond public.
- Gris de structure `#292B31` : séparations.
- Gris de lecture `#B5B6BD` : textes secondaires.
- Blanc du maillot `#F7F7F8` : titres et texte principal.
- Rouge du club `#E5092B` : actions et découpe de la carte.

## Typographie et composition

Titres sportifs en Impact avec replis Arial Narrow et sans-serif condensée ; texte et navigation en Instrument Sans avec repli système. Titres alignés à gauche, corps courts, largeur maximale de 1 280 px.

```text
Blason + nom       Navigation
--------------------------------
Titre sportif      Carte du club
Texte + actions    Terrain incliné
--------------------------------
Accès à l'équipe   Accès à la convocation
--------------------------------
Signature du club
```

Sur téléphone : menu dépliable, titre puis carte, accès empilés. L'ordre visuel suit la lecture.

## Choix confrontés au brief

La carte du blason porte l'identité du club ; elle remplace une grille générique de chiffres ou de fausses actualités. Le rouge se concentre sur les actions et la carte. Le terrain reste décoratif, sans joueurs ni texte de formation. Une arrivée orchestrée de la carte et des interactions au survol respectent la réduction des animations.

Actions, navigation, blason, carte, terrain et entrées de rubrique sont partagés ; les boutons reposent sur shadcn-vue. Les autres pages gardent uniquement le cadre commun et un titre accessible masqué jusqu'à leur réalisation.

## Page Équipe (bloc 3)

Même palette de six couleurs et mêmes typographies. Le titre et les filtres sont alignés à gauche ; la grille présente quatre cartes par rangée sur ordinateur, trois sur tablette et deux sur téléphone. Les cartes sont le point fort : contour métallique anguleux, liseré rouge, numéro de maillot explicitement identifié et blason. Aucun score de jeu fictif.

```text
L’équipe                    Voir la convocation
Tous / Gardiens / Défenseurs / Milieux / Attaquants
Recherche                         Nombre de joueurs
Carte      Carte      Carte      Carte
Carte      Carte      Carte      Carte
```

La référence demande une collection de cartes de football : on conserve donc cette répétition utile, en évitant les panneaux et chiffres décoratifs autour. Les 26 joueurs sont repris du site public, vérifié le 5 novembre 2026 ; leurs noms restent abrégés. Une silhouette remplace les portraits absents. Le clic ouvre une fiche accessible et le composant de contenu sera partagé avec la convocation. Un filtre agit immédiatement sans déplacer le focus ; une recherche permet aussi d’atteindre un état sans résultat et de réinitialiser les critères.

### Matière et éclairage des cartes

À la demande du 5 novembre 2026, les cartes gagnent une ombre noire diffuse derrière leur découpe et une ombre elliptique sous leur pointe. Un reflet blanc diagonal évoque une surface plastifiée, dans la palette existante ; les textes et leur alignement restent identiques. Un passage lumineux répond au survol ou au focus clavier, sans animation en boucle. Sur téléphone et en réduction des animations, le reflet fixe conserve l’effet de matière. Ce choix prolonge précisément la référence de cartes de football et concentre l’effet sur leur surface.

## Convocation (bloc 4)

Palette et typographies existantes conservées. Le terrain est la pièce centrale : pelouse anthracite à bandes, lignes blanches atténuées en perspective et blason en haut à gauche. Les cartes restent droites pour lire les noms ; aucun texte de formation ni notation de jeu. Le rouge marque la carte sélectionnée. À droite, une fiche sobre reprend les informations connues ; sur téléphone, la même fiche s’ouvre dans la fenêtre existante.

```text
Convocation                    Cliquer sur une carte
Blason / terrain incliné        Portrait
       cartes                  Nom et poste
       cartes                  Informations
       gardien
Remplaçants
```

Le contraste avec la référence se limite aux couleurs du club et aux informations réelles : pas de statistiques de jeu ni de panneaux décoratifs. L’aperçu local utilise 14 joueurs de l’effectif, avec un placement illustratif explicitement signalé. La liste publique du 1er novembre ne permet pas de connaître les titulaires ; aucune composition officielle n’en est déduite. Hors environnement local, un état vide attend une publication réelle.

## Convocation : proportions de la référence (5 novembre 2026)

La nouvelle référence précise une scène large, avec de petites cartes séparées par beaucoup de terrain. La palette noir, rouge et blanc et les typographies existantes restent la base. Le titre devient plus discret, le contenu s’étend jusqu’à 1 760 pixels et la fiche occupe une colonne étroite alignée en haut. Les cartes prennent environ 8 % de la largeur du terrain ; leur dessin partagé apparaît agrandi au clic à droite, suivi des informations connues. Sur téléphone, cette carte apparaît dans la fenêtre existante.

```text
Convocation
Blason / grand terrain en perspective             Carte sélectionnée
          petites cartes espacées                 Nom et poste
                gardien                           Informations
Remplaçants
```

Relecture du brief : le panneau portrait rectangulaire et le terrain étroit du premier rendu ne respectaient pas suffisamment la référence. Ils sont remplacés par une scène plus horizontale et la véritable carte du joueur. Le dessin est extrait dans un composant partagé pour éviter sa duplication ; aucun score fictif n’est ajouté. La fiche attend un clic, conformément à la demande.
# Ajustement du 6 novembre 2026 : terrain et fiche à la demande

La palette et les polices existantes sont conservées. Au repos, le terrain occupe toute la largeur du conteneur avec des marges symétriques. La sélection ouvre une colonne de 210 pixels à droite ; une croix referme la fiche et restitue immédiatement cette largeur au terrain. Sur téléphone, la fenêtre partagée reste utilisée. Aucun panneau vide ni motif de signature sur l’accueil : le terrain et les cartes portent l’identité visuelle.


## 6 novembre 2026 : proportions communes des cartes

La carte Équipe sert de référence unique. Le dessin partagé possède son propre conteneur de mesure : textes, espacements, bordure et portrait suivent sa largeur, indépendamment de la page et de la taille de l’écran. Le terrain et la fiche ne modifient plus son agencement intérieur ; seule la largeur du composant varie. Les couleurs, ombres et reflets existants sont conservés.


## Administration du club

Palette existante : fond #101113, panneaux #191b20, rouge #e5092b, blanc #f7f7f8 et texte secondaire #b5b6bd. Impact pour les titres sportifs, police du thème pour les formulaires. Navigation secondaire partagée Joueurs / Convocation / Calendrier. Effectif sous forme de cartes existantes avec actions discrètes ; composition centrée sur le terrain partagé, choix du joueur puis placement par clic, coordonnées accessibles au clavier. Brouillon et publication distingués par des actions explicites ; réglages statistiques indépendants. Fenêtres, champs, menus et boutons partagés avec le calendrier. Sur téléphone, l’éditeur passe en une colonne.


## Sponsors : 6 novembre 2026

Quatre bannières de grande largeur, dans le cadre noir #101114, blanc #F7F7F8 et rouge #E5092B du club. Chaque marque conserve son logo fourni intact. Plan B : photographie de terrasse et cartouche blanc, typographie sobre. Snack51 : contraste blanc/noir, très grand 51 découpé et composition de brasserie contemporaine. Modern Sport : fond noir, rayons orange #FFAD24 et violet #7735C8 reprenant le logo. Someny : vert #36942F, blanc et tracé architectural. Impact pour les titres de la page ; police du site pour les coordonnées.

Composition : titre à gauche, puis quatre panneaux verticaux indépendants ; logo généreux à gauche et informations/actions à droite. Le Plan B intègre sa terrasse sur une moitié de la bannière. Sur téléphone, chaque panneau se replie en une colonne.

Relecture du brief : éviter quatre petites cartes identiques ; la bannière et la matière de chaque partenaire portent la différence. Un seul composant pilote les quatre variantes. Un éclairage traverse le panneau à son apparition et répond au survol/focus, sans boucle automatique ; réduction des animations respectée. Pas de slogan supplémentaire ni de statistiques commerciales.

Sources officielles consultées le 6 novembre 2026 : restaurantleplanb.fr/?lang=fr (Mirecourt, cuisine de saison, 3 rue Georges Clemenceau, 03 54 04 35 81) ; snack51.com (smash burgers, tacos, kebab, 6 rue Germini à Mirecourt, 03 29 29 52 34) ; someny.fr (rénovation énergétique, chauffage, climatisation, isolation, audit, 2 avenue Nelson Mandela à Tomblaine, 03 74 72 88 88). Les anciennes informations remontées par la recherche ont été écartées après lecture directe des sites actuels. Modern Sport : uniquement logo et signature Laxenaire & Fils fournis ; aucune activité, adresse ni URL inventée.


## Sponsors et Contact : ajustement du 6 novembre 2026

Suppression du balayage brillant au survol et au focus des bannières, animation d’entrée conservée. Invitation de partenariat en bas de page : texte demandé, accent rouge et bouton commun vers Contact. Palette existante (#101114, #17181B, #292B31, #B5B6BD, #F7F7F8, #E5092B), titres Impact et texte du site.

Contact : titre à gauche, adresse et téléphone en deux colonnes dans une même surface sobre ; sur mobile, adresse puis numéros. Les deux contacts sont des liens téléphoniques généreux, sans formulaire ni carte externe non demandés. Encadré d’appel à l’action et coordonnées sont des composants partagés. Cette présentation privilégie les informations fournies et leur utilisation immédiate.


## Réseaux : 6 novembre 2026

Palette commune : fond #101114, surface #17181B, structure #292B31, blanc #F7F7F8, texte #B5B6BD et rouge #E5092B. Titres Impact, texte courant hérité du site. Deux panneaux alignés en colonnes sur ordinateur, empilés sur téléphone : grand pictogramme de plateforme, nom, compte et action. Une nuance rouge pour Instagram et bleue pour Facebook distingue les profils dans le cadre du club. Le mouvement répond uniquement au survol ou au focus et respecte la réduction des animations.

Relecture du brief : les deux profils fournis sont le contenu utile ; aucune publication ni audience inventée. Un composant partagé porte les deux variantes et s’appuie sur le bouton shadcn-vue. Pas de flux externe chargé ni de balayage brillant.


## Actualités : 6 novembre 2026

Palette : fond #101114, surface #17181B, bordure #292B31, texte #B5B6BD, blanc #F7F7F8 et rouge #E5092B. Impact pour les titres et le score, police courante du site pour les textes. Alignement à gauche ; une actualité principale sur toute la largeur (résultat illustré à gauche, résumé à droite), puis deux colonnes d’articles. Sur téléphone, tout passe en une colonne.

Relecture du brief : le score réel du derby et le blason portent le visuel principal ; aucune photographie fictive ni décoration brillante. Le composant unique accepte une variante à la une et ouvre le texte intégral dans une fenêtre shadcn-vue, avec retour du focus au bouton et fermeture par Échap. Pas de filtres superflus pour six articles.

Contenu : les six articles visibles sur footballclubhymont.fr, rubrique Actualités, consultés le 6 novembre 2026. Titres, scores et faits conservés, orthographe et résumés adaptés. La source affiche le jour et le mois sans année : aucune année ajoutée.


## Administration complète — 6 novembre 2026
Palette conservée : fond #101114, panneau #17181b, bordure #292b31, texte #f7f7f8, secondaire #b5b6bd et rouge #e5092b. Titres Impact, texte Instrument Sans. Navigation partagée puis titre aligné à gauche, liste éditable et formulaire dans une fenêtre accessible. Les contacts et réseaux utilisent le même éditeur. Accueil administratif : liens explicites vers les sept rubriques, sans indicateurs artificiels. Sur mobile, navigation repliée naturellement et formulaires sur une colonne.
Relecture du brief : conserver les cartes existantes et les identités des sponsors ; aucune nouvelle décoration ni effet brillant. Les nouveaux contenus sont des brouillons par défaut et la publication est explicite.


## Convocation : emplacements fixes
- Conserver la palette et le terrain actuels, les onze positions aérées de l’aperçu. Réserver la couleur rouge à la place visée, le blanc discret aux places libres.
- Chaque carte peut rejoindre toute place, sans restriction de poste ; ajout sur la première place libre, échange si la cible est occupée.
- Le même dessin de carte suit directement le pointeur, sans retard ni animation automatique. Cible soulignée avant dépôt ; annulation hors cible ou par Échap.
- Sélection de place accessible au clavier dans le panneau ; interaction tactile, aucune nouvelle décoration ni dépendance. Les coordonnées libres disparaissent.
- Plan relu contre la demande : la grille de football existante sert de repère, aucun nouveau gabarit de page.
