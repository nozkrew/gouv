Application pour aider les investisseurs immobilier à trouver la ville dans laquelle investir basée

Pré-requis
==========
 * node
 * yarn
 * PHP
 * MySQL

Installation
=============

__` git clone https://github.com/nozkrew/gouv.git `__

__` cd gouv `__

__` composer install `__

__` php bin\console doctrine:database:create `__

__` php bin\console  doctrine:schema:update --force `__

__` yarn install `__

__` yarn encore dev `__

Import des données
==============

Vous trouverez les données sur les régions / départements / villes dans le dossier "db"

L'ensemble des commandes disponibles se trouve dans le dossier src/Command :
 * __` app:recover-population `__ : pour récupérer le nombres d'habitants dans chaque villes
 * __` app:recover-data `__ : pour récupérer des indicateurs sur chaque ville
 * __` app:recover-price-meter `__ : pour récupérer le prix du mètres carré dans chaque ville
