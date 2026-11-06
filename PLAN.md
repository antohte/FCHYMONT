# Refonte du Football Club Hymont

## Cadre retenu

Laravel, Vue 3, Inertia et TypeScript, avec SQLite en local. Les composants shadcn-vue sont personnalisés et partagés entre les pages. Toutes les interventions suivent `AGENTS.md` et sont consignées dans `suivi.md`.

L'identité reprend le noir, le rouge et le blanc du club. Les références fournies guident les cartes et le terrain ; les visuels seront propres au FC Hymont. Les interactions mêlent retours discrets et transitions marquées, avec une version adaptée aux personnes qui réduisent les animations.

## Bloc 1 — Base du projet

- Initialiser Laravel et le frontend Vue avec Inertia et TypeScript.
- Créer les consignes de lecture préalable et de journalisation obligatoire.
- Imposer les composants réutilisables, fondés sur shadcn-vue.
- Configurer le français, le fuseau Europe/Paris et SQLite.
- Installer Laravel Boost et configurer son accès pour le développement sans écraser les règles locales.
- Vérifier le démarrage, les migrations, les tests Laravel, TypeScript, le lint et la compilation.

Validation : une installation locale fonctionnelle et des résultats réels consignés dans le journal. Un téléchargement bloqué ne vaut pas installation réussie.

État au 5 novembre 2026 : terminé. Installation, migrations, tests Laravel, contrôles frontend, lancement HTTP et serveur MCP Boost validés ; résultats détaillés dans `suivi.md`.

## Bloc 2 — Cadre commun et accueil

- Définir les couleurs, la typographie, les espacements et les comportements communs avant de construire les pages.
- Intégrer le logo fourni et une navigation adaptée au mobile.
- Créer un accueil dans le même univers que les cartes et le terrain, orienté vers Équipe et Convocation.
- Préparer les autres routes publiques avec un contenu vide ; ne pas inventer leurs sections.

Validation : accueil utilisable au clavier, sur téléphone et ordinateur ; composants communs effectivement réutilisés.

État au 5 novembre 2026 : terminé. Accueil, cadre partagé et navigation mobile réalisés ; contrôles frontend, tests Laravel et vérifications navigateur validés.

## Bloc 3 — Équipe

- Créer une carte joueur commune aux pages Équipe et Convocation.
- Présenter l'effectif en grille, selon la première référence fournie.
- Ajouter des boutons de filtre par poste et un état sans résultat.
- Afficher photo ou silhouette, nom disponible, poste, numéro et badge du club.
- Préparer le panneau de détail partagé avec la convocation.

Les noms abrégés et postes publics peuvent servir de base après vérification. Ne pas inventer de noms complets, d'âges, de portraits ou de statistiques.

Validation : filtres fonctionnels, grille responsive et mêmes composants dans les vues concernées.

État au 5 novembre 2026 : terminé. Effectif public de 26 joueurs importé, cartes et détail partagés disponibles, filtres et recherche vérifiés. Grille contrôlée de 320 à 1 280 pixels ; 30 tests Laravel, TypeScript, ESLint et compilation réussis. Les cartes et le détail sont également réutilisés dans le bloc 4. Les rubriques non développées conservent un contenu vide.

## Bloc 4 — Convocation

- Présenter une seule composition publique sur un terrain en perspective, selon la deuxième référence.
- Placer le logo du club en haut à gauche ; ne pas afficher de texte de formation.
- Afficher les titulaires sur le terrain et les remplaçants à proximité.
- Ouvrir le détail du joueur sélectionné à droite sur ordinateur et dans un panneau adapté sur mobile.
- Afficher la photo, le nom et le prénom lorsqu'ils sont connus, l'âge lorsqu'il est renseigné et le poste.
- Préparer les statistiques facultatives : buts pour les joueurs de champ et arrêts pour les gardiens.

Validation : sélection fonctionnelle, détail cohérent avec la carte et affichage utilisable sur petit écran.

État au 5 novembre 2026 : terminé. Terrain, remplaçants, fiche latérale et fenêtre mobile réalisés avec les composants partagés. Aperçu local explicitement illustratif, état vide sans publication ailleurs. Données de publication et statistiques facultatives préparées pour le bloc 5. Migration locale, 34 tests Laravel (196 assertions), TypeScript, ESLint, Pint ciblé, compilation et contrôles navigateur validés. Prochaine étape : administration.

## Bloc 5 — Administration

- Adapter l'authentification pour les gestionnaires du club et protéger les accès.
- Gérer les joueurs, leurs portraits et leurs informations depuis des formulaires réutilisables.
- Ajouter deux réglages globaux pour afficher les buts et les arrêts ; les désactiver par défaut.
- Permettre le placement libre des joueurs sur le terrain et le choix des remplaçants.
- Séparer le brouillon de la composition publiée.

Une seule convocation est prévue ; son historique reste hors périmètre. À la demande du 6 novembre, le calendrier public et sa gestion sont ajoutés : rencontres, lieux, horaires, résultats, reports, annulations et publication. La gestion des joueurs et des compositions est réalisée le 6 novembre 2026.

Validation : accès protégé, changements persistés, publication explicite et statistiques masquées lorsque leur réglage est désactivé.

État au 6 novembre 2026 : fonctionnalités du bloc 5 réalisées. Gestion des joueurs et portraits, réglages globaux, placement libre, remplaçants, brouillon, publication explicite et retrait disponibles. Import de 21 rencontres réelles réalisé sans doublons. Tests serveur : 50 réussis, 532 assertions. Sauvegardes joueur/brouillon et interface mobile contrôlées sur une base isolée. La confirmation finale de publication dans le navigateur reste à vérifier au bloc 6 : validation automatique de l’outil refusée ; publication et retrait validés par les tests Laravel. Ne pas considérer la vérification manuelle complète comme terminée.

Extension du 6 novembre 2026 : accueil `/admin` à sept rubriques, gestion persistante des actualités, sponsors, contacts et réseaux, compte administrateur local sur demande et retrait du cadenas public. Validation finale consignée dans `suivi.md`.

## Bloc 6 — Vérifications et livraison locale

- Contrôler les parcours publics et administratifs, les états vides et les erreurs de formulaire ; terminer notamment la confirmation de publication dans le navigateur.
- Vérifier clavier, focus, contraste, petits écrans et réduction des animations.
- Exécuter les tests pertinents et la compilation de production.
- Mettre à jour les instructions de lancement et le journal.

L'hébergement sera choisi ultérieurement. La livraison prévue à ce stade est locale.
