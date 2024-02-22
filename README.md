<p align="center">
  <img src="https://github.com/MathiasSHAKOURI/ofit/assets/122030473/8a49f382-cda3-4254-af03-f5c55a00eeed" />
</p>

# OFIT - Santé et Sport

## Projet de fin de formation

OFIT est un site web dédié à la santé et au sport, développé en utilisant :  
- PHP avec le framework Symfony
- JavaScript pour une expérience utilisateur dynamique
- Une base de données MariaDB pour stocker les articles, les programmes et les utilisateurs
  
Ce projet, réalisé dans le cadre de ma formation, vise à fournir une plateforme complète pour les amateurs de fitness, offrant des fonctionnalités telles que la gestion d'entraînements personnalisés, le suivi des performances, et des conseils de bien-être.    

## Mise en place

### Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

[Composer](https://getcomposer.org/download/)  
[PHP](https://www.php.net/manual/fr/install.php)

### Installation

- Cloner le répo
- Mettre à jour l'URL de la data base `DATABASE_URL` dans le fichier `.env.local`
- Mettre à jour le mailer `MAILER_DSN` dans le fichier `.env.local`
- `composer install`
- `php bin/console doctrine:database:create`
- Importer le fichier `public/sql/ofit.sql`
- Afin de récupérer les comptes de test, vous pouvez trouver les informations dans les DataFixtures, puis si nécessaire en créer de nouveaux
