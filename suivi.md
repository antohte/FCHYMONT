# Suivi du projet FC Hymont

## Plan de réalisation

1. Base Laravel, consignes, journal et Laravel Boost.
2. Identité graphique, composants communs et accueil.
3. Effectif, cartes joueurs et filtres.
4. Terrain et convocation publique.
5. Administration des joueurs et de la composition.
6. Vérifications et livraison locale.

## 5 novembre 2026 — Bloc 1 — Initialisation en cours

- Objectif : initialiser Laravel + Vue + Inertia + TypeScript avec SQLite, puis installer Laravel Boost.
- Environnement vérifié : PHP 8.5, Composer 2.8, Node.js 24, npm 11 ; extensions SQLite présentes.
- Changements : création du projet depuis le starter kit officiel `laravel/vue-starter-kit` ; création de `AGENTS.md` et de ce journal.
- Frontend : le starter kit contient déjà les primitives shadcn-vue ; obligation de les réutiliser et de mutualiser les composants métier ajoutée aux consignes.
- Fichiers concernés : squelette du starter kit, `composer.lock`, `AGENTS.md`, `suivi.md`.
- Vérifications : prérequis disponibles ; installation des dépendances PHP en cours.
- Limites : accès réseau restreint ; première tentative Composer refusée par résolution DNS, relancée avec autorisation réseau. Certains téléchargements GitHub rencontrent encore des délais de résolution.
- État : bloc 1 en cours ; aucun autre bloc commencé.

## 5 novembre 2026 — Bloc 1 — Configuration locale

- Changements : nom FC Hymont, langue française, fuseau Europe/Paris et URL locale sur le port 8000 ; SQLite conservé. Option de serveur PHP multithread commentée pour Windows.
- Composants : correction des alias shadcn-vue vers `@/components` et `@/components/ui` pour respecter la casse réelle des dossiers.
- Vérifications préparées : commandes npm `typecheck` et `lint:check` sans réécriture des fichiers.
- Fichiers concernés : `config/app.php`, `.env.example`, `.env` local ignoré par Git, `components.json`, `package.json`, `suivi.md`.
- État : téléchargements PHP et JavaScript en cours ; contrôles finaux en attente.

## 5 novembre 2026 — Bloc 1 — Démarrage et documentation

- Changements : identité Composer du projet ; adaptation de `composer run dev` à Windows en retirant Pail de la commande ; documentation française d'installation, de démarrage et de vérification.
- Fichiers concernés : `composer.json`, `README.md`, `suivi.md`.
- Vérifications : scripts relus ; exécution en attente de l'installation des dépendances.
- Compatibilité : le starter kit stable publié sélectionné par Composer utilise Laravel 12 et Inertia 2 ; aucune version majeure plus récente n'a été imposée au projet.

## 5 novembre 2026 — Bloc 1 — Corrections du starter kit

- Installation npm réussie après relance avec accès réseau.
- Contrôles initiaux : TypeScript échoue sur deux références de types invalides du starter kit ; compilation échoue sur un import Ziggy pointant vers un mauvais chemin relatif.
- Corrections : import depuis le paquet `ziggy-js`, résolution de ses types dans `node_modules`, retrait des entrées de types inexistantes et nom de repli FC Hymont.
- Fichiers concernés : `resources/js/app.ts`, `tsconfig.json`, `package-lock.json`, `suivi.md`.
- Audit initial : 30 alertes npm ; mise à jour compatible des dépendances prévue avant validation.

## 5 novembre 2026 — Bloc 1 — Vérification frontend

- Compilation Vite et ESLint réussis après mise à jour compatible des dépendances npm.
- Audit après correction : aucune alerte élevée ou critique ; 14 alertes faibles ou modérées restent signalées et doivent être réévaluées.
- TypeScript a révélé des incohérences supplémentaires du starter kit : déclaration globale Vite, données Inertia, navigation `url`/`href`, propriétés facultatives et types des liens.
- Corrections dans les composants partagés, les types et les pages du starter kit pour permettre un contrôle strict sans désactiver les vérifications.
- Fichiers concernés : `resources/js/app.ts`, `resources/js/types/index.ts`, composants de navigation et d'utilisateur, `TextLink.vue`, layout d'authentification, pages d'authentification et d'accueil, `package-lock.json`, `suivi.md`.
- État : contrôles à relancer ; installation PHP toujours en cours.

## 5 novembre 2026 — Bloc 1 — Types Vite

- Retrait de la redéclaration de `import.meta.glob` : les types natifs de Vite assurent déjà ce contrat et entraient en conflit avec ceux du starter kit.
- Fichiers concernés : `resources/js/app.ts`, `suivi.md`.
- ESLint passe après les corrections précédentes ; contrôle TypeScript à relancer.

## 5 novembre 2026 — Bloc 1 — Frontend validé et reprise Composer

- Vérifications réussies : `npm run typecheck`, `npm run lint:check` et `npm run build` ; syntaxe PHP de `config/app.php` valide.
- Installation PHP : arrêt de la tentative bloquée sur les archives GitHub, puis reprise avec `composer install --prefer-source`, en conservant les dépendances déjà récupérées.
- Fichiers concernés : dépendances générées et `suivi.md`.
- État : installation PHP et Laravel Boost à terminer ; bloc 1 toujours en cours.

## 5 novembre 2026 — Bloc 1 — Plan détaillé

- Création de `PLAN.md` pour conserver le périmètre et les critères de validation des six blocs : accueil, cartes partagées, filtres, terrain, détail joueur, administration et livraison locale.
- Fichiers concernés : `PLAN.md`, `suivi.md`.
- Vérification : cohérence avec les références et demandes exprimées ; aucun bloc visuel commencé.

## 5 novembre 2026 — Bloc 1 — Dépendance Laravel Boost

- Ajout de `laravel/boost` en dépendance de développement, contrainte `^2.10`, avec résolution réussie vers la version 2.10.4.
- Verrouillage de Boost, Laravel MCP, Laravel Roster et Composer Semver dans `composer.lock` ; aucune alerte de sécurité Composer signalée.
- Fichiers concernés : `composer.json`, `composer.lock`, `suivi.md`.
- Vérification : `composer validate --no-check-publish` réussit.
- Limite : le paquet est déclaré et verrouillé, mais son installation et sa configuration MCP ne sont pas encore réalisées. La reprise précédente a été interrompue après plusieurs échecs DNS GitHub confirmés par un diagnostic séparé.

## 5 novembre 2026 — Bloc 1 — État de reprise

- Dernière tentative `composer install --prefer-dist` : nouveaux échecs de résolution de `api.github.com`, puis arrêt de la tentative ; aucun processus d'installation laissé actif.
- Vérifications réussies : types TypeScript, ESLint, compilation Vite, validation Composer, exigences PHP/extensions du fichier de verrouillage et syntaxe de `config/app.php`.
- Vérifications impossibles : migrations, tests Laravel, démarrage HTTP et serveur MCP Boost ; `vendor/autoload.php` n'a pas été généré. La clé locale et la base restent à initialiser après installation PHP.
- Documentation : minimum PHP corrigé en 8.4.1 selon les dépendances verrouillées ; procédure de reprise et statut Boost ajoutés au README.
- Audit npm : 14 alertes restantes, une faible et treize modérées ; aucune élevée ou critique au dernier audit.
- Fichiers concernés : `README.md`, `suivi.md` et fichiers générés de dépendances.
- État : bloc 1 partiellement réalisé, bloqué par l'accès DNS à GitHub. Ne pas le considérer comme terminé. Prochaine étape : terminer Composer, configurer Boost en préservant les règles, initialiser Laravel puis vérifier ses tests et son démarrage avant le bloc 2.

## 5 novembre 2026 — Bloc 1 — Nouvelle tentative demandée

- Relance de `composer install --prefer-dist --no-interaction --no-progress` avec accès réseau autorisé.
- Résultat : échec persistant des téléchargements, erreur cURL 28 « Resolving timed out » sur `api.github.com` ; les contrôles directs de `github.com` et `api.github.com` échouent également après cinq secondes.
- Tentative interrompue pour éviter de répéter les mêmes délais ; aucun processus de téléchargement laissé actif.
- Fichiers concernés : dépendances partielles dans `vendor` et `suivi.md`. Aucune modification de l'application.
- État : installation PHP et configuration Boost toujours bloquées ; bloc 1 non terminé.

## 5 novembre 2026 — Bloc 1 — Reprise après rétablissement réseau

- Nouvelle installation demandée après retour de l'accès au site GitHub dans le navigateur.
- Diagnostic : les commandes rencontrent encore des délais DNS sur l'API ; HTTPS fonctionne avec l'adresse officielle obtenue auprès du DNS public.
- Reprise de Composer par Git avec `http.curloptResolve` transmis uniquement au processus d'installation. Aucune modification des serveurs DNS, du fichier hosts ou de la vérification TLS.
- Création de fichiers temporaires de diagnostic dans `vendor/composer`, dossier ignoré par Git ; écriture PHP vérifiée.
- Fichiers concernés : dépendances générées dans `vendor` et `suivi.md`.
- État : installation en cours ; initialisation Laravel et configuration Boost à suivre.

## 5 novembre 2026 — Bloc 1 — Préparation de Boost

- Ajout de `boost.json` pour sélectionner explicitement Codex ; configuration MCP à générer avec l'installateur officiel après installation des dépendances.
- Ajout aux consignes de l'utilisation du serveur `laravel-boost` pour les versions et la documentation du projet.
- Les consignes locales françaises restent la référence ; installation ciblée du serveur MCP prévue, sans génération de consignes supplémentaires.
- Fichiers concernés : `boost.json`, `AGENTS.md`, `suivi.md`.
- Vérification : options et comportement de l'installateur relus dans les sources officielles de Boost 2.10.4.

