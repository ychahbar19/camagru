<?php

require("database.php");

$bdd = new PDO("mysql:host=127.0.0.1", $DB_USER, $DB_PASSWORD);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --
// -- Base de données :  `db_camagru`
// --
//
// -- --------------------------------------------------------
//

$bdd->exec("CREATE DATABASE IF NOT EXISTS `db_camagru`");
$bdd->exec("USE db_camagru");
//
// --
// -- Structure de la table `commentary_space`
// --
$bdd->exec("CREATE TABLE `commentary_space` (
  `id_comment` int(11) NOT NULL,
  `id_post` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `commentary` varchar(255) DEFAULT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
// // --
// // -- Structure de la table `filters`
// // --
$bdd->exec("CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `filter_name` varchar(255) NOT NULL,
  `filter_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
// --
// -- Déchargement des données de la table `filters`
// --
$bdd->exec("INSERT INTO `filters` (`id`, `filter_name`, `filter_path`) VALUES
(1, 'rabbit', './public/images/filters/rabbit.png'),
(2, 'rating', './public/images/filters/rated.png'),
(3, 'king_crown', './public/images/filters/crown-1.png'),
(4, 'queen_crown', './public/images/filters/crown-2.png');");
// -- --------------------------------------------------------
// --
// -- Structure de la table `like_array`
// --
$bdd->exec("CREATE TABLE `like_array` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
// -- --------------------------------------------------------
// --
// -- Structure de la table `posts`
// --
$bdd->exec("CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `like_count` int(11) DEFAULT '0',
  `id_comment_space` int(11) DEFAULT NULL,
  `creation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
// --
// -- Structure de la table `users`
// --
$bdd->exec("CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `confirm_key` varchar(255) DEFAULT NULL,
  `user_status` int(1) DEFAULT NULL,
  `notification_bool` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
// --
// -- Index pour les tables déchargées
// --
//
// --
// -- Index pour la table `commentary_space`
// --
$bdd->exec("ALTER TABLE `commentary_space`
  ADD PRIMARY KEY (`id_comment`);");
// --
// -- Index pour la table `filters`
// --
$bdd->exec("ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);");
// --
// -- Index pour la table `like_array`
// --
$bdd->exec("ALTER TABLE `like_array`
  ADD PRIMARY KEY (`id`);");
// --
// -- Index pour la table `posts`
// --
$bdd->exec("ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);");
// --
// -- Index pour la table `users`
// --
$bdd->exec("ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);");
// --
// -- AUTO_INCREMENT pour la table `commentary_space`
// --
$bdd->exec("ALTER TABLE `commentary_space`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;");
// --
// -- AUTO_INCREMENT pour la table `filters`
// --
$bdd->exec("ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");
// --
// -- AUTO_INCREMENT pour la table `like_array`
// --
$bdd->exec("ALTER TABLE `like_array`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;");
// --
// -- AUTO_INCREMENT pour la table `posts`
// --
$bdd->exec("ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;");
// --
// -- AUTO_INCREMENT pour la table `users`
// --
$bdd->exec("ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;");















?>
