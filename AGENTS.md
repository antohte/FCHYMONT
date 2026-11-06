# Consignes du projet FC Hymont

## Lecture et suivi obligatoires

- Avant chaque modification ou ajout, lire intégralement `AGENTS.md` et `suivi.md` à la racine.
- Consigner toutes les modifications dans `suivi.md`, y compris les changements de configuration, les dépendances et la documentation.
- Après chaque ensemble cohérent de changements, et avant de commencer le suivant, ajouter une entrée datée : bloc, objectif, fichiers concernés, changements effectués, vérifications et problèmes restants.
- Conserver l'historique existant. Ne jamais écrire de secrets, mots de passe, clés ou contenu de `.env` dans le suivi.
- Ne pas annoncer un bloc terminé si ses vérifications échouent ou restent impossibles ; noter clairement les limites.

## Composants frontend réutilisables

- Tous les éléments d'interface récurrents doivent être des composants Vue réutilisables : boutons, liens d'action, menus déroulants, champs, filtres, fenêtres, panneaux, cartes, états vides et éléments de navigation.
- Utiliser les composants shadcn-vue présents dans `resources/js/components/ui` comme base. Leur personnalisation doit respecter l'identité du FC Hymont.
- Avant de créer un composant, rechercher un équivalent existant dans le projet et le réutiliser ou l'étendre avec des propriétés et des slots.
- Ne pas recopier le balisage, les classes et les comportements d'un même composant dans plusieurs pages. Une variante visuelle doit enrichir le composant partagé plutôt que créer un doublon.
- Placer les composants métier partagés dans `resources/js/components` et les primitives dans `resources/js/components/ui`. Les pages assemblent ces composants.
- Préserver les comportements accessibles de shadcn-vue : clavier, focus, libellés, fermeture des fenêtres et attributs ARIA.

## Langue et direction artistique

- Écrire les contenus publics, messages, documentation et journal en français correct, avec accents et typographie adaptés.
- Appliquer les compétences `french-language` et `frontend-design` lorsqu'elles sont disponibles et pertinentes.
- Conserver la palette noire, rouge et blanche du club. S'inspirer des cartes de football fournies avec une création propre au FC Hymont.
- Concevoir pour mobile et ordinateur ; respecter la préférence de réduction des animations.
- Ne pas inventer d'identités complètes, d'âges, de portraits ni de statistiques pour les vrais joueurs.

## Architecture et blocs

- Stack : Laravel, Vue, Inertia et TypeScript ; SQLite pour le développement local.
- Bloc 1 : initialisation, règles, journal, Laravel Boost, configuration et vérifications.
- Bloc 2 : identité graphique, cadre commun et accueil.
- Bloc 3 : joueurs, cartes, filtres et page Équipe.
- Bloc 4 : terrain et page Convocation.
- Bloc 5 : administration, édition libre et publication.
- Bloc 6 : vérifications et livraison locale.
- Lire les recommandations de Laravel Boost lorsqu'elles sont accessibles. Ne pas écraser les règles locales lors de leur génération ou mise à jour.
- Utiliser le serveur MCP `laravel-boost` pour consulter les versions du projet et rechercher la documentation correspondant aux dépendances installées avant de modifier les fonctionnalités Laravel. Le serveur est lancé avec `php artisan boost:mcp`.
- Exécuter les vérifications adaptées au changement et consigner leurs résultats réels dans `suivi.md`.