## 5 novembre 2026 — Bloc 1 — Dépendances PHP installées

- Installation des 118 paquets verrouillés ; récupération de Mockery 1.6.15 par son archive officielle après échec du clonage Git. Aucun changement de version nécessaire.
- Finalisation locale avec le réseau désactivé pour Composer après un délai persistant ; autoload généré et découverte des paquets Laravel effectuée.
- Fichiers concernés : `vendor` et cache Composer, non versionnés, puis `suivi.md`.
- Points révélés : constantes PDO du starter kit dépréciées sous PHP 8.5 et classes en double dans les sources de Flysystem/Pint. Corrections ciblées à réaliser avant les vérifications finales.

## 5 novembre 2026 — Bloc 1 — Laravel et Boost configurés

- Initialisation de la clé locale et de SQLite ; trois migrations exécutées avec succès.
- Compatibilité PHP : utilisation des constantes spécifiques à PDO MySQL à partir de PHP 8.4, avec repli pour les versions antérieures.
- Autoload : exclusion des classes du projet Pint et de la copie locale Flysystem livrées dans leurs dépôts source ; génération sans ambiguïté de 7 152 classes.
- Installation officielle de Boost 2.10.4 avec `boost:install --mcp --no-interaction` pour Codex. Création de `.codex/config.toml` et mise à jour de `boost.json` ; `AGENTS.md` conservé.
- Fichiers concernés : `config/database.php`, `composer.json`, `boost.json`, `.codex/config.toml`, fichiers locaux ignorés `.env`, SQLite, caches et autoload, puis `suivi.md`.
- Vérifications : migrations, découverte des paquets et validation Composer réussies. Tests Laravel, HTTP et protocole MCP à vérifier avant clôture.

## 5 novembre 2026 — Bloc 1 — Terminé

- Base fonctionnelle : Laravel 12.71.0, Vue 3, Inertia 2, TypeScript, SQLite et composants shadcn-vue disponibles. Lecture préalable et journalisation obligatoires définies dans `AGENTS.md`.
- Tests Laravel : 27 réussis, 64 assertions ; base de test en mémoire, séparée de la base locale.
- Contrôles frontend déjà réussis : `npm run typecheck`, `npm run lint:check`, `npm run build`. Validation Composer et `git diff --check` réussis.
- Démarrage réel avec `composer run dev` : Laravel sur le port 8000, file de tâches et Vite sur le port 5173. Réponses HTTP 200 pour `/`, `/up` et `/@vite/client` sur leurs serveurs respectifs ; langue française et titre FC Hymont vérifiés dans le HTML.
- Boost : négociation MCP réussie, neuf outils listés dont `search-docs`, lecture de la ressource d'information confirmant Laravel 12.71.0 et SQLite. Configuration Codex générée ; un rechargement du projet peut être nécessaire pour la session ouverte.
- Arrêt des serveurs de vérification ; absence d'écoute sur les ports utilisés contrôlée et suppression du fichier temporaire `public/hot` laissé après l'arrêt sous Windows.
- Documentation : statut réel de Boost, commande de régénération MCP et résultats ajoutés au README ; bloc 1 marqué terminé dans le plan.
- Fichiers concernés : `README.md`, `PLAN.md`, fichiers locaux de test/cache ignorés, `public/hot` temporaire et `suivi.md`.
- Limite connue : dernier audit npm à 14 alertes, une faible et treize modérées ; aucune élevée ou critique. Résolution complète à traiter sans imposer une migration majeure non vérifiée.
- État : bloc 1 terminé ; bloc 2 (cadre commun et accueil) prêt à commencer, aucun design de page du club encore réalisé.

## 5 novembre 2026 — Bloc 2 — Construction de l’accueil

- Lecture des règles, du journal, du plan et des skills frontend-design et french-language ; documentation Inertia 2 consultée avec Laravel Boost pour les pages, titres et routes.
- Direction définie dans `DESIGN.md` : carte du véritable blason, terrain graphique en perspective, titres sportifs et palette noire, rouge et blanche.
- Cadre `ClubLayout` et composants partagés dans `resources/js/components/club` : identité, navigation mobile dépliable, actions shadcn-vue, carte, terrain et accès aux rubriques.
- Accueil du starter kit remplacé ; routes Équipe, Convocation, Le club et Contact préparées avec contenu vide et titres accessibles masqués.
- Fichiers concernés : `DESIGN.md`, composants du club, `ClubLayout.vue`, `Welcome.vue`, `ClubPlaceholder.vue`, `club-navigation.ts`, `resources/css/club.css`, `resources/css/app.css`, `resources/js/app.ts`, `routes/web.php`, logo dans `public/images` et `suivi.md`.
- Aucune identité de joueur, statistique ou rencontre inventée ; blocs 3 et 4 non commencés.
- Vérifications à effectuer : types, lint, compilation, tests Laravel et contrôle visuel sur ordinateur et téléphone. Bloc 2 en cours.

## 5 novembre 2026 — Bloc 2 — Premiers contrôles

- TypeScript et ESLint réussis. Première compilation terminée, mais avertissement PostCSS : déplacement de l’import du thème dans `app.ts` pour garantir son inclusion après les styles de base.
- Mise en forme ciblée des nouveaux fichiers prévue avec Prettier ; aucune nouvelle dépendance.
- Tests Laravel : le processus de test ne peut pas ouvrir `vendor/autoload.php`, pourtant présent. Relance hors bac à sable prévue pour distinguer une restriction d’accès d’une erreur de l’application.
- Fichiers concernés : `resources/css/app.css`, `resources/js/app.ts`, fichiers frontend du bloc 2 et `suivi.md`. Vérification visuelle encore en attente.

## 5 novembre 2026 — Bloc 2 — Contrôle visuel et ajustements mobiles

- Tests Laravel relancés hors bac à sable : 27 réussis, 64 assertions. Compilation après correction de l’import CSS réussie sans avertissement ; nouveaux fichiers mis en forme avec Prettier.
- Contrôle navigateur à 1 280 et 390 pixels : logo chargé, accueil lisible, aucun débordement horizontal ni erreur de console. Navigation vers Équipe et Convocation vérifiée ; menu mobile utilisable au clavier et fermé par Échap ou après navigation.
- Ajustements à 320 pixels : réduction du titre pour conserver deux lignes ; bouton du menu porté à 44 pixels pour faciliter son utilisation tactile.
- Fichiers concernés : `resources/css/club.css`, fichiers frontend mis en forme et `suivi.md`.
- Dernier contrôle visuel, vérifications frontend et documentation de clôture encore à effectuer.

## 5 novembre 2026 — Bloc 2 — Terminé

- Accueil et cadre commun finalisés : véritable blason sur carte, terrain décoratif, actions partagées, navigation active, menu mobile et pied de page. Autres rubriques sans contenu visible, comme demandé.
- Vérifications finales réussies : `npm run typecheck`, `npm run lint:check`, `npm run build` sans avertissement et `git diff --check`. Tests Laravel : 27 réussis, 64 assertions, après relance hors bac à sable pour l’accès à l’autoload.
- Navigateur : rendu contrôlé à 320, 390, 768 et 1 280 pixels ; titre corrigé sur deux lignes à 320 pixels, images chargées et aucun débordement horizontal aux largeurs mesurées. Aucun avertissement ni erreur de console sur l’accueil.
- Parcours : quatre rubriques accessibles, lien actif annoncé par `aria-current`, rechargement direct de la page Le club réussi ; Échap et navigation referment le menu mobile. Le lien « Aller au contenu » place effectivement le focus sur le contenu.
- Réduction des animations prévue par la feuille de style ; préférence système non modifiée pendant les contrôles. Aucun effectif ni résultat fictif ajouté.
- Documentation : `PLAN.md` et `README.md` mis à jour. Capture de l’accueil enregistrée dans le dossier de visualisations Codex, hors des sources. Dimensions temporaires du navigateur rétablies.
- Fichiers concernés : `PLAN.md`, `README.md`, `suivi.md` ; sources détaillées dans les entrées précédentes.
- Serveur local conservé sur le port 8000 pour permettre l’aperçu de la compilation de production. Pour reprendre le développement interactif, utiliser les commandes du README.
- État : bloc 2 terminé ; bloc 3 (effectif, cartes et filtres) à réaliser ensuite.

## 5 novembre 2026 : bloc 3, données de l’effectif

- Règles et skills relus ; documentation Inertia et Laravel consultée via Boost. Direction de la page Équipe ajoutée à `DESIGN.md` et confrontée à la grille de référence.
- Site public consulté dans le navigateur : 26 noms abrégés, postes et numéros vérifiés. Aucun portrait, âge, nom complet ou résultat inventé. Source : https://footballclubhymont.fr/, rubrique Équipe, consultée le 5 novembre 2026.
- Ajout du modèle Player, de l’énumération des quatre familles de postes, d’une migration et du contrôleur public. Seuls les joueurs publiés et les champs publics explicitement sélectionnés sont transmis ; date de naissance non exposée.
- Import initial `ClubRosterSeeder` non destructif et relançable, sans doublon ni écrasement de modifications ultérieures. Import volontairement séparé du seeder du starter kit pour éviter la création d’un compte de test.
- Tests ajoutés : effectif vide, exclusion des brouillons et champs internes, absence de données inconnues et import relançable.
- Fichiers concernés : `DESIGN.md`, `app/Enums/PlayerPosition.php`, `app/Models/Player.php`, `app/Http/Controllers/TeamController.php`, migration des joueurs, `database/seeders/ClubRosterSeeder.php`, `routes/web.php`, `tests/Feature/TeamTest.php`, `suivi.md`.
- État : bloc 3 en cours ; interface, migration locale et vérifications à réaliser.

