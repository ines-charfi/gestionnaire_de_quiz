-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 14 fév. 2025 à 08:55
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `quiz_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `id_quizzes` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quizzes_id` (`id_quizzes`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `description`, `id_quizzes`) VALUES
(1, '2. Quel groupe a chanté \"Bohemian Rhapsody\" ?', 2),
(2, '3. Quel instrument est au cœur du groupe The Doors ?', 2),
(3, '1. Qui a réalisé le film \"Inception\" ?', 3),
(4, '2. Quel acteur incarne Jack Dawson dans le film \"Titanic\" ?', 3),
(5, '3. Dans quel film retrouve-t-on le personnage de \"Darth Vader\" ?', 3),
(6, '1. Quelle est la capitale de l\'Australie ?', 1),
(7, '2. Qui a écrit \"Les Misérables\" ?', 1),
(8, '3. Quel est l\'élément chimique représenté par le symbole \"O\" ?', 1),
(9, '1. Quel est le système d\'exploitation développé par Microsoft ?', 4),
(10, '2. Quel langage de programmation est principalement utilisé pour le développement web côté serveur ?', 4),
(11, '3. Que signifie l\'acronyme \"CPU\" ?', 4),
(12, '1. Quel est l\'organe principal de la respiration chez l\'homme ?', 6),
(29, '1. Qui est l\'interprète de la chanson \"Like a Virgin\" ?', 2),
(30, '2. Quelle est la formule chimique de l\'eau ?', 6),
(31, '3. Qui a proposé la théorie de l\'évolution par sélection naturelle ?', 6),
(32, '1. Qui a remporté la Coupe du Monde de football en 2018 ?', 18),
(33, '2. Dans quel sport Michael Jordan a-t-il marqué l’histoire ?', 18),
(34, '3. Quelle est la distance d\'un marathon ?', 18),
(35, '1. Quelle est l’œuvre majeure de F. Scott Fitzgerald ?', 20),
(36, '2. Qui a écrit \"L\'Étranger\" ?', 20),
(37, '3. Dans quel roman de George Orwell trouve-t-on \"Big Brother\" ?', 20);

-- --------------------------------------------------------

--
-- Structure de la table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(500) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `quizzes`
--

