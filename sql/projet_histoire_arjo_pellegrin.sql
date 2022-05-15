-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 15 mai 2022 à 15:36
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_histoire_arjo_pellegrin`
--
CREATE DATABASE IF NOT EXISTS `projet_histoire_arjo_pellegrin` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `projet_histoire_arjo_pellegrin`;

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

CREATE TABLE IF NOT EXISTS `choix` (
  `id_page` varchar(11) NOT NULL,
  `id_page_cible` varchar(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `contenu` varchar(100) NOT NULL,
  `nb_pdv_perdu` int(5) NOT NULL,
  PRIMARY KEY (`id_page`,`id_page_cible`,`id_hist`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `choix`
--

INSERT INTO `choix` (`id_page`, `id_page_cible`, `id_hist`, `contenu`, `nb_pdv_perdu`) VALUES
('0', 'A1', 13, 'Le point d\'eau', 0),
('0', 'A1', 34, 'Vert sur fond foncé', 0),
('0', 'A2', 13, 'L\'arche obscure', 0),
('0', 'A2', 34, 'Bleu sur fond blanc', -3),
('0', 'A3', 34, 'Noir sur fond rose', -3),
('A1', '0', 13, 'Faire demi-tour', 0),
('A1', 'A1B1', 13, 'Lancer le caillou', -3),
('A1', 'A1B2', 13, 'Aller se baigner', -3),
('A1', 'FIN', 34, '', 0),
('A1B1', 'FIN', 13, 'oui', 0),
('A1B2', 'FIN', 13, 'oui', 0),
('A2', 'A2B1', 13, 'Ne pas crier', -3),
('A2', 'A2B2', 13, 'Crier', 0),
('A2', 'FIN', 34, '', 0),
('A2B1', 'FIN', 13, 'oui', 0),
('A2B2', 'A2B2C1', 13, 'Négocier', 0),
('A2B2', 'A2B2C2', 13, 'S enfuir avec Zeele', 0),
('A2B2', 'A2B2C3', 13, 'Faire un octogone', -3),
('A2B2C1', 'FIN', 13, 'oui', 0),
('A2B2C2', 'FIN', 13, 'oui', 0),
('A2B2C3', 'FIN', 13, 'oui', 0),
('A3', 'FIN', 34, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `histoire`
--

CREATE TABLE IF NOT EXISTS `histoire` (
  `id_hist` int(11) NOT NULL AUTO_INCREMENT,
  `nom_hist` varchar(70) NOT NULL,
  `illustration` varchar(50) NOT NULL,
  `synopsis` varchar(2000) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `nb_fois_jouee` int(11) DEFAULT 0,
  `nb_reussites` int(11) DEFAULT 0,
  `nb_morts` int(11) DEFAULT 0,
  `cache` int(1) NOT NULL,
  PRIMARY KEY (`id_hist`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`id_hist`, `nom_hist`, `illustration`, `synopsis`, `id_createur`, `nb_fois_jouee`, `nb_reussites`, `nb_morts`, `cache`) VALUES
(13, 'Zoubi dans la forêt', 'img_hist_13.jpg', 'Je vous présente Zoubi. Ce jeune adolescent est tombé fou amoureux il y a quelques jours de la petite nouvelle ayant débarqué dans son établissement scolaire. Elle s’appelle Zadie, possède un organe cérébral super développé, est très attentionnée envers ses petits camarades de classe, et, je cite Zoubi, elle est également “vraiment trop pipoudax”.\r\n', 2, 32, 12, 20, 0),
(34, 'Noémie et Justine en comm web', 'img_hist_35.jpg', 'Noémie et Justine doivent réaliser un site web pour leur projet informatique. Les choix qu\'elles vont faire seront déterminants.', 1, 5, 4, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `hist_jouee`
--

CREATE TABLE IF NOT EXISTS `hist_jouee` (
  `id_hist` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `choix_eff` varchar(20) NOT NULL,
  `nb_pts_vie` int(11) NOT NULL,
  `choix` varchar(200) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id_user`,`id_hist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `hist_jouee`
--

INSERT INTO `hist_jouee` (`id_hist`, `id_user`, `choix_eff`, `nb_pts_vie`, `choix`) VALUES
(13, 1, '0', 3, ''),
(13, 2, '0', 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `page_hist`
--

CREATE TABLE IF NOT EXISTS `page_hist` (
  `id_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_hist` int(11) NOT NULL,
  `para_1` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `para_2` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_3` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_4` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_5` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_1` varchar(600) COLLATE utf8_unicode_ci NOT NULL,
  `img_2` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_3` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_4` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_5` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_page`,`id_hist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `page_hist`