## 5 novembre 2026 — Bloc 3 — Interface de l’effectif

- Création de la page Équipe : grille de cartes inspirées de la référence, filtres par poste avec compteurs, recherche insensible aux accents et états vides.
- Composants réutilisables : PlayerCard, PlayerPortrait, PlayerDetails, PlayerDetailsDialog, ClubPositionFilters, ClubSearchField et ClubEmptyState ; contrat TypeScript commun dans types/player.ts.
- Cartes à bordure angulaire rouge et métallique, numéro explicitement présenté comme un numéro de maillot, silhouette lorsque le portrait manque et repli en cas d’image indisponible. Aucun score ou résultat inventé.
- Fiche en fenêtre shadcn-vue, fermeture par Échap et restitution du focus prévues ; détail indépendant pour réutilisation dans le bloc 4. Libellé de fermeture de la primitive traduit et cible tactile agrandie.
- Styles adaptés aux grilles de quatre, trois et deux colonnes, au clavier et à la réduction des animations ; feuille team.css importée dans app.ts. Mise en forme Prettier ciblée.
- Fichiers concernés : composants et types ci-dessus, Team.vue, team.css, app.ts, DialogContent.vue et suivi.md.
- État : interface implémentée ; résultats des migrations et contrôles consignés après vérification.

## 5 novembre 2026 — Bloc 3 — Terminé

- Migration locale exécutée et import des 26 joueurs réussi, sans création de compte ni réinitialisation de la base. Aucune dépendance ajoutée.
- Contrôles réussis : TypeScript, ESLint, compilation Vite sans avertissement, Pint sur les nouveaux fichiers PHP et la route, et git diff --check. Tests Laravel : 30 réussis, 107 assertions, dont trois tests de l’effectif.
- Incidents de vérification résolus : accès à l’autoload refusé dans le bac à sable, tests relancés avec autorisation ; premier contrôle concurrent à la compilation échoué temporairement sur le manifeste Vite absent. Relance séquentielle après compilation entièrement réussie, sans modification des tests pour masquer l’erreur.
- Navigateur : filtres validés pour les quatre postes (1, 10, 7 et 8 joueurs), recherche « leo » retrouvant Léo, recherche sans résultat et réinitialisation vers les 26 joueurs. Ouverture par Entrée, fermeture par Échap et bouton Fermer, restitution du focus à la carte, menu mobile contrôlés.
- Rendu contrôlé à 320, 390, 768 et 1 280 pixels : grilles de deux, trois et quatre colonnes, aucun débordement horizontal mesuré ; fenêtre à 320 pixels entièrement contenue. Aucun avertissement ou erreur de console. Réduction des animations définie en CSS ; préférence système non modifiée pendant le contrôle.
- Documentation : PLAN.md et README.md actualisés, commande d’import initial et ordre de compilation/tests précisés. Capture equipe-fc-hymont.jpg enregistrée dans le dossier de visualisations Codex, hors des sources ; dimensions temporaires du navigateur rétablies.
- Limites : les portraits, noms complets et âges restent à renseigner via le futur panneau ; statistiques absentes. Cartes et détail prêts à être réutilisés dans le bloc 4. Serveur d’aperçu conservé sur le port 8000.
- Fichiers concernés : README.md, PLAN.md, suivi.md, base SQLite locale ignorée ; sources du bloc décrites dans les deux entrées précédentes.
- État : bloc 3 terminé. Prochaine étape : bloc 4, terrain et convocation.

## 5 novembre 2026 — Bloc 3 — Ombres et brillance des cartes

- Demande : renforcer le relief derrière et sous les cartes, puis ajouter un reflet lumineux sur leur surface. Compétence frontend-design appliquée ; choix de matière ajouté à DESIGN.md.
- Ajout d’une enveloppe visuelle commune à PlayerCard : ombres portées hors de la découpe, ombre elliptique sous la pointe et reflet diagonal fixe. Passage lumineux au survol précis ou au focus clavier, sans boucle et désactivé en réduction des animations.
- Effets mutualisés pour toutes les cartes, y compris leur future réutilisation ; éléments décoratifs masqués aux lecteurs d’écran et sans interception des clics. Aucune dépendance ajoutée.
- Fichiers concernés : PlayerCard.vue, team.css, DESIGN.md et suivi.md. Mise en forme et compilation à vérifier, puis contrôle visuel sur ordinateur et téléphone.

## 5 novembre 2026 — Bloc 3 — Vérification des ombres et reflets

- Vérifications réussies : mise en forme Prettier ciblée, TypeScript, ESLint et compilation Vite sans avertissement.
- Contrôle navigateur à 1 280 et 320 pixels : ombres hors de la découpe et reflet fixe présents sur les 26 cartes ; aucun débordement horizontal mesuré. Noms et postes restent lisibles sur ordinateur.
- Focus clavier vérifié sur la première carte avec transition lumineuse de 0,95 seconde ; ouverture de la fiche par Entrée et fermeture par Échap réussies. Aucun avertissement ni erreur de console relevé.
- Réduction des animations prévue en CSS ; préférence système non modifiée pendant le contrôle. Aucun code PHP changé, tests Laravel non relancés pour cette retouche visuelle.
- Capture cartes-reflets-fc-hymont.jpg enregistrée dans le dossier de visualisations Codex ; dimensions temporaires du navigateur rétablies. Fichiers de cette vérification : suivi.md et capture hors des sources.

## 5 novembre 2026 : navigation du site d’origine

- Suppression du lien Voir la convocation sur la page Équipe et de son import inutilisé.
- Menu public vérifié sur le site d’origine : Accueil, Actualités, Équipe, Calendrier, Sponsors, Convocation, Réseaux, Contact et accès administrateur. Reprise dans la navigation partagée, accents français conservés ; retrait de Le club du menu uniquement.
- Pages vides ajoutées pour les quatre nouvelles rubriques avec le composant existant ; accès administrateur relié à la connexion Laravel existante. Bascule vers le menu repliable à 1 100 pixels pour accueillir toutes les rubriques.
- Documentation Laravel consultée via Boost. Fichiers : Team.vue, club-navigation.ts, ClubNavigation.vue, club.css, routes/web.php et suivi.md. Vérifications en cours.

- Ajustement de la cascade CSS : règles du header regroupées en fin de feuille pour garantir la visibilité du menu repliable entre 800 et 1 100 pixels. Vérifications à suivre.

## 5 novembre 2026 : navigation vérifiée

- TypeScript, ESLint, compilation Vite, Pint sur routes/web.php et git diff --check réussis. Toutes les nouvelles rubriques et la connexion répondent HTTP 200 ; requêtes locales relancées avec autorisation après refus des sockets dans le bac à sable.
- Navigateur : les huit rubriques et le cadenas apparaissent sur ordinateur à 1 280 pixels ; bouton de convocation absent du titre Équipe. Menu repliable contrôlé à 1 051 et 390 pixels, sans débordement horizontal mesuré aux largeurs 1 280 et 390 pixels.
- Ouverture du menu mobile, navigation vers Actualités et fermeture automatique confirmées ; page Actualités vide et titre correct. Retour sur Équipe et dimensions temporaires rétablies.
- Capture header-equipe.jpg enregistrée hors des sources dans le dossier de visualisations Codex. Fichier de clôture : suivi.md. Aucune nouvelle dépendance ni modification de données.

## 5 novembre 2026 : bloc 4, données de la convocation

- Consignes et compétences frontend-design et french-language relues ; documentation des casts et migrations consultée avec Boost. Direction du terrain décrite dans DESIGN.md.
- Source consultée : la rubrique Convocation présente 14 joueurs pour le 1er novembre, sans titulaires ni placement. Aucun placement officiel inventé : aperçu illustratif limité au développement local et signalé dans l’interface ; état vide ailleurs en l’absence de publication.
- Modèle Selection et migration : placements libres, remplaçants, état brouillon/publication et date de publication. Préparation des totaux buts/arrêts nullables et de leurs deux réglages désactivés par défaut, sans interface de gestion à ce stade.
- Contrôleur public : dernière publication effective uniquement, joueurs publiés, champs explicitement exposés, doublons écartés, coordonnées bornées et statistiques exclues sans activation.
- Fichiers : migration create_selections_table, Selection.php, Player.php, SelectionController.php, config/selection.php, routes/web.php, DESIGN.md et suivi.md.
- Interface et vérifications à réaliser ; bloc 4 en cours.

## 5 novembre 2026 : bloc 4, terrain et sélection

- Page Convocation construite : terrain anthracite en perspective, tracés existants réutilisés, blason en haut à gauche, cartes droites et remplaçants sous le terrain. Aucun texte de formation.
- PlayerCard enrichi d’une variante compacte conservant les ombres et reflets. Sélection annoncée et fiche partagée à droite sur ordinateur ; fenêtre shadcn-vue existante sur mobile avec retour du focus.
- Détail enrichi d’une statistique facultative, uniquement si le serveur la transmet. Noms complets, portraits, âges et totaux inconnus restent absents.
- Fichiers : Selection.vue, SelectionPitch.vue, PlayerCard.vue, PlayerDetails.vue, types/player.ts, selection.css, app.ts et suivi.md. Aucune dépendance ajoutée.
- Vérifications et migration locale à effectuer.

## 5 novembre 2026 : bloc 4, couverture des données publiques

