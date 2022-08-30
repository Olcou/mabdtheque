-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 02 déc. 2021 à 09:46
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bande_dessinee`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id_auteur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id_auteur`, `nom`, `prenom`) VALUES
(1, 'Conrad', 'Didier'),
(2, 'Ferri', 'Jean-Yves'),
(3, 'Baldetti', 'Laurence'),
(4, 'Lullabi', 'Ludo'),
(5, 'Van Dongen', 'Peter'),
(6, 'Teun', 'Berserik'),
(7, 'Tarquin', 'Didier'),
(8, 'Bastide', 'Jean'),
(9, 'Pellet', 'Philippe'),
(10, 'Williams', 'Kent'),
(11, 'Locke', 'Vince'),
(12, 'Thompson', 'Jill'),
(13, 'Hergé', ''),
(14, 'William', ''),
(15, 'Djet', ''),
(16, 'BOlland', 'Brian'),
(17, 'Taniguchi', 'Jirô'),
(18, 'Achdé', ''),
(19, 'Caza', ''),
(20, 'Jérémy', ''),
(21, 'Druillet', 'Philippe'),
(22, 'Reynès', 'Mathieu'),
(23, 'Gonzalez', 'Jose'),
(24, 'Adams', 'Neal'),
(25, 'Jones', 'Jeff'),
(26, 'Corben', 'Richard'),
(27, 'Wood', 'Wallace'),
(28, 'Giménez', 'Juan'),
(29, 'Goscinny', 'René'),
(30, 'Uderzo', 'Albert'),
(31, 'Lylian', ''),
(32, 'Simonson', 'Walter'),
(33, 'Van Hamme', 'Jean'),
(34, 'Arleston', 'Scotch'),
(35, 'Cazenove', 'Christophe'),
(36, 'Roba', 'Jean'),
(37, 'Gaiman', 'Neil'),
(38, 'L\'Hermenier', 'Maxe'),
(39, 'Bussi', 'Michel'),
(40, 'Moore', 'Alan'),
(41, 'Jul', ''),
(42, 'Goodwin', 'Archie'),
(43, ' Jodorowsky', 'Alejandro');

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

