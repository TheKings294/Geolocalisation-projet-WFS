# Géolocalisation-projet-WFS

## Description
Géolocalisation-projet-WFS est un projet de cours en développement web full stack. Il permet de créer et de gérer les points de vente (PDV) d'une chaîne de restaurants, avec des fonctionnalités intégrant des outils géographiques et une interface utilisateur optimisée.

## Technologies utilisées
- **Back-end** : PHP avec une structure MVC
- **Front-end** : HTML, CSS, JavaScript (modulaire)
- **Framework CSS** : Bootstrap
- **Dépendances** : Gestion via Composer

## Instructions d'installation
1. **Préparer la base de données** :
    - Importez la base de données à l'aide du fichier dump fourni.

2. **Installer les dépendances** :
    - Exécutez la commande suivante dans le répertoire principal du projet :
      ```bash
      composer install
      ```

3. **Configurer l'environnement** :
    - Copiez le fichier `.env.example` en `.env`.
    - Modifiez les variables dans le fichier `.env` pour qu'elles correspondent à votre configuration locale.

## Fonctionnalités principales
- Création, gestion et affichage des points de vente (PDV).
- Intégration des données géographiques via le format GeoJSON.
- Interface utilisateur responsive grâce à Bootstrap.

## Contributeurs
- **Julien Gidel** : Assistance pour le traitement des données GeoJSON.

## Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