- Ajout de quatre tests : absence de publication effective, aperçu explicite avec 14 joueurs, filtrage des joueurs/doublons et coordonnées, réglages indépendants buts/arrêts avec valeur zéro conservée.
- Mise en forme ciblée du frontend effectuée ; contrôles types et lint lancés.
- Fichiers : tests/Feature/SelectionTest.php, fichiers frontend mis en forme et suivi.md. Résultats finaux et contrôle navigateur en attente.

## 5 novembre 2026 : bloc 4, premiers résultats et ajustement visuel

- Migration locale réussie ; aucun joueur ni compte modifié. TypeScript, ESLint, compilation sans avertissement et Pint ciblé réussis. 34 tests Laravel passent, 196 assertions ; relance autorisée hors bac à sable après refus d’accès à l’autoload.
- Navigateur : sélection du gardien à droite et ouverture de la fiche mobile validées ; pas de débordement à 320 pixels. Ajustement de la perspective pour prolonger le terrain derrière les attaquants, avec option d’étirement ajoutée au composant de tracés existant.
- Fichiers : PitchLines.vue, SelectionPitch.vue, selection.css et suivi.md. Mise en forme et derniers contrôles visuels à effectuer.

## 5 novembre 2026 : bloc 4 terminé

- Après ajustement du terrain : mise en forme, TypeScript, ESLint et compilation Vite réussis sans avertissement. Tests Laravel : 34 réussis, 196 assertions ; Pint ciblé réussi.
- Navigateur : sélection du gardien et d’un remplaçant, fiche à droite sur ordinateur, ouverture par Entrée sur mobile, fermeture par Échap et retour du focus validés. Fenêtre contenue à 320 pixels (288 pixels de large). Aucun débordement horizontal mesuré à 320, 768 et 1 280 pixels ; aucune erreur ni alerte de console relevée.
- Régression du composant partagé : ouverture au clavier de la fiche Léo B depuis Équipe confirmée. Réduction des animations prévue en CSS ; préférence système non modifiée pendant le contrôle.
- Documentation README.md et PLAN.md actualisée. Capture convocation-fc-hymont.jpg enregistrée hors des sources dans le dossier de visualisations Codex.
- Limites : placement et remplaçants illustratifs, signalés dans l’aperçu local ; aucune convocation officielle créée. Données inconnues conservées absentes, statistiques désactivées par défaut. Gestion et publication à réaliser au bloc 5.
- Fichiers de clôture : README.md, PLAN.md et suivi.md. Aucune dépendance ajoutée ; serveur d’aperçu conservé sur le port 8000.

## 5 novembre 2026 : convocation plus aérée et carte sélectionnée

- Demande : reprendre les proportions du nouveau visuel, agrandir le terrain et espacer les cartes ; afficher la carte du joueur à droite après un clic. Compétences frontend-design et french-language appliquées.
- Conteneur élargi, titre réduit, terrain plus horizontal et cartes proportionnellement plus petites. Fiche latérale plus étroite, alignée en haut, sans sélection automatique.
- Dessin extrait dans PlayerCardArtwork, réutilisé par PlayerCard et la variante carte de PlayerDetails. Fenêtre mobile partagée enrichie de la même variante ; présentation de l’Équipe conservée par défaut.
- Fichiers : composants PlayerCardArtwork, PlayerCard, PlayerDetails et PlayerDetailsDialog, Selection.vue, selection.css, DESIGN.md et suivi.md. Aucune dépendance ni donnée modifiée.
- Mise en forme, vérification TypeScript, lint et compilation réussis. Première vérification visuelle : carte sélectionnée correctement affichée à droite et joueurs plus espacés.

## 5 novembre 2026 : cadrage final du terrain

- Extension du haut de la surface en perspective pour maintenir le terrain derrière les attaquants.
- Vérification finale des proportions et de la fiche sur ordinateur et téléphone à effectuer.
## 6 novembre 2026 : terrain pleine largeur et fiche refermable

- Terrain centré sur toute la largeur disponible sans sélection ; colonne latérale créée uniquement après sélection sur ordinateur, fermeture par bouton partagé shadcn-vue et touche Échap depuis la fiche, avec retour du focus à la carte. Fermeture mobile effaçant également la sélection.
- Suppression du message d’aperçu, du texte « Nos couleurs. Notre club. » dans le pied de page et de la signature « Rouge. Noir. Blanc. » avec ses trois bandes sur l’accueil.
- Fichiers : Selection.vue, selection.css, Welcome.vue, ClubLayout.vue, DESIGN.md et suivi.md. Aucune modification des données ni dépendance.
- Vérifications réussies : mise en forme Prettier ciblée, TypeScript, ESLint, compilation Vite sans avertissement et git diff --check. Aucun code PHP modifié ; tests Laravel non relancés pour cette retouche frontend.
- Limite : la dernière tentative de contrôle navigateur a été refusée par la revue automatique pour limite d’utilisation ; contrôle visuel final non effectué et aucune nouvelle capture produite.

## 6 novembre 2026 : texte de convocation et blason des cartes

- Suppression de la phrase « Sélectionnez une carte pour découvrir le joueur. » dans Selection.vue.
- Découpe CSS du blason suivant son contour dans team.css : fond noir extérieur masqué, position et dimensions conservées sur toutes les cartes partagées, y compris la fiche agrandie. Noir intérieur du blason préservé.
- Compétences frontend-design et french-language appliquées. Aucune dépendance ni image source modifiée.
- Mise en forme Prettier ciblée, compilation Vite sans avertissement et git diff --check réussis. Contrôle visuel navigateur indisponible depuis le refus de revue automatique pour limite d’utilisation.

## 6 novembre 2026 : proportions identiques des cartes joueurs

- Correction demandée après comparaison des cartes Équipe, terrain et fiche sélectionnée. Le balisage était partagé, mais des surcharges de la variante terrain et des tailles liées à la fenêtre modifiaient le dessin.
- Suppression des surcharges internes et des exceptions mobiles ; typographie, marges, bordure et texture désormais proportionnelles à la largeur du dessin partagé, avec la carte Équipe comme référence. Poste conservé à toutes les tailles.
- Positionnement du portrait rattaché au dessin lui-même : il fonctionne aussi dans PlayerDetails sans dépendre du bouton PlayerCard. Retrait de la classe de variante terrain de cette fiche.
- Fichiers : resources/css/team.css, resources/css/selection.css, resources/js/components/club/PlayerDetails.vue, DESIGN.md et suivi.md. Aucune dépendance ni donnée modifiée.
- Vérifications réussies : Prettier ciblé, TypeScript, ESLint, compilation Vite sans avertissement et git diff --check. Aucun changement PHP ; tests Laravel non relancés.
- Limite : comparaison visuelle finale non effectuée ; contrôle navigateur indisponible depuis le refus de revue automatique pour limite d’utilisation signalé précédemment.

## 6 novembre 2026 : cartes du terrain agrandies

- Demande : agrandir légèrement les cartes de la convocation en conservant de bons espacements. Compétences frontend-design et french-language appliquées.
- Largeurs augmentées selon la place disponible : maximum de 108 px au lieu de 92 sur ordinateur, de 88 au lieu de 74 entre 901 et 1 100 px, et de 76 au lieu de 72 sur téléphone. Hauteur du terrain adaptée pour espacer verticalement les lignes. Dessin intérieur partagé inchangé.
- Fichier frontend : resources/css/selection.css ; journal : suivi.md. Aucune dépendance ni donnée modifiée.
- Vérifications : calcul des rectangles des onze placements actuels pour chaque largeur de 320 à 1 920 px, avec et sans fiche (3 202 configurations). Aucun dépassement ni chevauchement calculé, avec marge verticale pour le déplacement au survol. Deux espacements trop justes détectés lors des premiers calculs puis corrigés. Ce contrôle théorique ne remplace pas un contrôle navigateur et ne couvre pas de futurs placements personnalisés.
- Prettier ciblé et compilation Vite réussis sans avertissement. Contrôle visuel navigateur non effectué, accès précédemment refusé par la revue automatique pour limite d’utilisation.

## 6 novembre 2026 : calendrier, données et accès

- Direction du calendrier ajoutée à DESIGN.md. Modèle Fixture, migration additive des rencontres et rôle administrateur, contrôleurs public et gestion, validation, routes et autorisation dédiées.
- Brouillons exclus des données publiques ; scores obligatoires uniquement pour un match terminé. Aucun match ni compte inventé.
- Commande club:admin pour accorder ou retirer le rôle à un compte existant ; rôle exclu des champs librement assignables.
- Fichiers : DESIGN.md, migration create_fixtures_table, Fixture.php, FixtureRequest.php, contrôleurs CalendarController, User.php, AppServiceProvider.php, routes/web.php, routes/console.php et suivi.md.
- Documentation Boost consultée. Interface, tests et migration locale à effectuer.

## 6 novembre 2026 : calendrier, interfaces partagées

- Page publique mensuelle, prochain match, sélection d’un jour et filtres ; état vide sans rencontres inventées. Dates civiles formatées sans décalage UTC et horaires de Paris.
- Page de gestion : ajout, édition, publication/brouillon, résultats et suppression confirmée. Cartes MatchCard communes aux deux pages ; composants réutilisables MatchMonth, ClubFilterTabs, ClubFormField, ClubSelect et FixtureFormDialog fondés sur les primitives existantes et Radix.
- Styles calendar.css adaptés aux téléphones, fenêtres accessibles et réduction des animations. Accès via le cadenas du header et lien de gestion dans le tableau de bord pour les administrateurs.
- Fichiers : types/calendar.ts, lib/calendar.ts, composants cités, pages Calendar.vue et Admin/Calendar.vue, calendar.css, app.ts, types/index.ts, ClubNavigation.vue, Dashboard.vue, suivi.md. Aucune dépendance ajoutée.
- Tests, mise en forme et vérification du rendu à effectuer.

