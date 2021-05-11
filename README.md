# restaurant
 Création d'un site de restauration avec réservation réalisé avec le framework symfony 

 * Calcul des ingrédients en JavaScript

 * Confirmation et annulation des reservations en JavaScript

  - composer update
  - yarn install
  - yarn encore dev --watch

  - php bin/console d:d:c

  - php bin/console make:migration

  - php bin/console doctrine:migrations:migrate

  * remplir la base de donnée

  * TABLE USER :

INSERT INTO `categorie` (`id`, `nom`, `description`, `photo`) VALUES

(16, 'Snacks salés', 'Les produits de la catégorie Snacks salés', '1.jpeg'),

(17, 'Produits de la mer', 'Les produits de la catégorie Produits de la mer', '2.jpeg'),

(18, 'Viandes', 'Les produits de la catégorie Viandes', '3.jpeg'),

(19, 'Légumes séchés', 'Légumes séchés', '4.jpeg');

INSERT INTO `ingredient` (`id`, `nom`) VALUES
(8, 'OEUF'),
(9, 'TOMATE'),
(10, 'FROMAGE'),
(11, 'CHEDAR'),
(12, 'CREVETTES'),
(13, 'ARTICHAUT'),
(14, 'MOULES'),
(15, 'PORC'),
(16, 'BICHE'),
(17, 'ANCHOIS'),
(18, 'POIVRON'),
(21, 'BOEUF'),
(22, 'CHOCOLAT'),
(23, 'FRUIT');

INSERT INTO `tapas` (`id`, `categorie_id`, `nom`, `description`, `photo`, `date_de_creation`, `top`) VALUES

(20, 17, 'PRODUITS DE LA MER', 'ENSEMBLE PRODUITS DE LA MER', '7.jpeg', '2020-09-01 00:00:00', 1),

(21, 18, 'VIANDE', 'ENSEMBLE DE VIANDES', '9.jpeg', '2024-01-01 00:00:00', 1),

(22, 19, 'JARDINIERE DE LEGUMES', 'ENSEMBLE DE LEGUMES', '3.jpeg', '2020-11-09 00:00:00', 0),

(25, 16, 'CROQUETTAS', 'un regal avec patates', '4.png', '2020-09-01 00:00:00', 1);


TABLE USER

- php bin/console security:encode-password 

- roles : ["ROLE_RESERVER], ["ROLE_ADMIN"]'


