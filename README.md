# Football Club Hymont

Refonte du site du club avec Laravel, Vue 3, Inertia, TypeScript, Tailwind CSS et des composants shadcn-vue réutilisables.

## Avant toute modification

Lire `AGENTS.md` et `suivi.md`. Consigner toutes les modifications et leurs vérifications dans le suivi. Rechercher et réutiliser les composants existants avant d'en ajouter.

## Prérequis

- PHP 8.4.1 ou supérieur avec PDO SQLite, SQLite3, mbstring, OpenSSL, DOM, cURL et fileinfo. Les dépendances verrouillées imposent ce minimum ; l'environnement local vérifié utilise PHP 8.5.
- Composer 2 et Node.js 22 LTS ou supérieur, avec npm.
- Git et accès aux registres Composer et npm ainsi qu'à GitHub.

## Première installation locale sous PowerShell

```powershell
composer install
npm ci
Copy-Item .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File -ErrorAction SilentlyContinue
php artisan migrate
php artisan db:seed --class=ClubRosterSeeder
php artisan db:seed --class=ClubCalendarSeeder
php artisan storage:link
npm run build
```

Ne copier `.env.example` que lors d'une première installation : conserver le fichier `.env` et sa clé si le projet est déjà installé. La configuration utilise SQLite, le français et le fuseau `Europe/Paris`. Ne pas versionner `.env` ni la base locale.

## Démarrage

```powershell
composer run dev
```

Ouvrir http://localhost:8000. Cette commande lance Laravel, le traitement des tâches et Vite. Pail est exclu de la commande pour la compatibilité Windows.

Pour lancer séparément Laravel et Vite, utiliser `php artisan serve` et `npm run dev` dans deux terminaux.

## Vérifications

```powershell
 npm run build
php artisan test
npm run typecheck
npm run lint:check
```

Les scripts `lint:check` et `typecheck` ne réécrivent pas les sources. `npm run lint` et `npm run format` les modifient et nécessitent une entrée dans le suivi. Terminer la compilation avant de lancer les tests Laravel : ils utilisent le manifeste Vite lorsqu’aucun serveur Vite ne tourne.

## Laravel Boost

Boost 2.10.4 est installé et réservé au développement. Son serveur MCP `laravel-boost` est configuré pour Codex dans `.codex/config.toml`. Il se lance depuis la racine du projet avec `php artisan boost:mcp` ; Codex le démarre lorsque sa configuration MCP est chargée.

Pour régénérer uniquement la configuration MCP après installation des dépendances :

```powershell
php artisan boost:install --mcp --no-interaction
```

Recharger le projet dans Codex si le serveur n'apparaît pas dans une session déjà ouverte. L'installation ciblée conserve les consignes françaises de `AGENTS.md` ; toute génération ultérieure de recommandations doit les préserver.

## État du bloc 1

Base locale validée le 5 novembre 2026 : Laravel 12.71.0, Vue 3, Inertia 2, TypeScript et SQLite. Les trois migrations sont exécutées ; les 27 tests Laravel passent (64 assertions). TypeScript, ESLint et compilation Vite sont validés. Le démarrage groupé Laravel/file de tâches/Vite, les réponses HTTP et le protocole MCP de Boost ont été vérifiés.

Le dernier audit npm signale encore une alerte faible et treize modérées, sans alerte élevée ou critique. Leur résolution complète reste à traiter ; aucune mise à niveau majeure forcée n'a été appliquée.

## État du bloc 2

Accueil réalisé avec le blason fourni sur une carte de football, un terrain décoratif en perspective et la palette noire, rouge et blanche. La direction artistique est décrite dans `DESIGN.md`.

Le cadre public et les composants du club sont partagés dans `resources/js/layouts/ClubLayout.vue` et `resources/js/components/club`. Les actions et le menu utilisent les primitives shadcn-vue existantes. Les rubriques sont développées progressivement dans les blocs suivants.

Vérifications du 5 novembre 2026 : types, ESLint et compilation de production réussis ; 27 tests Laravel passent, avec 64 assertions. Contrôle visuel sur ordinateur, tablette et mobile jusqu’à 320 pixels ; navigation, fermeture du menu par Échap, accès clavier au contenu et chargement du logo vérifiés. Le thème désactive animations et transitions lorsque la réduction des animations est demandée.