INSERT INTO `quizzes` (`id`, `image`, `titre`, `description`, `id_user`) VALUES
(1, '../images/culture.jpg', 'Culture générale', 'Découvre les quiz les plus prisés ! Lance toi dans l&#039;aventure des quiz de culture générale, un défi à relever en solo ou à partager avec des amis. Joue, apprends et amuse toi.', 1),
(2, 'musique.jpg', 'Musique', 'Nos plus de 15 questions à utiliser dans les quiz musicaux couvrent un large éventail de genres, artistes et époques, des quiz de musique rock classique et des hits pop aux succès actuels', 2),
(3, 'cinéma.jpg', 'Cinéma', ' Ce quiz sur le cinéma vous permettront de tester vos connaissances et d&#039;apprendre\r\nde nouvelles choses pour votre culture personnelle !', 3),
(4, 'informatique.jpg', 'Informatique', 'Vous trouverez ici une sélection de quiz en informatique gratuit, conçus pour tester vos\r\ncompétences et approfondir vos connaissances sur divers sujets. ', 1),
(6, 'simple.jpg', 'Sciences', 'Explorez des concepts clés de la biologie, la chimie et la physique à travers des questions scientifiques fascinantes.', 1),
(18, 'SPORT.jpg', 'SPORT', 'Testez vos connaissances sur les grands événements sportifs, les athlètes légendaires et les records du monde.', 2),
(20, 'LITTERATURE.jpg', 'Littérature', 'Plongez dans l\'univers des grands auteurs, romans classiques et personnages inoubliables à travers des questions qui testent vos connaissances sur les œuvres majeures de l\'histoire littéraire.', 1),
(21, 'quiz.jpg', 'KIDS', 'Un simple quiz dédié aux enfants pour s\"amuser avec leur famille', 2);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `questions_id` int NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`questions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id`, `description`, `questions_id`, `is_correct`) VALUES
(10, 'B) Britney Spears\r\n', 29, 0),
(11, 'C) Cher\r\n', 29, 0),
(12, 'C) Led Zeppelin\r\n', 1, 0),
(14, 'B) Queen\r\n\r\n', 1, 1),
(15, 'C) The Beatles\r\n\r\n\r\n\r\n', 1, 0),
(16, '\r\nA) Guitare\r\n\r\n\r\n', 2, 0),
(17, 'B) Piano\r\n\r\n', 2, 1),
(18, 'C) Batterie\r\n\r\n', 2, 0),
(19, 'A) Christopher Nolan\r\n\r\n\r\n', 3, 1),
(20, 'B) Quentin Tarantino\r\n\r\n\r\n\r\n', 3, 0),
(21, 'C) Steven Spielberg', 3, 0),
(22, 'A) Brad Pitt', 4, 0),
(23, 'B) Leonardo DiCaprio', 4, 1),
(24, 'A) Madonna\r\n\r\n', 29, 1),
(25, '\r\nC) Johnny Depp\r\n', 4, 0),
(26, 'C) Jurassic Park', 5, 0),
(27, 'B) Avatar', 5, 0),
(28, 'A) Star Wars', 5, 1),
(29, 'A) Sydney\r\n', 6, 1),
(30, 'B) Canberra\r\n', 6, 0),
(31, 'C) Melbourne', 6, 0),
(32, 'A) Gustave Flaubert', 7, 0),
(33, 'B) Victor Hugo\r\n', 7, 1),
(34, '\r\nB) Émile Zola\r\n', 7, 0),
(35, 'A) Or\r\n', 8, 0),
(36, '\r\nB) Oxygène\r\n', 8, 1),
(37, '\r\nC) Osmium', 8, 0),
(38, 'A) Linux\r\n', 9, 0),
(39, '\r\nB) Windows\r\n', 9, 1),
(40, '\r\nC) macOS', 9, 0),
(41, 'A) Python\r\n', 10, 0),
(42, '\r\nB) JavaScript\r\n', 10, 0),
(43, '\r\nC) PHP', 10, 1),
(44, 'A) Central Processing Unit\r\n', 11, 1),
(45, '\r\nB) Central Program Unit\r\n', 11, 0),
(46, '\r\nC) Central Power Unit', 11, 0),
(47, 'A) Le cœur\r\n', 12, 0),
(48, '\r\nB) Les poumons\r\n', 12, 1),
(49, '\r\nC) Le foie', 12, 0),
(50, 'A) CO2\r\n', 30, 0),
(51, '\r\nB) H2O\r\n', 30, 1),
(52, '\r\nC) O2', 30, 0),
(53, 'A) Isaac Newton\r\n', 31, 0),
(54, '\r\nB) Albert Einstein\r\n', 31, 0),
(55, '\r\nC) Charles Darwin', 31, 1),
(56, 'A) Brésil\r\n', 32, 0),
(57, '\r\nB) Allemagne\r\n', 32, 0),
(58, '\r\nC) France', 32, 1),
(59, 'A) Football\r\n', 33, 0),
(60, '\r\nB) Tennis\r\n', 33, 0),
(61, '\r\nC) Basketball', 33, 1),
(62, 'A) 21,5 km\r\n', 34, 0),
(63, '\r\nB) 42,195 km\r\n', 34, 1),
(64, '\r\nC) 50 km', 34, 0),
(65, 'A) Moby Dick\r\n', 35, 0),
(66, '\r\nB) Gatsby le Magnifique\r\n', 35, 1),
(67, '\r\nC) Les Misérables', 35, 0),
(68, 'A) Jean-Paul Sartre\r\n', 36, 0),
(69, '\r\nB) Albert Camus\r\n', 36, 1),
(70, '\r\nC) Simone de Beauvoir', 36, 0),
(71, 'A) La Ferme des animaux\r\n', 37, 0),
(72, '\r\nB) 1984\r\n', 37, 1),
(73, '\r\nC) Hommage à la Catalogne', 37, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'alex.bachir@laplateforme.io', '1234'),
(2, 'meriam.goudadi@laplateforme.io', '1234'),
(3, 'ines.charfi@laplateforme.io', '1234'),
(5, 'John Doe', 'john.doe@example.com'),
(7, 'ines.charfi@laplateforme.io', '$2y$10$e4qa7z.KSq.EAqTr32Vtr.60jgV7L6EmrTSi8sSNlCIQjnVDFVKly'),
(8, 'ines.charfi@laplateforme.io', '$2y$10$hWlEXkW440ZqQHCjZ6ujzOwQtdzKKVWIIQ3.F67VBjwdE5LaOR4oe'),
(9, 'ines.charfi@laplateforme.io', '$2y$10$ZIPWitoxqbD42JyuQgRbkOGUx5HMQqmvT7yV1P8wLBLdjBrdrtqt.'),
(10, 'ines.charfi@laplateforme.io', '$2y$10$R1akaBxznRzMpt/314.JwOMZ1npZX7ESgW5zpD9BQ6xV2ccarItrW'),
(11, 'ines.charfi@laplateforme.io', '$2y$10$fiuGbLgkaOIn91I6.U8O/esNQsThBiO8WiLt53tXt3eqHwkSJLnC6'),
(12, 'ines.charfi@laplateforme.io', '$2y$10$YHg4mGlikXqS0PIaaOTVoO5R4XR/9jVtUOkrxh6/8K/joaKxgdX.O'),
(13, 'ines.charfi@laplateforme.io', '$2y$10$Cnes94nBPRyMSLbkPL98oeMYXQY7qyEUlB.4IebI7S6Kf9Z.xe17i'),
(14, 'ines.charfi@laplateforme.io', '$2y$10$qLlgcQd6K7vHgdbefi.VS.Bm5BTWzIn2TxcWI9vqioDzo9D0/D0fq'),
(15, 'ines.charfi@laplateforme.io', '$2y$10$95TzkL60WqmiUvvGlp0kW.4BEHazr9DbRVdux6.Avp5geB59HydSq'),
(16, 'ines.charfi@laplateforme.io', '$2y$10$wvfKZHDbsV7E8GATBNEYXOetvhQwV33/hh6QrZD.vQP48ekXn9uuW'),
(17, 'ines.charfi@laplateforme.io', '$2y$10$gtq5LxtJQfXirwDMJTi7G.8OziuZJo.SOQ1wFtKsskwK5j2UmmFCC'),
(18, 'ines.charfi@laplateforme.io', '$2y$10$9NqANHJJ.zs7Kzx15.PyGu8aiViSUdv4dRogSuVgp7WQT1B4jJPBu'),
(19, 'ines.charfi@laplateforme.io', '$2y$10$WsTUvZhPvnPWKTOcgvjJk.oBD1THmOcWsLKaKFUYrWEVC.tVlLqHe'),
(20, 'ines.charfi@laplateforme.io', '$2y$10$cQMkLbO1/aE4z5o59cIDNuYjv1z6DDWsyPjdG3XrEsZuz/ez9JMRu');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_quizzes`) REFERENCES `quizzes` (`id`);

--
-- Contraintes pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