## 6 novembre 2026 : calendrier, tests et documentation

- Huit tests fonctionnels ajoutés : publication et tri, état vide, autorisations de chaque route, cycle de gestion complet, validation des dates/heures/scores, champs facultatifs, inscription sans élévation de privilèges et commande de rôle.
- PLAN.md étendu au calendrier demandé ; README.md complété pour les accès, la commande administrateur et les règles de publication.
- Fichiers : tests/Feature/CalendarTest.php, PLAN.md, README.md, suivi.md. Mise en forme frontend effectuée ; contrôles en cours.

## 6 novembre 2026 : calendrier, premiers contrôles

- ESLint réussi. Types corrigés : paramètres Ziggy nommés et booléens explicités dans le formulaire Inertia.
- Pint ciblé réussi après relance autorisée hors bac à sable (refus d’écriture initial). Aucune dépendance modifiée.
- Fichiers : FixtureFormDialog.vue, Admin/Calendar.vue, fichiers PHP du calendrier mis en forme et suivi.md. Compilation, tests et migration à suivre.

## 6 novembre 2026 : calendrier, validation fonctionnelle

- Migration locale additive réussie, sans réinitialisation ni rencontre ajoutée. TypeScript, ESLint et compilation Vite réussis. 42 tests Laravel passent, 320 assertions ; relance autorisée après refus d’accès à l’autoload dans le bac à sable.
- Navigateur de nouveau accessible : page publique et navigation mensuelle contrôlées, version mobile à 320 pixels sans débordement horizontal mesuré. Aucun compte local créé ni promu pour les contrôles ; parcours de gestion couvert par les tests fonctionnels, contrôle visuel authentifié restant à effectuer.
- Messages de validation du formulaire explicitement traduits en français (aucun catalogue français livré par le starter kit). Petit espacement corrigé dans le titre du prochain match sur mobile.
- Fichiers : FixtureRequest.php, Calendar.vue, migration locale ignorée et suivi.md. Derniers contrôles après ajustement en cours.

## 6 novembre 2026 : calendrier, correction des accents après contrôle visuel

- Le rechargement du navigateur a révélé des accents mal décodés dans Calendar.vue, Admin/Calendar.vue, FixtureFormDialog.vue et routes/web.php. Réencodage UTF-8 corrigé sur ces quatre fichiers ; relecture explicite UTF-8 désormais utilisée dans les scripts de modification.
- Dernier test ciblé avant correction : huit tests calendrier réussis, 124 assertions ; Pint et git diff --check réussis. Recompilation et nouvelle vérification visuelle à effectuer.

## 6 novembre 2026 : calendrier, livraison locale

- Après correction des accents : compilation Vite et contrôle TypeScript réussis ; normalisation des fins de ligne de routes/web.php par Pint. ESLint et les 42 tests Laravel (320 assertions) déjà validés ; huit tests calendrier revalidés après traduction des messages.
- Contrôle navigateur final : accents corrects, calendrier mensuel affiché, aucune alerte ni erreur de console. Navigation mensuelle et absence de débordement à 320 pixels vérifiées précédemment. Capture calendrier-fc-hymont.jpg enregistrée dans le dossier de visualisations Codex, hors des sources.
- Page publique et gestion du calendrier livrées ; accès administrateur via un compte existant auquel attribuer le rôle avec club:admin. Aucun match ni compte ajouté localement. Gestion couverte par les tests fonctionnels, rendu authentifié non contrôlé dans le navigateur.
- Serveur conservé sur le port 8000. Administration des joueurs et des convocations toujours à réaliser séparément ; le bloc 5 complet ne doit pas être considéré comme terminé.

## 6 novembre 2026 : cartes épurées et identité dans les fiches

- Suppression des mentions FC HYMONT et FCH au bas de PlayerCardArtwork, dessin partagé entre Équipe, Convocation et fiche agrandie. Filet rouge et proportions conservés ; styles de texte devenus inutiles retirés de team.css.
- PlayerDetails utilise le prénom et l’initiale du nom abrégé lorsque les champs distincts sont vides. Libellé Nom (initiale) dans ce cas ; les champs renseignés restent prioritaires, aucune identité complète inventée ni donnée modifiée.
- Compétences frontend-design et french-language appliquées. Fichiers : PlayerCardArtwork.vue, PlayerDetails.vue, team.css et suivi.md. Vérifications à effectuer.

- Vérifications finales de cette retouche : Prettier ciblé, TypeScript, ESLint, compilation Vite et git diff --check réussis. Navigateur : fiche Lucas G affichant Prénom Lucas et Nom (initiale) G, fermeture réussie ; les 26 pieds de carte sont sans texte. Capture fiche-joueur-identite.jpg enregistrée hors des sources. Aucun PHP modifié, tests Laravel non relancés.


## 6 novembre 2026 : import du calendrier réel

- Source publique : footballclubhymont.fr, rubrique Calendrier et collection publique matches, consultées le 6 novembre. 21 rencontres enregistrées dans database/data/fixtures-2026-2027.json : 10 terminées, 11 futures. Année 2026 corroborée par les horodatages des résultats ; mars à mai rattachés par continuité à la saison 2026-2027 (année absente du formulaire source).
- Types domicile/extérieur conservés tels que publiés, même lorsque le stade paraît inhabituel. Compétition non précisée : libellé neutre Rencontre. Scores non inventés ; résultat victoire/défaite conservé via outcome. Horaire de Saulxures laissé vide.
- Migration additive source_key/outcome et ClubCalendarSeeder relançable sans écraser les modifications administratives. Modèle, validation et composants calendrier adaptés aux résultats sans score. Tests et import local à suivre.


## 6 novembre 2026 : bloc 5, gestion des joueurs et compositions

- Compétences frontend-design et french-language appliquées ; direction ajoutée à DESIGN.md. Contrôleurs d’administration, validation des joueurs et portraits, réglages globaux désactivés par défaut et migration additive créés. Routes protégées par le rôle administrateur existant.
- Composition limitée à onze titulaires, joueurs publiés et uniques, coordonnées bornées. Brouillon séparé de la publication, une seule composition publiée, retrait possible sans effacer le brouillon. Suppression d’un joueur nettoyant ses placements ; portraits remplacés ou retirés nettoyés du stockage.
- Le contrôleur public utilise désormais les réglages globaux et ne réactive pas l’aperçu illustratif après la gestion d’un brouillon. Interfaces et tests à terminer.


## 6 novembre 2026 : bloc 5, interfaces d’administration

- Navigation administrative commune ajoutée aux trois rubriques. Gestion de l’effectif avec cartes réutilisées, recherche, formulaire partagé et aperçu, ajout/modification de portrait et suppression confirmée.
- Éditeur de convocation réutilisant SelectionPitch et PlayerCard : ajout des titulaires/remplaçants, sélection puis clic libre sur le terrain, coordonnées modifiables au clavier, passage titulaire/remplaçant et retrait. Brouillon, confirmation de publication, retrait du site et réglages statistiques indépendants.
- Composants ajoutés : ClubAdminNavigation, PlayerFormDialog, SelectionEditor ; pages Admin/Players et Admin/Selection, types/admin et admin.css. Primitives de formulaires et fenêtres existantes réutilisées. Aucune dépendance installée. Contrôles à effectuer.


## 6 novembre 2026 : premiers contrôles du bloc 5

- Mise en forme Prettier réalisée. TypeScript détecte une incompatibilité entre une interface Placement et le contrat de formulaire Inertia ; conversion en type objet. Copie des placements par projection explicite afin de prendre en charge les objets réactifs Vue.
- Test existant des statistiques adapté aux réglages globaux, en conservant ses assertions de masquage, indépendance et valeur zéro. Suite complète et tests de gestion à exécuter.


## 6 novembre 2026 : migration et tests de l’administration

- Migrations additives exécutées et 21 rencontres importées localement avec ClubCalendarSeeder. Contrôle TypeScript réussi ; règle ESLint corrigée en séparant condition et boucle dans SelectionEditor.
- Huit tests de gestion ajoutés : import relançable, résultat sans score, autorisations de huit routes, cycle des joueurs et portraits, validation, brouillon/publication/retrait, composition invalide et réglages globaux immédiats.
- Premier passage : 49 tests réussis et un échec dans la recherche de date du test d’import (date Eloquent stockée avec heure). Requête corrigée avec whereDate ; aucun défaut d’import constaté. Relance à suivre.


## 6 novembre 2026 : bloc 5, protections et contrôles

- Suite complète réussie : 50 tests et 532 assertions. ESLint, TypeScript, compilation Vite et Pint ciblé réussis.
- Contrôle navigateur du calendrier réel : novembre contient les quatre rencontres attendues, prochain match Girmont le 8 à 14 h 30, victoire Mirecourt affichée sans score inventé.
- Relecture : conservation des placements non enregistrés lors d’un changement des réglages globaux ; exclusion des joueurs dépubliés dans l’éditeur afin qu’ils ne bloquent pas sa réouverture ; erreur explicite si le stockage d’un portrait échoue. Libellés et relations ARIA des cartes adaptés à leur réutilisation en édition. Derniers contrôles après ces retouches à effectuer.


## 6 novembre 2026 : portraits et contrôle navigateur isolé

- Lien public/storage créé avec les droits nécessaires après un refus Windows ; vérification du lien à suivre. Préparation d’une base SQLite temporaire isolée pour vérifier les écrans administratifs, sans créer de compte ni modifier les compositions de la base du projet.


## 6 novembre 2026 : parcours de connexion et contrôle final