--

INSERT INTO `page_hist` (`id_page`, `id_hist`, `para_1`, `para_2`, `para_3`, `para_4`, `para_5`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`) VALUES
('0', 13, 'Bienvenue sur la planète Ziblub. A des années lumières du système solaire, ce monde abrite une civilisation pacifiste et bienveillante de grenouilles extraterrestres, vivant en parfaite harmonie avec l’écosystème environnant. Le rêve quoi. \r\nEnfin presque. Il se trouve que ces espèces de grenouilles, les Zelophylax, semblent encore avoir l’esprit un peu arriéré. En effet, la tradition veut que les Zelophylax mâles conquièrent l’organe cardiaque de leur dulcinée avec un sublime bouquet de fleurs exotiques. C’est la seule méthode de séduction prise au sérieux sur Ziblub. Autant vous dire que les jardiniers et fleuristes du coin sont vraiment blindés. ', 'Je vous présente Zoubi. Ce jeune adolescent est tombé fou amoureux il y a quelques jours de la petite nouvelle ayant débarqué dans son établissement scolaire. Elle s’appelle Zadie, possède un organe cérébral super développé, est très attentionnée envers ses petits camarades de classe, et, je cite Zoubi, elle est également “vraiment trop pipoudax”.\r\nVous l’aurez compris, Zoubi a les zormones en feu est prêt à tout pour cette charmante demoiselle. Y compris de lui offrir le plus beau bouquet de fleurs qu’elle n’ait jamais vu. Cependant, les parents de Zoubi ne lui donnent pas d’argent de poche, et il n’a donc pas de quoi acquérir ces sublimes fleurs exotiques.', 'Toutefois, Zoubi n’est pas du genre à se dégonfler. Il sait que supplier ses parents ne sert à rien, mais il a une autre idée en tête pour aller trouver des fleurs colorées et parfumées. Muni juste d’un sac, et sûrement un peu trop candide, il part léger et court vêtu à la lisière de la forêt, où il est sûr de trouver ce qu’il désire tant.\r\nNotre jeune grenouille s’enfonce à travers les buissons, franchit des troncs d’arbres barrant sa route et laisse les rayons de lumières traversant les sapins réchauffer sa peau crapauteuse. Soudain, le sentier qu’il suivait jusqu’à présent se divise en trois. Stoïque, Zoubi scrute chaque chemin avec attention.', '    Le premier chemin l\'amène à une sorte de point d’eau. De ce dernier semble émaner une douce lumière bleutée. \r\n    L’entrée du deuxième chemin est faite d’arbres entrelacés, et forment une arche. Derrière, rien n’est perceptible à cause de la pénombre. On ne voit qu’une faible lueur orangée bouger.\r\n    Enfin, au bout du dernier chemin se dessine dans l’ombre une petite cabane, éclairée avec une lumière rose scintillante.\r\n\r\n    Quel chemin Zoubi doit-il prendre ?\r\n', '', 'img_0_1.jpg', 'img_0_2.jpg', 'img_0_3.jpg', 'img_0_4.jpg', ''),
('0', 34, 'Noémie et Justine doivent réaliser un site web accessible d\'elles-mêmes. Quelles couleurs vont-elles choisir ?', '', ' ', ' ', ' ', '', '', '', '', ''),
('A1', 13, 'Intrigué par cette douce couleur bleue, Zoubi empreinte le chemin l’amenant à ce point d’eau. Arrivant devant celui-ci, il constate qu’une grenouille d’une autre espèce que la sienne prend son bain dans ce bassin merveilleux. En effet, de somptueux lotuz bleus inondent ce coin de la forêt d’une lumière harmonieuse et d’une odeur délicate. La grenouille inconnue se retourne enfin vers Zoubi, ayant remarqué sa présence. Ce dernier a un mouvement de recul face à cette dernière, qui a la peau de la même couleur que les fleurs autour d’elle, ce qui n’est vraiment pas commun.', '- Bonjour jeune homme, susurra la mystérieuse grenouille.\r\n- Euhm, je… B-bonjour ! Je ne voulais pas vous déranger madame, je suis à la recherche de fleurs et j’ai aperçu ce bassin au loin, explique Zoubi, légèrement paniqué.\r\n- Mais tu ne me déranges pas, au contraire ! Regarde, il y a de sublimes fleurs dans ce bassin : viens te baigner avec moi et tu en récupéreras quelques-unes après t’être relaxé dans cette eau si pure…\r\n- C’est-à-dire que j’ai déjà pris une douche et je…\r\n- Viens ! crie la créature bleue, hystérique.\r\n- Non mais je…\r\n- Baigne toi avec moi ! hurle-t-elle.', '    Zoubi, décontenancé par cette soudaine agressivité, recule mais trébuche sur un caillou. Miskine.\r\n    Dans la panique, il envisage d’abord de lancer ce caillou sur cette grenouille afin de l\'assommer, récupérer ces lotuz et se barrer de cette forêt une bonne fois pour toutes.\r\n    Ou alors, il peut aussi se prêter à son jeu, et se baigner avec elle et suivre sa proposition. Mais il a un mauvais pressentiment.\r\n    Finalement, Zoubi peut aussi prendre la fuite s’il arrive à se relever.\r\n\r\n    Que doit faire Zoubi ?\r\n', '', '', 'img_a1.jpg', '', '', '', ''),
('A1', 34, 'Mhm, elles ont effectivement choisi ces couleurs, bien joué...', ' ', ' ', ' ', ' ', '', '', '', '', ''),
('A1B1', 13, 'D’un élan de peur, Zoubi saisit le gros caillou sur lequel il est tombé, et le lance de toutes ses forces sur la grenouille bleue. Heureusement que Zoubi est un pro du handball, car cette dernière se prend le projectile en pleine face, et tombe en arrière dans l’eau. Après quelques secondes sans bouger, Zoubi s’approche du bassin : la mystérieuse créature semble dans les vapes et soudainement inoffensive. Zoubi en profite immédiatement, se penche vers une fleur, et tire de toutes ces forces avec ses petites pattes. Alors que la racine du lotuz s’arrache, le lotuz bleu libère soudainement des spores. Zoubi ne cesse de tousser. Ce qu’il ne sait pas encore, c’est que ces spores sont hautement addictives… Omnibulé par leurs lumières, Zoubi semble perdre son âme en un instant. Pour ne plus jamais se passer de cette substance, il se baigne dans le point d’eau, et sa peau commence à devenir bleue…', '', '', '', '', 'img_a1b1.jpg', '', '', '', ''),
('A1B2', 13, '- D’accord, d’accord ! s’écrie Zoubi, apeuré. Je vais venir me baigner avec vous.\r\n    Zoubi pose son sac au bord du bassin et vient tremper ses pattes palmées dans l’eau bleue.\r\n- Tu vois, je t’avais dit que ce serait agréable, roucoule la grenouille bleue. Tu comprends, je suis seule ici, personne ne vient jamais… Ça me fait plaisir d’avoir un peu de compagnie.\r\n- O-ouais, je comprends… balbutie le jeune homme, décontenancé. Bon, du coup, vous ne m\'en voulez pas hein, mais je vais récupérer un ou deux lotuz moi…\r\n    Zoubi s’exécute et sort de l’eau. Mais ses pieds ont changé de couleur : ils sont tout bleus. Et en y regardant de plus près, la teinte se répand jusqu’à ses mollets. Ce bassin serait-il donc toxique ? Avant que Zoubi ait la réponse, il sent que la grenouille bleue le saisit par la patte, et le fait plonger tout entier dans le bassin.\r\n    Ses parents lui avaient pourtant dit de ne pas parler aux inconnus…\r\n', '', '', '', '', 'img_a1b2.jpg', '', '', '', ''),
('A2', 13, 'Zoubi prend son courage à demain, et marche voûté sous la petite arche. Plus il avance, plus la lumière orangée se fait distincte. Il est fasciné par les variétés d’arbres qui constituent ce drôle de chemin. Au bout de cette sorte de tunnel, un champ de zulipes aux couleurs vives et chaudes s’étend dans une clairière. Le soleil vient directement taper les fleurs de son éclat. De l’autre côté de l’étendue de fleurs, une petite grenouille lit sous un pommier. Zoubi est émerveillé par cette vue incroyable. Une chose le tire de ce rêve : juste à côté de lui, il y a un petit panneau en bois. Le jeune homme lit dans sa tête son message : “Ne pas crier !! Merci <3”.\r\n\r\n    Zoubi ne peut s’empêcher un rictus, très tenté de voir qu’est-ce que ça provoquerait. Alors, il crie ou ne crie pas ?\r\n', '', '', '', '', 'img_a2.jpg', '', '', '', ''),
('A2', 34, '... Non, il fallait mieux regarder...', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
('A2B1', 13, 'Zoubi se ravise. Il ne s’agirait pas de faire une grosse bêtise. Il s’avance vers le champ de zulipes. Juste avant qu’il ne s’avance plus, la petite grenouille remarque sa présence, et fait une tête terrible en voyant Zoubi si près du champ. Aussitôt, elle pousse un cri, mais il est trop tard : notre jeune homme a marché sur un piège entourant la parcelle de fleurs. Ce qu’il ne savait pas, c’est que celui-ci se serait désactivé au bruit. Le piège métallique se referme sur son mollet et Zoubi hurle de toutes ses forces. La petite grenouille accourt vers lui, les pièges étant maintenant tous désactivés. Elle est horrifiée devant la scène qui s’offre à elle : les zulipes sont maintenant bien rouges, et notre jeune Zelophylax continue de crier de douleur et de pleurer…', 'On peut dire qu’il est mal en point, petit euphémisme pour dire qu’il a la jambe en sang. Heureusement que la jeune fille a un téléphone de la marque ZiPhone pour appeler les urgences… Zoubi aura peut-être sa jambe de sauvée, mais en tout cas, il n’aura pas de zulipes à ramener à Zadie.', ' ', ' ', NULL, 'img_a2b1.jpg', ' ', ' ', ' ', ' '),
('A2B2', 13, 'Zoubi bombe le torse en prenant une grande inspiration, et crie, je cite, “wesh alors”, en hommage à son auteur-compositeur-interprète préféré. Plusieurs claquements stridents résonnent alors dans la clairière, et la jeune grenouille au loin sursaute, décrochant complètement de sa lecture. Voyant Zoubi qui vient de crier, elle souffle de soulagement.- C’était quoi cet énorme bruit ? Demande notre jeune Zelophylax, étonné.- C’était le bruit des pièges qui se ferment ! Répondit l’autre. On protège notre exploitation de zulipes des voleurs qui viennent les dérober en catimini avec des pièges activés aux bruits. Heureusement que tu as crié, sinon tu te serais fait bouffer le pied.- Ah, bah c’est sympa ça dis d…- T’es pas un voleur au moins hein ? s’écrie la jeune fille.- Non non pas du tout ! Enfin, je cherche des fleurs, mais je ne suis pas là pour les voler. La grenouille inconnue se lève et traverse les tulipes sans les écraser pour s’arrêter devant Zoubi.', '- Enchantée dans ce cas, je m’appelle Zeele, je suis la fille des fleuristes de la ville, déclare-t-elle en tendant sa main à Zoubi.- Oh mais trop chanmax ! s’exclame le jeune homme, en serrant sa patte. Moi c’est Zoubi, enchanté également. Dis, tu me donnerais une de tes belles zulipes ? Elles sont incroyables, et j’aimerai vraiment offrir un beau bouquet à ma dulcinée.- Tu as déjà une dulcinée ? Tu ne m’as pas l’air très vieux pourtant…- J’ai 13 ans ! …Et demi…!- D’accord, je vois… Je veux bien t’en donner, mais uniquement si tu acceptes d’être mon ami, proclame-t-elle.- Avec plaisir ! répond  Zoubi, enthousiaste.', 'Esquissant un sourire, Zeele se penche et récupère délicatement trois zulipes oranges. Prenant en plus des herbes sauvages, la jeune grenouille construit un sublime bouquet qu’elle s’empresse d’offrir à Zoubi. En prenant les fleurs dans ses pattes, le cœur de Zoubi palpite. Zadie semble soudainement avoir disparu…Tout à coût, une voix grave résonne dans la clairière. - Ne t’approche pas de ma fille de la sorte ! ordonne l’homme. Et rends les fleurs que tu viens de lui voler.', 'Zoubi se retourne, apeuré et les genoux tremblants. C’est le jardinier du village ! Il paraît aussi menaçant que Ganondorf aux yeux du jeune homme. Il commence à bégayer mais Zeele intervient :- Papa, Zoubi est gentil, et c’est moi qui lui ai offert les fleurs.L’immense père grenouille ne répond pas. Il attend les bras croisés, et semble prêt à en découdre.Zoubi ne voit que trois solutions. Dans l’immédiat, il songe à fuir le plus vite possible vers un endroit sécurisé, avec la charmante Zeele. Cependant, sa raison le pousse à négocier pour garder les fleurs. Ou alors, il fait l’énorme taré et il attaque ce daron ultra stock.Alors, que doit faire Zoubi ?', '', 'img_a2b2.jpg', 'img_a2b22.jpg', 'img_a2b23.jpg', '', ''),
('A2B2C1', 13, 'Le temps est venu des négociations. Zoubi inspire un bon coup, et proclame calmement :\r\n- Ce que dit votre fille est vrai Monsieur. Zeele m’a offert ces fleurs, car j’en cherchais dans la forêt. Je ne souhaitais vraiment pas les voler, ni déranger votre fille pendant sa lecture, je suis désolé. J’aurais cependant besoin de ces fleurs, malgré tout. Si cela vous convient, je m’en vais par où je suis venu, sans plus faire d’histoire. Qu’en dites-vous ?\r\n\r\nLe jardinier souffle fort. D’un geste de la main, lassé, il lui fait signe de partir. Zoubi sourit, un peu soulagé. Il se tourne vers Zeele, qui a un petit sourire en coin, mais le regard triste. Elle lui fait un signe de la main, et Zoubi le lui rend, tout en débarrassant le plancher, de peur que son père ne change d’avis avant qu’il n’ait pu déguerpir.\r\nZoubi va pouvoir ramener ses fleurs à Zadie, en espérant qu’elle les aime et qu’elle ne soit pas allergique aux zulipes.', NULL, NULL, NULL, NULL, 'img_a2b2c1.jpg', NULL, NULL, NULL, NULL),
('A2B2C2', 13, 'Pas le temps de niaiser, il faut courir. Zoubi prend Zeele par la patte, fleurs sous le bras, et ils se lancent dans une course effrénée. Le jardinier se met à leur poursuite. Si le jeune homme a réellement la trouille, Zeele prend ça plutôt comme un jeu et rigole à gorge déployée pendant ce sprint. Ca saute au-dessus de troncs d’arbres et contourne des obstacles que la forêt crée devant eux. Après un certain temps, Zoubi ose un regard derrière lui, et constate que le papa de la jeune fille ne les suit plus. Il freine automatiquement sa course, haletant, maintenant poussé de l’avant par Zeele. \\r\\n- Je vais te montrer le chemin pour sortir de la forêt, ne t’inquiète pas, dit-elle, aussi essoufflée. Mais d’abord, on va aller à ma cabane secrète !\r\nLes yeux de Zoubi se mettent à briller : trop stylax une cabane ! En effet, quelques mètres plus loin, une petite construction de bois et de fleurs se dresse sous un cerisier en fleur. Zeele l’invite à rentrer, et Zoubi découvre avec merveille un tapis de fleurs colorées, douces et délicates. C’est littéralement l’endroit le plus fantastique qu’il n’ait jamais vu. Peut-être qu’il va rester avec Zeele plus longtemps que prévu…!', NULL, NULL, NULL, NULL, 'img_a2b2c2.jpg', NULL, NULL, NULL, NULL),
('A2B2C3', 13, 'Ok. Visiblement Zoubi a un élan beaucoup trop soudain de courage. Il fronce les sourcils, et s’avance de manière très déterminée vers le jardinier, les points serrés. Notre protagoniste n’a pas le temps de dire un mot que le papa très baraqué lui décoche le plus gros uppercut qu’il ne se soit jamais pris de sa vie. Zoubi est complètement KO, et s’il a de la chance, il s’en sortira avec seulement deux dents cassées.\r\nFallait s’y attendre en même temps…', NULL, NULL, NULL, NULL, 'img_a2b2c3.jpg', NULL, NULL, NULL, NULL),
('A3', 34, '... Bah non, y\'a que du vert...', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(50) NOT NULL AUTO_INCREMENT,
  `est_admin` int(1) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `est_admin`, `pseudo`, `mdp`) VALUES
(1, 1, 'correcteur_admin', '$2y$10$NU8kGANRliJGln6Gy9yZCOErZgjcx4LKDNLrJEFlSEH8NMdLv7Bl2'),
(2, 0, 'correcteur', '$2y$10$NU8kGANRliJGln6Gy9yZCOErZgjcx4LKDNLrJEFlSEH8NMdLv7Bl2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