CREATE TABLE `collection` (
  `id_collection` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_editeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `collection`
--

INSERT INTO `collection` (`id_collection`, `nom`, `id_editeur`) VALUES
(1, 'Astérix', 1),
(2, 'Grafica', 2),
(3, 'Blake & Mortimer', 4),
(4, 'Lanfeust', 3),
(5, 'Boule Et Bill', 5),
(6, 'Vertigo Essentiels', 6),
(7, 'Collection DC', 6),
(8, 'Casterman Ecritures', 10),
(9, 'Jodorowsky 90 ans', 11),
(10, 'Les aventures de Tintin', 7),
(11, 'Lucky Luke Nouvelles Aventures', 13),
(12, 'Harmony', 14);

-- --------------------------------------------------------

--
-- Structure de la table `editeur`
--

CREATE TABLE `editeur` (
  `id_editeur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `editeur`
--

INSERT INTO `editeur` (`id_editeur`, `nom`) VALUES
(1, 'Albert Rene'),
(2, 'Glénat'),
(3, 'Soleil'),
(4, 'Blake Et Mortimer'),
(5, 'Dargaud'),
(6, 'Urban Comics'),
(7, 'Casterman'),
(8, 'Bamboo Eds'),
(9, 'Jungle'),
(10, 'Casterman'),
(11, 'Les Humanoïdes Associés'),
(12, 'Delirium'),
(13, 'Lucky Comics'),
(14, 'Dupuis');

-- --------------------------------------------------------

--
-- Structure de la table `est_ecrit`
--

CREATE TABLE `est_ecrit` (
  `id_ouvrage` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `est_ecrit`
--

INSERT INTO `est_ecrit` (`id_ouvrage`, `id_auteur`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 31),
(3, 4),
(3, 32),
(4, 6),
(4, 33),
(5, 7),
(5, 34),
(6, 8),
(6, 35),
(7, 9),
(7, 34),
(8, 10),
(8, 37),
(9, 13),
(10, 14),
(10, 35),
(11, 38),
(12, 16),
(12, 40),
(13, 17),
(14, 19),
(15, 21),
(16, 23),
(16, 42),
(17, 28),
(17, 43),
(18, 18),
(18, 41),
(19, 20),
(20, 22);

-- --------------------------------------------------------

--
-- Structure de la table `est_possede`
--

CREATE TABLE `est_possede` (
  `id_ouvrage` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `prete` tinyint(1) NOT NULL,
  `lu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `est_possede`
--

INSERT INTO `est_possede` (`id_ouvrage`, `id_membre`, `prete`, `lu`) VALUES
(19, 1, 0, 0),
(19, 2, 0, 0),
(20, 2, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id_genre`, `nom`) VALUES
(1, 'Humour'),
(2, 'Jeunesse'),
(3, 'Fantasy'),
(4, 'Fantastique'),
(5, 'Aventure'),
(6, 'Super-héros'),
(7, 'Tranche de vie'),
(8, 'Science-fiction'),
(9, 'Action');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mail`, `password`) VALUES
(1, 'admin', 'admin@admin.fr', 'A2345!'),
(2, 'caro', 'caro@caro.fr', 'A123456@');

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage`
--

CREATE TABLE `ouvrage` (
  `id_ouvrage` int(11) NOT NULL,
  `tome` int(11) DEFAULT NULL,
  `isbn` varchar(50) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `annee` year(4) NOT NULL,
  `resume` text DEFAULT NULL,
  `id_editeur` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  `id_collection` int(11) DEFAULT NULL,
  `id_serie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ouvrage`
--

INSERT INTO `ouvrage` (`id_ouvrage`, `tome`, `isbn`, `titre`, `annee`, `resume`, `id_editeur`, `id_genre`, `id_collection`, `id_serie`) VALUES
(1, 39, '9782864973492', 'Astérix et le Griffon', 2021, NULL, 1, 1, 1, 1),
(2, 1, '9782723491648', 'D\'un monde à l\'autre', 2013, NULL, 2, 2, 2, 2),
(3, 3, '9782302003736', 'Révélations', 2008, NULL, 3, 3, NULL, 3),
(4, 28, '9782870972854', 'Le Dernier Espadon', 2021, NULL, 4, 4, 3, 4),
(5, 9, '9782302092037', 'La Forêt noiseuse', 2021, NULL, 3, 4, 4, 5),
(6, 42, '9782505089421', 'Royal taquin', 2021, NULL, 5, 2, 5, 6),
(7, 8, '9782302031005', 'Les Hordes de la nuit', 2013, NULL, 3, 3, NULL, 7),
(8, 4, '9782365773898', 'Sandman', 2014, NULL, 6, 3, 6, NULL),
(9, NULL, '9782203001169', 'On a marché sur la lune', 1993, NULL, 7, 5, 10, NULL),
(10, 16, '9782818984093', 'Cap\' ou pas cap\' ?', 2021, NULL, 8, 1, NULL, 8),
(11, 2, '9782822233774', 'Un nouveau monde', 2021, NULL, 9, 2, NULL, 9),
(12, NULL, '9782365773478', 'Batman : Killing Joke', 2014, 'Le Joker s’est à nouveau échappé de l’asile d’Arkham. Il a cette fois pour objectif de prouver la capacité de n’importe quel être humain de sombrer dans la folie après un traumatisme. Pour sa démonstration, il capture le commissaire GORDON et le soumet aux pires tortures que l’on puisse imaginer, à commencer par s’attaquer à sa chère fille, Barbara Gordon.', 6, 6, 7, NULL),
(13, NULL, '9782203101746', 'Le Gourmet solitaire', 2016, 'On ne sait presque rien de lui. Il travaille dans le commerce, mais ce n\'est pas un homme pressé ; il aime les femmes, mais préfère vivre seul ; c\'est un gastronome, mais il apprécie par-dessus tout la cuisine simple des quartiers populaires... Cet homme, c\'est le gourmet solitaire. Imaginé par Masayuki Kusumi, ce personnage hors du commun prend vie sous la plume de Jirô Taniguchi, sur un mode de récit proche de l\'Homme qui marche : chaque histoire l\'amène ainsi à goûter un plat typiquement japonais, faisant renaître en lui des souvenirs enfouis, émerger des pensées neuves ou suscitant de furtives rencontres.', 10, 7, 8, NULL),
(14, NULL, '9782731650655', 'Scènes de la vie de Banlieue', 2017, 'Explorateur avisé de la vie occidentale moderne, Caza en scrute les méandres. Au travers d\'histoires courtes, \'Scènes de la vie de banlieue\' dénonce avec justesse et humour l\'absurdité des habitants du béton et des tours HLM. On y croise des flibustiers à la barre de leur pavillon de banlieue arborant l\'étendard noir de la révolte, des nymphettes au bord du suicide sauvées in extremis par des VRP de l\'amour et des beaufs au regard triste qui cherchent une sortie de secours. En vain.', 11, 4, NULL, NULL),
(15, NULL, '9782344000205', 'La Nuit', 2014, NULL, 2, 8, NULL, NULL),
(16, 1, '9791090916234', 'Vampirella', 2015, NULL, 12, 4, NULL, NULL),
(17, 6, '9782731653359', 'La Caste des Méta-Barons', 2019, NULL, 11, 8, 9, NULL),
(18, 9, '9782884714655', 'Un cow-boy dans le coton', 2020, NULL, 13, 9, 11, 10),
(19, 1, '9782505089506', 'L\'Amazone', 2021, NULL, 5, 4, NULL, 11),
(20, 1, '9782800165837', 'Memento', 2016, NULL, 14, 4, 12, 12);

-- --------------------------------------------------------

--
-- Structure de la table `serie`
--

CREATE TABLE `serie` (
  `id_serie` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `serie`
--

INSERT INTO `serie` (`id_serie`, `nom`) VALUES
(1, 'Astérix'),
(2, 'La Quête d\'Ewilan'),
(3, 'World of Warcraft'),
(4, 'Blake & Mortimer'),
(5, 'Lanfeust de Troy'),
(6, 'Boule Et Bill'),
(7, 'Les Forêts d\'Opale'),
(8, 'Les sisters'),
(9, 'N.E.O.'),
(10, 'Les Aventures de Lucky Luke d\'après Morris'),
(11, 'Vesper'),
(12, 'Harmony');

-- --------------------------------------------------------

--
-- Structure de la table `visuel`
--

CREATE TABLE `visuel` (
  `id_visuel` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `path` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_ouvrage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `visuel`
--

INSERT INTO `visuel` (`id_visuel`, `type`, `path`, `nom`, `id_ouvrage`) VALUES
(1, 'jpg', '/assets/images/visuel/', 'asterix_et_le_griffon_9782864973492', 1),
(2, 'jpg', '/assets/images/visuel/', 'la_ quete_ewilan_9782723491648', 2),
(3, 'jpg', '/assets/images/visuel/', 'revelation_9782302003736', 3),
(4, 'jpg', '/assets/images/visuel/', 'le_dernier_espadon_9782870972854', 4),
(5, 'jpg', '/assets/images/visuel/', 'la_foret_noiseuse_9782302092037', 5),
(6, 'jpg', '/assets/images/visuel/', 'royal_taquin_9782505089421', 6),
(7, 'jpg', '/assets/images/visuel/', 'les_hordes_de_la_nuit_9782302031005', 7),
(8, 'jpg', '/assets/images/visuel/', 'sandman_4_9782365773898', 8),
(9, 'jpg', '/assets/images/visuel/', 'on_a_marche_sur_la_lune_9782203001169', 9),
(10, 'jpg', '/assets/images/visuel/', 'capoupascap_9782818984093', 10),
(11, 'jpg', '/assets/images/visuel/', 'un_nouveau_monde_9782822233774', 11),
(12, 'jpg', '/assets/images/visuel/', 'batman_killing_joke_9782365773478', 12),
(13, 'jpg', '/assets/images/visuel/', 'le_gourmet_solitaire_9782203101746', 13),
(14, 'jpg', '/assets/images/visuel/', 'scenes_de_la_vie_de_banlieue_9782344000205', 14),
(15, 'jpg', '/assets/images/visuel/', 'la_nuit_9782344000205', 15),
(16, 'jpg', '/assets/images/visuel/', 'vampirella_tome1_9791090916234', 16),
(17, 'jpg', '/assets/images/visuel/', 'la_caste_des_meta_baron_9782731653359', 17),
(18, 'jpg', '/assets/images/visuel/', 'un_cowboy_dans_le_coton_9782884714655', 18),
(19, 'jpg', '/assets/images/visuel/', 'l_amazone_9782505089506', 19),
(20, 'jpg', '/assets/images/visuel/', 'memento_9782800165837', 20);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id_auteur`);

--
-- Index pour la table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id_collection`),
  ADD KEY `collection_editeur_FK` (`id_editeur`);

--
-- Index pour la table `editeur`
--
ALTER TABLE `editeur`
  ADD PRIMARY KEY (`id_editeur`);

--
-- Index pour la table `est_ecrit`
--
ALTER TABLE `est_ecrit`
  ADD PRIMARY KEY (`id_ouvrage`,`id_auteur`),
  ADD KEY `est_ecrit_auteur0_FK` (`id_auteur`);

--
-- Index pour la table `est_possede`
--
ALTER TABLE `est_possede`
  ADD PRIMARY KEY (`id_ouvrage`,`id_membre`),
  ADD KEY `est_possede_membre0_FK` (`id_membre`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  ADD PRIMARY KEY (`id_ouvrage`),
  ADD KEY `ouvrage_editeur_FK` (`id_editeur`),
  ADD KEY `ouvrage_genre0_FK` (`id_genre`),
  ADD KEY `ouvrage_collection1_FK` (`id_collection`),
  ADD KEY `ouvrage_serie2_FK` (`id_serie`);

--
-- Index pour la table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`id_serie`);

--
-- Index pour la table `visuel`
--
ALTER TABLE `visuel`
  ADD PRIMARY KEY (`id_visuel`),
  ADD UNIQUE KEY `visuel_ouvrage_AK` (`id_ouvrage`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id_auteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `collection`
--
ALTER TABLE `collection`
  MODIFY `id_collection` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `editeur`
--
ALTER TABLE `editeur`
  MODIFY `id_editeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  MODIFY `id_ouvrage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `serie`
--
ALTER TABLE `serie`
  MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `visuel`
--
ALTER TABLE `visuel`
  MODIFY `id_visuel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_editeur_FK` FOREIGN KEY (`id_editeur`) REFERENCES `editeur` (`id_editeur`);

--
-- Contraintes pour la table `est_ecrit`
--
ALTER TABLE `est_ecrit`
  ADD CONSTRAINT `est_ecrit_auteur0_FK` FOREIGN KEY (`id_auteur`) REFERENCES `auteur` (`id_auteur`),
  ADD CONSTRAINT `est_ecrit_ouvrage_FK` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`id_ouvrage`);

--
-- Contraintes pour la table `est_possede`
--
ALTER TABLE `est_possede`
  ADD CONSTRAINT `est_possede_membre0_FK` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `est_possede_ouvrage_FK` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`id_ouvrage`);

--
-- Contraintes pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  ADD CONSTRAINT `ouvrage_collection1_FK` FOREIGN KEY (`id_collection`) REFERENCES `collection` (`id_collection`),
  ADD CONSTRAINT `ouvrage_editeur_FK` FOREIGN KEY (`id_editeur`) REFERENCES `editeur` (`id_editeur`),
  ADD CONSTRAINT `ouvrage_genre0_FK` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`),
  ADD CONSTRAINT `ouvrage_serie2_FK` FOREIGN KEY (`id_serie`) REFERENCES `serie` (`id_serie`);

--
-- Contraintes pour la table `visuel`
--
ALTER TABLE `visuel`
  ADD CONSTRAINT `visuel_ouvrage_FK` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`id_ouvrage`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