- Dernières retouches validées : TypeScript, ESLint, compilation et 50 tests Laravel (532 assertions). Lien public/storage présent. Serveur de contrôle relancé avec les droits nécessaires après une connexion refusée dans le bac à sable.
- Connexion du compte temporaire et ouverture du formulaire de joueur vérifiées. Écrans d’authentification traduits en français et intégrés au cadre du club ; déconnexion ajoutée à la navigation administrative partagée. Aucun compte créé dans la base du projet.

- Contrôle de la traduction : correction du nom technique canResetPassword, qui doit rester inchangé. Relance des vérifications avant livraison.


## 6 novembre 2026 : contrôles navigateur et documentation du bloc 5

- Sauvegarde du joueur validée dans le navigateur ; ajout d’un titulaire, modification au clavier de sa position et sauvegarde privée du brouillon validés. Rendu mobile à 375 pixels sans débordement horizontal mesuré. Aucune composition de test publiée.
- Le clic final de confirmation de publication sur la base temporaire a été refusé par la validation automatique, qui exige une autorisation spécifique. Aucun contournement tenté. Publication et retrait restent couverts par les tests Laravel ; la vérification manuelle complète est reportée au bloc 6.
- README et PLAN actualisés : import relançable, provenance et inférence de saison, portraits, accès, gestion, statistiques et séparation brouillon/publication. Bloc 5 réalisé avec la limite manuelle explicitement conservée.
- Propriété active du cadre d’authentification renseignée après contrôle TypeScript ; libellés des scores rendus cohérents avec leur caractère facultatif en présence d’un résultat sans score. Dernière compilation et contrôles à relancer.

## 6 novembre 2026 : relance du serveur local

- Serveur Laravel relancé en arrière-plan sur http://127.0.0.1:8000 à la demande de l’utilisateur. Réponse HTTP 200 vérifiée après lancement. Aucun changement fonctionnel effectué.


## 6 novembre 2026 : calendrier interactif simplifié

- Suppression des filtres publics, de la liste mensuelle sous la grille et de la mention « Jour de match · Horaires de Paris ». Prochain rendez-vous conservé.
- MatchMonth affiche chaque affiche FC HYMONT vs adversaire dans sa date ; chaque rencontre ouvre MatchDetailsDialog, composant réutilisable reposant sur Dialog shadcn-vue et MatchCard. Fermeture par croix/Échap et retour du focus au bouton initial. Plusieurs rencontres dans une même journée prises en charge.
- MatchCard indique aussi victoire, nul ou défaite lorsque des scores sont renseignés ; absence de résultat ou de lieu signalée sans inventer de données.
- Grille défilante sur mobile pour préserver les noms ; palette existante conservée. Fichiers : Calendar.vue, MatchMonth.vue, MatchDetailsDialog.vue, MatchCard.vue et calendar.css. Vérifications à suivre.

- Vérifications réussies : TypeScript, ESLint et compilation Vite. Navigateur : victoire Mirecourt sans score inventé, horaire et stade Girmont, fermeture par croix et Échap, retour du focus au bouton de rencontre. Fenêtre vérifiée à 390 pixels ; aucun débordement horizontal de la page, seule la grille défile. Aperçu local enregistré dans storage/app/calendrier-apercu.jpg (non versionné). Aucun changement de données ni de fonctionnalité Laravel.

## 6 novembre 2026 : retrait des mentions décoratives du calendrier

- Suppression du bloc avec icône « Jour de match » et du texte « Sur le terrain. Avec nos couleurs. » dans resources/js/pages/Calendar.vue ; import CalendarDays devenu inutile retiré. Vérification ciblée et compilation à effectuer.
- Vérifications réussies : ESLint ciblé, compilation Vite, absence des deux mentions et de l’import inutilisé, git diff --check. Assets locaux actualisés.

## 6 novembre 2026 : sponsors, recherches et ressources

- Vérification directe des trois sites officiels après constat de résultats de recherche obsolètes ; coordonnées et activités actuelles documentées dans DESIGN.md. Modern Sport limité au nom et à la signature fournis, faute de source fiable.
- Copie intacte des cinq images fournies dans public/images/sponsors. Direction artistique de quatre grandes bannières distinctes documentée ; palette et cadre du club conservés.
- Lecture des compétences frontend-design et french-language ; documentation Inertia 2 consultée via Laravel Boost pour le rendu de la nouvelle page. Aucun ajout de dépendance. Implémentation et vérifications à suivre.

## 6 novembre 2026 : page Sponsors et bannières partagées

- Nouvelle page Sponsors raccordée à la route et à la navigation existantes. Composant réutilisable SponsorBanner, type Sponsor et données centralisées : logo, activité, spécialités, coordonnées et liens externes selon les informations vérifiées.
- Quatre univers : photographie du Plan B, composition typographique Snack51, rayons orange/violet Modern Sport, lignes architecturales Someny. Effet lumineux à l’apparition et au survol/focus, aucune animation en boucle, réduction des animations respectée. Bouton shadcn-vue partagé et liens téléphoniques.
- Fichiers : routes/web.php, resources/js/app.ts, resources/js/pages/Sponsors.vue, resources/js/components/club/SponsorBanner.vue, resources/js/data/sponsors.ts, resources/js/types/sponsor.ts et resources/css/sponsors.css. Aucun nouveau paquet ; mise en forme et contrôles à suivre.

## 6 novembre 2026 : Sponsors, vérifications

- Vérifications réussies : TypeScript, ESLint, compilation Vite, syntaxe PHP des routes et git diff --check. Suite Laravel : 50 tests réussis, 532 assertions ; relance autorisée hors bac à sable après refus d’accès à vendor/autoload.php.
- Navigateur : route Sponsors fonctionnelle dans le cadre existant, quatre logos chargés, destinations des liens externes et numéros contrôlés. Rendu ordinateur et téléphone à 390 pixels examiné ; aucun débordement horizontal (largeur de document 375 pixels). Retour au viewport initial effectué.
- Mise en forme Prettier des fichiers frontend concernés réalisée. Aperçu des quatre panneaux enregistré dans storage/app/sponsors-apercu.jpg, ignoré par Git. Aucun changement de données du club ni de dépendances.
- Limite : coordonnées, activité précise et site de Modern Sport non établis ; aucune information inventée. Les sponsors sont actuellement centralisés dans resources/js/data/sponsors.ts ; leur édition administrative ne fait pas partie de cette modification.

## 6 novembre 2026 : partenariat et page Contact

- Retrait du balayage brillant au survol/focus des bannières Sponsors et de son animation inutilisée ; effet d’entrée conservé.
- Ajout du composant ClubCallToAction sous les sponsors avec le texte demandé, accents corrigés et bouton ClubAction vers la route Contact.
- Création de Contact.vue et du composant ClubContactDetails : adresse du stade et numéros de M. Ribeiro / M. Mangin fournis par l’utilisateur, appels via liens tel:. Route Contact raccordée à cette page ; palette et navigation existantes conservées.
- Fichiers : sponsors.css, Sponsors.vue, ClubCallToAction.vue, ClubContactDetails.vue, Contact.vue, contact.css, app.ts, routes/web.php, DESIGN.md et suivi.md. Documentation Inertia 2 consultée via Boost, compétences frontend-design et french-language appliquées. Aucune dépendance ajoutée. Vérifications à suivre.

## 6 novembre 2026 : contrôles partenariat et Contact

- Vérifications réussies : TypeScript, ESLint, compilation Vite, syntaxe PHP des routes et git diff --check ; mise en forme Prettier ciblée réalisée. Règle et animation de brillance au survol/focus absentes de sponsors.css.
- Navigateur : texte de partenariat présent sous les quatre sponsors ; clic réel sur « Nous contacter » ouvrant la nouvelle page Contact, navigation active correcte, adresse et deux numéros conformes. Liens tel:+33638712184 et tel:+33614941124 contrôlés sans déclencher d’appel.
- Rendus ordinateur et mobile à 390 pixels examinés ; absence de débordement horizontal sur Contact. Viewport initial rétabli. Aperçu enregistré dans storage/app/contact-apercu.jpg (ignoré par Git). Aucun problème restant constaté sur ce périmètre.


## 6 novembre 2026 : page Réseaux

- Objectif : remplacer la page d’attente par les accès Instagram et Facebook fournis par l’utilisateur.
- Fichiers : `routes/web.php`, `resources/js/pages/Social.vue`, `resources/js/components/club/ClubSocialCard.vue`, `resources/css/social.css`, `resources/js/app.ts`, `DESIGN.md`, `suivi.md`.
- Changements : deux panneaux réutilisant le même composant et le bouton shadcn-vue, pictogrammes de plateforme, noms de comptes et liens exacts ouvrant un nouvel onglet. Cadre noir, rouge et blanc, affichage mobile en une colonne, focus clavier et réduction des animations. Aucun contenu de réseau social ni chiffre inventé. Route et entrée de navigation existantes conservées. Documentation Inertia 2 consultée via Laravel Boost.
- Vérifications : à effectuer après cette entrée (TypeScript, ESLint, compilation, syntaxe PHP et aperçu navigateur).
- Problèmes restants : aucun identifié à ce stade ; chargement des profils externes dépend des plateformes.

### Vérifications de la page Réseaux

- `npm run typecheck`, `npm run lint:check`, `npm run build`, `php -l routes/web.php` et `git diff --check` : réussis.
- Navigateur local : `/reseaux` affiche les deux panneaux et la navigation active. Les adresses correspondent exactement aux liens fournis, avec ouverture dans un nouvel onglet et `noopener noreferrer`.
- Mobile : viewport de 390 × 844, largeur utile de 375 pixels ; une colonne, aucun débordement horizontal. Affichage vérifié visuellement sur ordinateur et téléphone.
- Aperçu enregistré dans `storage/app/reseaux-apercu.jpg` (fichier local ignoré par Git). Aucun problème restant identifié ; les pages externes des plateformes n’ont pas été testées.