## État du bloc 3

Page `/equipe` réalisée : 26 joueurs issus des informations publiques du site d’origine, cartes de football aux couleurs du club, filtres par poste, recherche insensible aux accents et fiche au clic. Le numéro affiché est celui du maillot. Les portraits manquants utilisent une silhouette ; les identités complètes et les âges inconnus restent non renseignés.

`PlayerCard`, `PlayerPortrait`, `PlayerDetails` et les composants de filtre, recherche et fenêtre sont réutilisables pour la convocation. Les champs internes et les joueurs non publiés sont exclus des données de la page publique. Aucun résultat ou statistique fictif ajouté.

L’import initial se relance avec `php artisan db:seed --class=ClubRosterSeeder`. Il ne crée pas de compte et préserve les joueurs déjà importés ainsi que leurs modifications. La gestion est disponible sur `/admin/joueurs`.

Vérifications du 5 novembre 2026 : 30 tests Laravel réussis, 107 assertions ; TypeScript, ESLint, Pint ciblé et compilation réussis. Filtres, recherche, état vide, ouverture au clavier, Échap et restitution du focus vérifiés dans le navigateur. Grille adaptée de 320 à 1 280 pixels, sans débordement horizontal aux largeurs mesurées. Les autres rubriques restent vides en attendant leur développement ; la convocation est décrite ci-dessous.

## État du bloc 4

Page `/convocation` réalisée : terrain en perspective, blason en haut à gauche, cartes partagées avec leurs ombres et reflets, sélection du joueur et remplaçants. La fiche apparaît à droite sur ordinateur et dans une fenêtre accessible sur mobile. Aucun texte de formation n’est affiché.

Sans publication et avant tout premier brouillon, un aperçu illustratif de 14 joueurs est activé uniquement dans l’environnement local. Le placement et les remplaçants ne constituent pas une convocation officielle. Pour désactiver cet aperçu, définir `SELECTION_PREVIEW=false` dans la configuration locale. En dehors du développement local, l’absence de publication affiche un état vide par défaut.

Les données permettent une composition publiée et des brouillons ; seule la dernière publication effective est exposée. Les totaux buts/arrêts sont facultatifs et masqués par défaut. Leurs réglages, les portraits, les informations manquantes et l’édition du placement sont accessibles dans l’administration du bloc 5. Aucun compte ni statistique fictive créé.

Pour une installation existante, exécuter `php artisan migrate`, puis `npm run build`. La migration conserve les joueurs déjà présents.

Vérifications du 5 novembre 2026 : 34 tests Laravel réussis, 196 assertions ; TypeScript, ESLint, Pint ciblé et compilation sans avertissement. Sélection sur ordinateur, ouverture au clavier sur mobile, Échap et restitution du focus vérifiés. Aucun débordement horizontal mesuré à 320, 768 et 1 280 pixels ; aucune erreur ou alerte de console relevée. Les animations respectent la préférence de réduction définie en CSS.

## Blocs

1. Base du projet, règles, journal et Laravel Boost.
2. Identité graphique, cadre commun et accueil.
3. Effectif, cartes joueurs et filtres.
4. Terrain et convocation publique.
5. Administration et publication.
6. Vérifications et livraison locale.

Les écrans de connexion, inscription et récupération de compte utilisent le cadre du club et des libellés français. Les droits de gestion sont attribués explicitement depuis le terminal.

Le périmètre détaillé et les critères de validation sont décrits dans `PLAN.md`.

## Calendrier et administration

Le calendrier public se trouve sur `/calendrier`, sa gestion sur `/admin/calendrier`. Exécuter `php artisan migrate` après récupération des changements. Les 21 rencontres connues du site d’origine sont importées : dix passées et onze à venir au 6 novembre 2026. Aucun match fictif n’est ajouté.

Créer un administrateur local depuis le terminal du projet :

```sh
php artisan club:create-admin adresse-du-compte@example.fr
```

La commande affiche une seule fois un mot de passe aléatoire et refuse d’écraser un compte existant. Se connecter via `/admin`, puis utiliser « Mon mot de passe » pour le modifier. Pour accorder ou retirer le rôle à un compte existant, utiliser `php artisan club:admin adresse-du-compte@example.fr` avec `--revoke` pour le retrait. Les inscriptions seules ne donnent aucun droit de gestion.

