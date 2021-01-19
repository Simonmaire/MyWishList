# MyWishList
Projet Web MyWishList 2020/2021


Si vous déposer notre dossier mywishlist_2 à la racine de vos projets php, il ne devrait pas y avoir grand chose à faire.
Veillez à bien le déposer à la racine sinon vous serez contraints d'effectuer des changements dans certains fichiers.

1. Le htaccess ne devra être modifié que si le projet ne se trouve pas à la racine de vos projets php.
2. Dans src le composer.json peut être amené à être modifier si vous ne disposez pas de la même version php et eloquent.
3. Le dossier vendor a été supprimé, il faut vous même le génèrer en installant "wget https://getcomposer.org/composer-stable.phar" en ligne de commande sur un terminal.
Ensuite tapez "php composer.phar install". Si ça ne fonctionne pas faites "composer install" si ça ne fonctionne toujours pas faites "composer update".
4.Dans conf vous serez amené à modifier votre username et/ou password en fonction du serveur web que vous utilisé. Pour database vous pouvez laisser : mywishlist_2 si vous décidez d'appeler votre base de données ainsi sinon vous modifiez son nom.
5. Quand vous créez votre base de données depuis l'interface PhpMyAdmin par exemple, après avoir crée la base en lui donnant un nom, vous n'aurez qu'à executer le script SQL fournit dans notre projet pour créer les tables, enregistrer des contraintes et quelques jeux de données