## 6 novembre 2026 : page Actualités

- Objectif : remplacer la page d’attente par les actualités du club dans la direction graphique existante.
- Fichiers : `routes/web.php`, `resources/js/pages/News.vue`, `resources/js/components/club/ClubNewsCard.vue`, `resources/js/types/news.ts`, `resources/js/data/news.ts`, `resources/css/news.css`, `resources/js/app.ts`, `DESIGN.md`, `suivi.md`.
- Changements : six articles repris de la rubrique Actualités du site d’origine après consultation directe ; aucune année supposée. Dernier article mis en avant avec son score réel, autres articles en grille et lecture intégrale par fenêtre accessible. Composant unique pour les articles, Button et Dialog shadcn-vue existants, clavier, affichage mobile et réduction des animations. Aucune dépendance ajoutée. Documentation Inertia 2 consultée via Laravel Boost.
- Vérifications : à réaliser après compilation (types, lint, PHP, navigateur et ouverture/fermeture des articles).
- Limites : contenu conservé dans un fichier de données, sans synchronisation automatique avec le site d’origine ni éditeur administratif ajouté dans cette demande.

### Premiers contrôles Actualités

- TypeScript, ESLint, compilation Vite, syntaxe PHP et `git diff --check` réussis.
- Six articles présents dans le navigateur ; ouverture et contenu du premier article confirmés.
- Ajustement nécessaire : la hauteur minimale du thème global s’applique à la fenêtre et crée un espace vide excessif ; neutralisation ciblée avant la validation finale.

### Ajustement de la fenêtre Actualités

- Fichier : `resources/css/news.css`. Hauteur minimale remise à zéro uniquement pour la fenêtre de lecture, afin de conserver un panneau proportionné au texte.
- Vérification : compilation et contrôle visuel à relancer après cette correction.

### Validation finale de la page Actualités

- Compilation Vite réussie après correction de la hauteur minimale. TypeScript et ESLint avaient réussi avant cette seule correction CSS ; syntaxe PHP et contrôle des espaces Git réussis.
- Navigateur : six articles, mise en avant du derby et ouverture du texte intégral confirmées. Fenêtre désormais proportionnée au texte. Fermeture par Échap vérifiée ; fermeture par la croix et retour du focus au bouton d’origine confirmés.
- Mobile 390 × 844 : largeur utile et largeur du contenu égales à 375 pixels, aucun débordement horizontal ; lecture de l’article long du 4 octobre vérifiée. Viewport rétabli après test.
- Aperçu : `storage/app/actualites-apercu.jpg`, fichier local ignoré par Git.
- État : page publique réalisée et vérifiée ; articles statiques, gestion administrative et synchronisation non incluses dans cette demande.


## 6 novembre 2026 — Bloc 5, préparation de l’administration complète
- Objectif : compléter les éditeurs existants, protéger /admin et créer un compte local.
- Fichier : DESIGN.md ; plan de présentation relu contre la demande.
- Vérifications : architecture existante inspectée, documentation Laravel 12 consultée via Boost (validation des images et attributs JSON).
- Reste : réalisation, migration, contrôles et compte ; aucun identifiant consigné ici.

### Bloc 5 — stockage et édition des contenus
- Fichiers : database/data/editorial.json, migration club_contents, modèle ClubContent, contrôleurs ContentController et ClubPagesController, routes/web.php.
- Reprise exacte des six articles et quatre sponsors ; paramètres contacts/réseaux initialisés avec les valeurs existantes. CRUD protégé par le droit administratif, brouillons, ordre, images validées et nettoyage des seuls fichiers téléversés.
- Vérifications : contrôles automatisés à effectuer après raccordement des vues. Migration locale non encore exécutée.

### Bloc 5 — interfaces de gestion et contenus publics
- Fichiers : Admin/Index.vue, Admin/Content.vue, ClubContentForm.vue, types/content.ts, ClubAdminNavigation.vue, admin.css et pages/composants publics News, Sponsors, Social, Contact.
- Accueil administratif à sept rubriques ; éditeur réutilisable avec champs accessibles, images, brouillons, ordre et suppression confirmée. Pages publiques raccordées aux contenus enregistrés ; identités visuelles des partenaires conservées.
- Vérifications : compilation, types, parcours et sécurité à contrôler. Cadenas conservé jusqu’à la validation du panneau.

### Bloc 5 — consolidation des formulaires et accès
- Ajout de la primitive Textarea réutilisable, réutilisation de Checkbox et ClubSelect ; correction de l’initialisation des données Inertia, du retour du focus et du libellé des photos sponsors. Date de naissance explicitement reliée à l’âge calculé.
- Commande club:create-admin : création sans écrasement d’un compte existant, mot de passe aléatoire affiché une seule fois ; connexion administrateur dirigée vers /admin.
- Premier contrôle TypeScript : deux erreurs détectées (primitive Textarea absente et type du champ ordre), corrections appliquées ; contrôles à relancer.

### Bloc 5 — premiers contrôles techniques
- TypeScript réussi. ESLint a signalé une adresse calculée non utilisée : raccordement du rendu corrigé. Correction également de la signature interne de persistance et d’un réencodage de caractères introduit lors des modifications.
- Formatage PHP exécuté avec succès après blocage en bac à sable ; aucun contrôle fonctionnel annoncé comme terminé à ce stade.

### Bloc 5 — couverture des opérations administratives
- Ajout : tests/Feature/EditorialAdministrationTest.php. Vérifie les droits, les données importées, les brouillons et publications, les images et suppressions, l’identité des sponsors, les contacts et réseaux, les liens invalides et la création de comptes sans écrasement.
- Exécution à suivre ; les tests travaillent sur une base isolée et ne modifient pas les contenus locaux.

### Bloc 5 — migration et résultats intermédiaires
- Migration locale réussie : contenus éditoriaux repris sans toucher aux joueurs, rencontres ou convocations. Le lien de stockage public existe déjà. Compilation, TypeScript et ESLint réussis.
- Première suite PHP : 57 tests réussis, un échec lié à la génération d’image de test nécessitant GD. Remplacement par un fichier PNG réel miniature, sans dépendance ajoutée.
- Logo obligatoire pour chaque sponsor ; contrôles à relancer après ce renforcement. L’accès invité à /admin redirige bien vers la connexion.


### Bloc 5 — finitions et documentation
- Retrait du cadenas de la navigation publique ; accès administratif direct conservé. Photos d’actualités affichées sur toutes les cartes concernées et dans la lecture intégrale, sans dimensions de blason.
- README et plan actualisés : sept rubriques, création de compte et données éditoriales persistantes. Compte local créé et connexion vérifiée ; aucun identifiant ni secret consigné.
- Test éditorial ciblé : huit tests réussis, 214 assertions. Derniers contrôles globaux et mobiles à effectuer.


### Bloc 5 — derniers ajustements de lisibilité
- Sponsors nommés par leur enseigne dans la liste administrative ; libellés des accès et aperçus corrigés en français. Choix visuels présentés sans codes techniques. Fichiers : Admin/Content.vue, Admin/Index.vue, ClubContentForm.vue et ContentController.php.
- Vérifications globales avant ces retouches : 58 tests, 746 assertions ; TypeScript, ESLint et compilation réussis. Formulaire sponsor vérifié à 390 pixels, sans débordement. Mise en forme et contrôles finaux à suivre.


### Bloc 5 — validation finale de l’administration étendue
- Contrôles après les dernières retouches : 58 tests Laravel réussis, 746 assertions ; TypeScript, ESLint, compilation Vite et git diff --check réussis. Mise en forme ciblée Prettier et Pint effectuée.
- Navigateur : sept rubriques visibles sur /admin, navigation publique sans cadenas ; formulaire sponsor mobile à 390 × 844 sans débordement, fermeture et retour du focus vérifiés. Formulaires Contacts et Réseaux préremplis avec les informations existantes ; fermeture par Échap et croix vérifiée. Aucun contenu réel modifié pendant ces contrôles.
- Serveur Laravel relancé en arrière-plan sur le port 8000 après interruption. Compte administrateur local créé et connexion déjà vérifiée ; identifiants communiqués uniquement à l’utilisateur, jamais consignés dans les fichiers du projet. Aperçu local : storage/app/admin-apercu.png, ignoré par Git.
- État : sept rubriques implémentées et contrôles automatisés réussis. Limite antérieure conservée pour le bloc 6 : confirmation finale de publication de la convocation non exécutée dans le navigateur ; publication et retrait couverts par les tests serveur.


## 6 novembre 2026 : convocation à places prédéfinies
- Objectif : remplacer les coordonnées libres par onze emplacements, avec ajout automatique, suivi du pointeur et échange sur une place occupée.
- Fichiers : config/selection.php, SelectionSlots.php, contrôleur administratif SelectionController, types/admin.ts, Admin/Selection.vue, SelectionEditor.vue, SelectionPitch.vue, admin.css, DESIGN.md.
- Source unique des positions côté serveur, validation des places et de leur unicité ; anciens placements recalés en mémoire à l’ouverture sans écrasement des données. Cartes partagées conservées ; boutons et menu de place accessibles au clavier. Glissement à la souris et au toucher, carte suivant le pointeur, indication de cible et annulation hors cible/Échap.
- Documentation Laravel 12 consultée avec Boost. Contrôles de types, tests et vérification interactive à effectuer.

### Places fixes : couverture et documentation
- Tests de gestion adaptés aux positions fixes ; ajout de contrôles pour les coordonnées libres, collisions, publication et reprise des anciens placements sans écriture automatique. README actualisé. Vérifications en cours.


