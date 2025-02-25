# Portfolio

## Description

Code front et back du portfolio d'Aurélien Provost

## Specifications

[PHP](https://php.watch/versions/8.3/releases/8.3.1) version 8.3.1   [Symfony](https://github.com/symfony/symfony/tree/7.2)  version 7.2
[Vite] (https://github.com/vitejs/vite/tree/v6.0)  version 6.0.11. [Vue.js](https://github.com/vuejs/core) version 3.5.13  [node.js](https://nodejs.org/dist/v22.13.0/node-v22.13.0-x64.msi)  version 22.13.0. [npm](https://github.com/npm) version 10.9.2. [cypress](https://github.com/cypress-io/cypress) version 14.0.1

## Prérequis

Serveur Apache et base de données installé en local (exemple [MAMP pour windows](https://www.mamp.info/en/downloads/#Windows) )

## Mise en place de l'environnement en local
1. Téléchager ou cloner le dépôt
2. Sur le dossier backend lancer la commande : `composer install`
3. Sur le dossier Frontend : `npm install`
4. Configurez les variables d'environnement dans le fichier `.env` du backend à partir du fichier `exemple.env`, comme : `DATABASE_URL="mysql://user:password@127.0.0.1:3306/database_name?serverVersion=8&charset=utf8mb4"`
5. Mise à jour de la clé recaptcha dans le fichier `main.js` du frontend
6. Initialisation de la base de données depuis le dossier backend : `symfony console doctrine:database:create`


## Lancement des serveurs en local

1. Démarrer le serveur apache et base de données (exmple MAMP)
2. Démarrer le serveur en local : `symfony server:start`
3. Démarrer le frontend : `npm run dev`


## Exécution du test cypress


1. vérifier que le site se lance correctement en local et que les données api soit récupérée
2. Depuis un terminal ouvert dans le dossier **frontend** du projet :
* lancer la commande : `npx cypress open` pour lancer cypress et sélectionner le test `test E2E`

