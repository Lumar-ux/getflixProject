# 🎥 GetFlix

Bienvenue sur **GetFlix** – un projet de site de streaming inspiré de plateformes populaires comme Netflix, Amazon Prime Video, Popcorn Time, et Stremio. Ce projet est le fruit d'un exercice pratique visant à consolider mes compétences en HTML, TailWind CSS, PHP, et MySQL tout en créant une plateforme de streaming fonctionnelle et sécurisée.

## 🌟 Objectifs de la mission

L'objectif de ce projet est de concevoir un site de streaming permettant aux utilisateurs de naviguer dans un catalogue de films, de s'inscrire, de se connecter, de commenter, et bien plus encore. Le site doit intégrer des fonctionnalités essentielles telles que :

- Un système de session : Inscription, connexion et déconnexion.
- Gestion des droits utilisateurs : Les utilisateurs enregistrés peuvent commenter le contenu, tandis que les administrateurs ont des droits supplémentaires (ex: gestion des utilisateurs).
- Une barre de recherche et des filtres de tri.
- Sécurisation du code.

### Fonctionnalités supplémentaires (Nice-to-Have)

- Gestion des mots de passe perdus.
- Back-office pour la gestion des utilisateurs et des commentaires (CRUD).
- Intégration d'une page affichant les meilleurs films via l'API Movie DB.
- Intégration d'une newsletter avec Mailchimp.

## 🚀 Déploiement

Le site a été déployé sur une plateforme gratuite compatible avec PHP. Vous pouvez accéder à la version en ligne via le lien suivant :

[🔗 Lien vers la version en ligne](http://getflix.rf.gd/)

Le code source est disponible dans ce dépôt GitHub et est également référencé sur la version en ligne pour faciliter la navigation.

## 🛠️ Installation & Utilisation

Pour cloner et exécuter ce projet en local, suivez les étapes ci-dessous :

1. **Clonez le dépôt**
   ```bash
   git clone git@github.com:Lumar-ux/getflixProject.git
   cd getflixProject
   ```

2. **Installez les dépendances**
   - Assurez-vous que votre serveur PHP (par exemple, XAMPP, WAMP ou Laragon) est configuré et en cours d'exécution.
   - Importez le fichier `database.sql` dans votre base de données MySQL pour créer les tables nécessaires.

3. **Configuration**
   - Modifiez le fichier `config.php` pour correspondre à votre configuration de base de données locale.

4. **Lancez le site**
   - Ouvrez le navigateur et accédez à `http://localhost/getflixProject`.

## 🧐 Pourquoi ce projet ?

Ce projet est une synthèse des compétences acquises en développement web, mettant l'accent sur la création d'une application web dynamique et sécurisée. Il m'a permis de mieux comprendre les défis techniques liés à la gestion des sessions, la sécurité des données, et l'intégration d'APIs externes.

## 🛠️ Technologies utilisées

- **Frontend**: HTML, TailWind CSS, JS & Ajax
- **Backend**: PHP, MySQL
- **API**: TMDB API
- **Outils de déploiement**: InfinityFree
- **Gestion des Projets**: Github Projects
- **Autres**: Mailjet pour la newsletter, ainsi qu'Improvmx pour créer des adresses email personnalisées avec votre propre domaine.

## 📅 Gestion de projet

Pour ce projet, j'ai utilisé des outils de gestion comme Trello pour suivre les tâches et les délais. Une méthodologie agile a été appliquée pour organiser les sprints et les révisions de code.

## 📈 Challenges techniques

- **Gestion des sessions sécurisées** : Implémentation de techniques pour protéger les sessions utilisateur contre les attaques CSRF et XSS.
- **Intégration de l'API Movie DB** : Récupération des données de films et gestion de leur affichage dynamique.
- **Déploiement sur un serveur PHP** : Recherche et mise en place d'une solution d'hébergement compatible.

## 🚧 À faire

- [ ] Finaliser la gestion des mots de passe perdus.
- [ ] Améliorer l'interface utilisateur pour une meilleure expérience.
- [ ] Ajouter un système de notation des films par les utilisateurs.

## 🤝 Contribution

Les contributions sont les bienvenues ! Si vous souhaitez améliorer ce projet ou corriger des bugs, n'hésitez pas à soumettre une pull request. Pour les problèmes, utilisez le système de tickets GitHub.

---

Merci de votre intérêt pour **GetFlix** ! J'espère que ce projet vous inspirera et que vous apprendrez autant que moi en le parcourant.

© 2024 GetFlix, [Lucas Maroy](https://github.com/Lumar-ux/getflixProject)/[Amandine Van de Winckel](https://github.com/amandineVdw/getflixProject)/[Alisabah Separ](https://github.com/AliSepar)