Dans la gestion : ajouter ou modifier un match, choisir domicile/extérieur, date, heure facultative (Paris), compétition et lieu ; sélectionner son état et sa visibilité. Un brouillon reste privé. Un résultat peut comporter les deux scores, y compris zéro, ou seulement victoire/nul/défaite lorsque le score n’est pas communiqué. Un report conserve sa date initiale jusqu’à modification. La suppression demande confirmation.

L’import se relance avec `php artisan db:seed --class=ClubCalendarSeeder`. Il ajoute les rencontres absentes sans écraser les modifications administratives. Les données proviennent du calendrier public de footballclubhymont.fr, consulté le 6 novembre 2026. Les années ne sont pas affichées dans la source : août–novembre sont rattachés à 2026, mars–mai à 2027 par continuité de saison. Aucun score numérique ni horaire absent n’est inventé.

## Bloc 5 — Gestion du club

- `/admin/joueurs` : ajouter, rechercher, modifier, dépublier et supprimer un joueur ; renseigner son identité connue, sa date de naissance, son poste, son maillot et ses statistiques. La suppression retire aussi le joueur des compositions.
- Portraits : JPEG, PNG ou WebP, 4 Mo maximum, 6 000 pixels maximum par dimension. Exécuter `php artisan storage:link` pour les afficher. Les fichiers remplacés ou retirés sont nettoyés.
- `/admin/convocation` : sélectionner des joueurs publiés, ajouter jusqu’à onze titulaires et des remplaçants ; sélectionner une carte puis cliquer sur le terrain, ou utiliser les coordonnées pour la placer au clavier.
- « Enregistrer le brouillon » conserve la composition en privé. « Publier la convocation » demande confirmation et remplace la seule composition publique. « Retirer du site » conserve le brouillon. Aucun historique de compositions n’est prévu.
- Les deux réglages globaux buts/arrêts sont désactivés par défaut et s’appliquent immédiatement aux fiches publiques. Une valeur inconnue reste masquée ; zéro reste une valeur valide.

Les accès sont protégés par authentification et rôle administrateur. L’accès se fait directement par `/admin` ; aucun cadenas n’est affiché dans le header public. Les sept rubriques partagent une navigation et un bouton de déconnexion. Un compte local a été créé à la demande de l’utilisateur, sans identifiant ni mot de passe enregistré dans les sources.

Vérifications : 50 tests Laravel, 532 assertions. Sauvegarde du joueur, sélection/coordonnées et sauvegarde privée du brouillon contrôlées dans le navigateur sur une base temporaire isolée. Le clic final de publication dans le navigateur a été bloqué par la validation automatique de l’outil ; le parcours serveur de publication/retrait et son isolation du brouillon sont couverts par les tests. Ce contrôle manuel reste à reprendre au bloc 6.


## Administration des contenus éditoriaux

- `/admin/actualites` : ajouter, modifier, ordonner, publier ou supprimer un article ; texte, catégorie, date affichée et photo facultative.
- `/admin/sponsors` : ajouter, modifier, ordonner, publier ou supprimer un partenaire ; logo obligatoire, photographie facultative, présentation, coordonnées, site et univers graphique.
- `/admin/contacts` : modifier l’adresse et les deux contacts téléphoniques.
- `/admin/reseaux` : modifier les comptes et liens Instagram/Facebook. Un lien vide masque la plateforme.

Les six actualités et quatre sponsors existants sont importés par migration, ainsi que les contacts et réseaux. Les modifications enregistrées alimentent les pages publiques ; les brouillons restent privés. Les illustrations utilisent le même stockage public et les mêmes limites que les portraits joueurs. L’âge est calculé depuis la date de naissance, pour rester à jour automatiquement.

La composition utilise onze places fixes. Un titulaire ajouté rejoint une place libre ; maintenez une carte pour la déplacer, avec suivi du pointeur et échange sur une place occupée. Le menu « Placer sur le terrain » offre la même action au clavier. Un déplacement hors cible ou Échap conserve la position précédente. Les anciens placements sont recalés à l’ouverture de l’éditeur, puis enregistrés uniquement sur action du gestionnaire.