### 6 novembre 2026 — Places fixes : vérification des interactions
- Vérification réelle dans le navigateur : ajout de deux titulaires sur deux places libres distinctes, glissement vers une place libre puis échange sur une place occupée, confirmés par les positions et annonces accessibles. Aucune composition de test enregistrée ni publiée.
- Correction CSS : les cartes laissent les places libres cliquables ; les cibles ont les mêmes proportions que les cartes et leur hauteur ne dépend plus du bouton standard.
- Vérifications intermédiaires : 60 tests Laravel passent (783 assertions), TypeScript et ESLint passent ; compilation de production réussie. Vérification finale après correction CSS en cours.


### 6 novembre 2026 — Convocation : validation finale des places fixes
- Les onze cibles respectent les proportions des cartes. Les cartes restent au-dessus des cibles même après sélection au clavier ou à la souris. Le suivi utilise le composant partagé PlayerCardArtwork et conserve le point de saisie sous le pointeur.
- Navigateur : ajout automatique, déplacement vers une cible libre, échange entre titulaires, annulation hors cible et placement par clic confirmés. Format mobile 390 × 844 contrôlé : onze places espacées et aucun débordement horizontal (contenu et fenêtre : 375 px utiles). Le glissement tactile réel n’a pas été testé sur appareil physique.
- Une sauvegarde du brouillon vide a été déclenchée pendant le changement de format du navigateur ; aucun joueur de test ni composition publique n’a été enregistré ou publié. Les essais avec joueurs sont restés dans l’interface.
- Vérifications finales : 60 tests Laravel réussis, 783 assertions ; TypeScript et ESLint réussis ; Pint appliqué aux fichiers PHP concernés ; compilation de production réussie après les derniers ajustements CSS.


## 6 novembre 2026 — Visibilité des statistiques par joueur
- Objectif : régler les buts et arrêts directement dans chaque fiche administrative.
- Modifications : migration des indicateurs individuels (préservation de la visibilité existante), modèle Player, validation et contrôleurs, suppression du formulaire et de la route des statistiques globales, types et fiches publiques partagés.
- Interface : composant ClubCheckbox fondé sur shadcn-vue, placé sous chaque total dans PlayerFormDialog ; palette et disposition existantes conservées.
- Les valeurs masquées ne sont pas envoyées aux pages publiques ; les valeurs inconnues restent absentes.
- Vérifications en cours : migration, tests, TypeScript, compilation et contrôle visuel.

- Tests adaptés : visibilité indépendante, activation/désactivation immédiate sur les deux pages, zéro visible, valeur inconnue masquée, deux statistiques possibles et rejet des indicateurs invalides.

- Migration locale appliquée. Première suite : 59 tests réussis, une assertion historique à adapter au tableau de statistiques ; correction effectuée.

- Vérifications finales : 60 tests réussis (832 assertions), TypeScript et ESLint sans erreur, compilation Vite réussie, formatage PHP et Vue effectué.
- Contrôle navigateur : cases sous chaque total, activation visuelle confirmée, ancien bloc absent de la convocation. Essai annulé sans modifier les données réelles. Capture : statistiques-par-joueur.png.
- Limites : aucune anomalie restante constatée ; les anciennes colonnes globales sont conservées pour compatibilité de la base mais ne pilotent plus l’affichage public.


## 6 novembre 2026 — Navigation administrative simplifiée
- Objectif : conserver seulement la déconnexion à droite et proposer un retour discret depuis les rubriques.
- Fichiers : ClubAdminNavigation.vue, resources/css/admin.css, suivi.md.
- Composant partagé simplifié : suppression des liens de rubriques, déconnexion alignée à droite ; flèche accessible vers admin.index au-dessus des titres des sous-pages, absente de l’accueil admin.
- Direction : palette et typographies existantes conservées, icône sobre, bouton shadcn-vue et lien Inertia réutilisés.
- Vérifications : TypeScript, ESLint, compilation et navigateur à effectuer.

- Validation finale : TypeScript, ESLint et compilation Vite réussis. Navigateur : déconnexion seule à droite, flèche au-dessus de L’EFFECTIF et retour réel vers /admin confirmés ; aucune flèche sur l’accueil administratif. Capture : navigation-admin.png. Aucun problème restant constaté.


## 6 novembre 2026 — Simplification éditoriale : données
- Formulaires réduits aux champs demandés, publication automatique, date structurée et ordre géré par une route authentifiée transactionnelle.
- Contacts et réseaux : listes libres conservées dans le document existant, conversion des anciennes coordonnées sans migration destructive ; pages publiques adaptées aux nouveaux réseaux.
- Identités visuelles des sponsors existants conservées automatiquement. Déconnexion remplacée par LogOut SVG de 20 px, comme le retour.
- Documentation Laravel 12 consultée via Boost. Vérifications et interface en cours.

### Interface des formulaires
- Composants partagés ClubDatePicker (calendrier français à navigation mensuelle) et ClubEditableContacts (ajout avec +, suppression SVG, erreurs par ligne).
- ClubContentForm : suppression visibilité/ordre/identité/spécialités, listes libres et publication immédiate. Palette sombre, rouge de sélection et boutons shadcn conservés ; aucune dépendance ajoutée.
- Contrôles en cours ; le tri avec suivi visuel reste à intégrer.

### Ordre éditorial et présentation
- ClubSortableList partagé : poignée, capture du pointeur, aperçu suivant la souris, annulation Échap, défilement près des bords et alternative clavier haut/bas.
- Actualités et sponsors utilisent la même liste avec sauvegarde immédiate ; champs numériques et étiquettes brouillon supprimés.
- CSS : calendrier compact sombre, rouge pour la date choisie, listes de coordonnées adaptatives, aperçu de déplacement avec ombre.
- Vérifications en cours.

### Vérifications fonctionnelles éditoriales
- Tests adaptés à la publication immédiate et aux listes libres ; couverture du tri public, doublons, listes incomplètes, identifiants étrangers, droits, dates invalides et suppression de toutes les coordonnées.
- Préremplissage des dates historiques uniquement lorsque l’année est connue ; aucune année inventée pour les anciennes actualités.
- Premier contrôle TypeScript : deux incompatibilités de types relevées puis corrigées. Vérification complète à suivre.

### Ajustements après contrôles
- 62 tests passent (946 assertions), TypeScript et première compilation réussis. Calendrier et ajout de contact vérifiés dans le navigateur sans enregistrer de données de test.
- Capture du pointeur déplacée sur la liste stable pour conserver le suivi lors du réordonnancement ; focus rendu au bouton après choix de date.
- Retrait des anciennes coordonnées fixes à la sauvegarde afin qu’un contact supprimé ne subsiste pas dans les données publiques ; test ajouté. Création de sponsor avec les seuls champs demandés couverte.
- Pint a aussi normalisé des fichiers déjà modifiés (SelectionController, config/database.php et tests de convocation) : formatage uniquement. Validation finale en cours.

### 6 novembre 2026 — Validation finale des formulaires simplifiés
- Fichiers concernés : ContentController.php, ClubPagesController.php, ClubContent.php, routes/web.php, EditorialAdministrationTest.php ; ClubContentForm, ClubDatePicker, ClubEditableContacts, ClubSortableList, ClubAdminNavigation, ClubContactDetails et ClubSocialCard ; pages Admin/Content, Contact et Social, types/content.ts et admin.css.
- Vérifications finales : 63 tests Laravel réussis, 951 assertions ; TypeScript, ESLint et compilation Vite réussis. Publication automatique, champs autorisés, dates, ajout/suppression de coordonnées et persistance de l’ordre public couverts par les tests.
- Navigateur : cinq champs Actualités, neuf champs Sponsors, calendrier français, listes de contacts et de réseaux, ajout de ligne puis annulation confirmés. Contrôle mobile à 390 × 844 sans débordement horizontal. Suivi du pointeur essayé sans changer l’ordre réel ; aucun contenu réel enregistré pendant les essais.
- Aperçu : storage/app/admin-formulaires-apercu.png. Serveur local disponible sur le port 8000 avec la compilation à jour.
- Limites : glissement sur appareil tactile physique non testé ; sauvegarde du nouvel ordre vérifiée par les tests serveur, sans réordonner les contenus réels dans le navigateur. Aucune dépendance ni migration ajoutée.

## 6 novembre 2026 — Envoi du projet sur le dépôt du club
- Objectif : versionner le projet complet sur antohte/FCHYMONT. Dépôt distant vérifié vide avant envoi.
- Fichiers : .gitignore, suivi.md et ensemble des sources, ressources et tests du projet. Captures locales de vérification exclues ; environnement, base SQLite, dépendances et fichiers de stockage privés restent ignorés.
- Configuration Git locale : origine dirigée vers le dépôt du club ; commit attribué au compte propriétaire via son adresse GitHub privée. Message : Création du site FC Hymont et de son administration.
- Vérifications de référence : 63 tests, 951 assertions ; TypeScript, ESLint et compilation réussis à la fin des modifications fonctionnelles. Contrôle des fichiers à publier et envoi Git à effectuer après cette entrée. Aucun secret consigné.

### Validation de l’envoi Git
- Contrôle des 359 fichiers candidats : aucun jeton, clé privée, environnement réel ou fichier SQLite détecté ; git diff --cached --check réussi.
- Commit d72c2da envoyé avec succès sur origin/main (antohtе/FCHYMONT). Ancienne adresse d’envoi du starter kit remplacée par celle du club, en HTTPS.
- Branche locale de publication reliée à origin/main ; branche main locale préexistante préservée. Aucun envoi forcé.
