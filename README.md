# Géolocalisation-projet-WFS

## Description
Géolocalisation-projet-WFS est un projet de cours en développement web full stack. Il permet de créer et de gérer les points de vente (PDV) d'une chaîne de restaurants, avec des fonctionnalités intégrant des outils géographiques et une interface utilisateur optimisée.

## Technologies utilisées
- **Back-end** : PHP avec une structure MVC
- **Front-end** : HTML, CSS, JavaScript (modulaire)
- **Framework CSS** : Bootstrap
- **Dépendances** : Gestion via Composer

## Instructions d'installation
1. **Installer le projet via git** :
   
    - Installer le projet via git :
      ```bash
      git clone https://github.com/TheKings294/Geolocalisation-projet-WFS.git
      ```
      
1. **Préparer la base de données** :
    - Importez la base de données à l'aide du fichier dump fourni.

2. **Installer les dépendances** :
    
    - Exécutez la commande suivante dans le répertoire principal du projet :
      ```bash
      composer install
      ```

4. **Configurer l'environnement** :
    - Copiez le fichier `.env.example` en `.env`.
    - Modifiez les variables dans le fichier `.env` pour qu'elles correspondent à votre configuration locale.
    - **Clé API pour l'API de l'Insee** : Ajoutez une clé API valide pour l'API de l'Insee dans le fichier `.env` sous la variable `SIRENE_API_KEY`.

5. **Lancer le script de fixture** :
    - Exécutez la commande suivante dans le répertoire principal du projet :
      ```bash
      php scripts/fixture.php
      ```

## Fonctionnalités principales
- Création, gestion et affichage des points de vente (PDV).
- Intégration des données géographiques via le format GeoJSON.
- Récupération de données depuis l'API de l'Insee grâce à une clé API.
- Interface utilisateur responsive grâce à Bootstrap.

## Contributeurs
- **Julien Gidel** : Assistance pour le traitement des données GeoJSON.

## Mot de passe admin
Pour vous connecter à l'application après son intégration :

- **Adresse mail** : admin@admin.com
- **Mot de passe** : admin

## Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
