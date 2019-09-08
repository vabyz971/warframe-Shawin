# Warframe Shawzin

## Projet du Clan Warframe (Dark-Revenge)
 
### Dépendance
    - PHP 7.3.x
    - Mysql 5.7.26 ou plus



Avant de faire les commands suivant,
vous devez modifier le fichier .env a la racine du projet la connection avec votre base de donné

#### Commande à faire pour démarrée le site

// crée la bdd
- php bin/console doctrine:database:create


// Importe les Entitées dans la bdd
- php bin/console doctrine:migrations:migrate

//
- php /bin/console server:run