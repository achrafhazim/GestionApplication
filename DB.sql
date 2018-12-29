-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 16 août 2018 à 22:50
-- Version du serveur :  10.2.16-MariaDB
-- Version de PHP :  7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `comptable`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id` int(10) NOT NULL,
  `net_a_payer` double NOT NULL,
  `mode$paiement` int(11) NOT NULL,
  `N_mode` varchar(200) NOT NULL,
  `date_paiement` date NOT NULL,
  `fichier` varchar(250) DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL,
  `raison$sociale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `date_negociation` date NOT NULL,
  `montant_factures_TTC` double NOT NULL,
  `montant_avoirs_TTC` double NOT NULL DEFAULT 0,
  `Reglement_TTC` double NOT NULL DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$Achats`
--

CREATE TABLE `autorisation$Achats` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 0,
  `modifier` tinyint(4) DEFAULT 0,
  `effacer` tinyint(4) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$Comptes`
--

CREATE TABLE `autorisation$Comptes` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 0,
  `modifier` tinyint(4) DEFAULT 0,
  `effacer` tinyint(4) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$CRM`
--

CREATE TABLE `autorisation$CRM` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 1,
  `modifier` tinyint(4) DEFAULT 1,
  `effacer` tinyint(4) DEFAULT 1,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$Statistique`
--

CREATE TABLE `autorisation$Statistique` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 0,
  `modifier` tinyint(4) DEFAULT 0,
  `effacer` tinyint(4) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$Transactions`
--

CREATE TABLE `autorisation$Transactions` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 0,
  `modifier` tinyint(4) DEFAULT 0,
  `effacer` tinyint(4) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `autorisation$Ventes`
--

CREATE TABLE `autorisation$Ventes` (
  `id` int(10) NOT NULL,
  `comptes` int(11) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `voir` tinyint(4) DEFAULT 1,
  `ajouter` tinyint(4) DEFAULT 0,
  `modifier` tinyint(4) DEFAULT 0,
  `effacer` tinyint(4) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `avoirs$achats`
--

CREATE TABLE `avoirs$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_avoirs_HT` double NOT NULL,
  `montant_avoirs_TVA` double NOT NULL,
  `montant_avoirs_TTC` double NOT NULL,
  `les_articles` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bons$achats`
--

CREATE TABLE `bons$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `adresse` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) NOT NULL,
  `clients` varchar(200) NOT NULL,
  `cin` varchar(200) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `commentaires_remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_estime_HT` double NOT NULL,
  `adresse` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` int(10) NOT NULL,
  `comptes` varchar(200) NOT NULL,
  `login` varchar(201) NOT NULL,
  `password` varchar(202) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `Prenom` varchar(201) NOT NULL,
  `Nom` varchar(201) NOT NULL,
  `TELE` varchar(20) NOT NULL,
  `GSM` varchar(20) DEFAULT NULL,
  `Fonction` varchar(201) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `remarque` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures$achats`
--

CREATE TABLE `factures$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `remarque` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures$ventes`
--

CREATE TABLE `factures$ventes` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `titre` varchar(200) NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mode$paiement`
--

CREATE TABLE `mode$paiement` (
  `id` int(10) NOT NULL,
  `mode$paiement` varchar(200) NOT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `raison$sociale`
--

CREATE TABLE `raison$sociale` (
  `id` int(10) NOT NULL,
  `raison$sociale` varchar(200) NOT NULL,
  `ICE` varchar(200) NOT NULL,
  `I_F` varchar(201) NOT NULL,
  `T_P` varchar(201) NOT NULL,
  `R_C` varchar(201) NOT NULL,
  `CNSS` varchar(200) NOT NULL,
  `TELE1` varchar(20) NOT NULL,
  `TELE2` varchar(20) DEFAULT NULL,
  `GSM` varchar(20) DEFAULT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `site_web` varchar(200) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `fichiers` varchar(250) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_achat`
--

CREATE TABLE `r_achats_achat` (
  `id_achats` int(11) NOT NULL,
  `id_achat` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_avoirs$achats`
--

CREATE TABLE `r_achats_avoirs$achats` (
  `id_achats` int(11) NOT NULL,
  `id_avoirs$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_factures$achats`
--

CREATE TABLE `r_achats_factures$achats` (
  `id_achats` int(11) NOT NULL,
  `id_factures$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_avoirs$achats_bons$achats`
--

CREATE TABLE `r_avoirs$achats_bons$achats` (
  `id_avoirs$achats` int(11) NOT NULL,
  `id_bons$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_avoirs$achats_factures$achats`
--

CREATE TABLE `r_avoirs$achats_factures$achats` (
  `id_avoirs$achats` int(11) NOT NULL,
  `id_factures$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_bons$achats_commandes`
--

CREATE TABLE `r_bons$achats_commandes` (
  `id_bons$achats` int(11) NOT NULL,
  `id_commandes` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_commandes_clients`
--

CREATE TABLE `r_commandes_clients` (
  `id_commandes` int(11) NOT NULL,
  `id_clients` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_factures$achats_bons$achats`
--

CREATE TABLE `r_factures$achats_bons$achats` (
  `id_factures$achats` int(11) NOT NULL,
  `id_bons$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_factures$ventes_devis`
--

CREATE TABLE `r_factures$ventes_devis` (
  `id_factures$ventes` int(11) NOT NULL,
  `id_devis` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_ventes_factures$ventes`
--

CREATE TABLE `r_ventes_factures$ventes` (
  `id_ventes` int(11) NOT NULL,
  `id_factures$ventes` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `mode$paiement` int(11) NOT NULL,
  `date` date NOT NULL,
  `montant_factures_TTC` double NOT NULL,
  `montant_paye_TTC` double NOT NULL,
  `Creances_TTC` double DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depanse_ibfk_2` (`mode$paiement`),
  ADD KEY `depense_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseur` (`raison$sociale`);

--
-- Index pour la table `autorisation$Achats`
--
ALTER TABLE `autorisation$Achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_Achats` (`comptes`);

--
-- Index pour la table `autorisation$Comptes`
--
ALTER TABLE `autorisation$Comptes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_Comptes` (`comptes`);

--
-- Index pour la table `autorisation$CRM`
--
ALTER TABLE `autorisation$CRM`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_CRM` (`comptes`);

--
-- Index pour la table `autorisation$Statistique`
--
ALTER TABLE `autorisation$Statistique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_Statistique` (`comptes`);

--
-- Index pour la table `autorisation$Transactions`
--
ALTER TABLE `autorisation$Transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_Transactions` (`comptes`);

--
-- Index pour la table `autorisation$Ventes`
--
ALTER TABLE `autorisation$Ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorisation_Ventes` (`comptes`);

--
-- Index pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `FOURNISSEUR` (`raison$sociale`);

--
-- Index pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `fournisseur` (`raison$sociale`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devisss` (`clients`);

--
-- Index pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `Fournisseur` (`raison$sociale`);

--
-- Index pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FV_ibfk_1` (`clients`);

--
-- Index pour la table `mode$paiement`
--
ALTER TABLE `mode$paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `raison$sociale`
--
ALTER TABLE `raison$sociale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RAISON_SOCIALE` (`raison$sociale`),
  ADD UNIQUE KEY `ICE` (`ICE`),
  ADD UNIQUE KEY `I-F` (`I_F`),
  ADD UNIQUE KEY `CNSS` (`CNSS`),
  ADD UNIQUE KEY `T-P` (`T_P`),
  ADD UNIQUE KEY `R-C` (`R_C`);

--
-- Index pour la table `r_achats_achat`
--
ALTER TABLE `r_achats_achat`
  ADD PRIMARY KEY (`id_achats`,`id_achat`),
  ADD KEY `id_depense` (`id_achat`);

--
-- Index pour la table `r_achats_avoirs$achats`
--
ALTER TABLE `r_achats_avoirs$achats`
  ADD PRIMARY KEY (`id_achats`,`id_avoirs$achats`),
  ADD KEY `id_avoir` (`id_avoirs$achats`);

--
-- Index pour la table `r_achats_factures$achats`
--
ALTER TABLE `r_achats_factures$achats`
  ADD PRIMARY KEY (`id_achats`,`id_factures$achats`),
  ADD KEY `id_facture` (`id_factures$achats`);

--
-- Index pour la table `r_avoirs$achats_bons$achats`
--
ALTER TABLE `r_avoirs$achats_bons$achats`
  ADD PRIMARY KEY (`id_avoirs$achats`,`id_bons$achats`),
  ADD KEY `id_bl` (`id_bons$achats`);

--
-- Index pour la table `r_avoirs$achats_factures$achats`
--
ALTER TABLE `r_avoirs$achats_factures$achats`
  ADD PRIMARY KEY (`id_avoirs$achats`,`id_factures$achats`),
  ADD KEY `id_facture` (`id_factures$achats`);

--
-- Index pour la table `r_bons$achats_commandes`
--
ALTER TABLE `r_bons$achats_commandes`
  ADD PRIMARY KEY (`id_bons$achats`,`id_commandes`),
  ADD KEY `id_commande` (`id_commandes`);

--
-- Index pour la table `r_commandes_clients`
--
ALTER TABLE `r_commandes_clients`
  ADD PRIMARY KEY (`id_commandes`,`id_clients`),
  ADD KEY `id_commande` (`id_commandes`),
  ADD KEY `R_cc_ibfk_2` (`id_clients`);

--
-- Index pour la table `r_factures$achats_bons$achats`
--
ALTER TABLE `r_factures$achats_bons$achats`
  ADD PRIMARY KEY (`id_factures$achats`,`id_bons$achats`),
  ADD KEY `id_bl` (`id_bons$achats`);

--
-- Index pour la table `r_factures$ventes_devis`
--
ALTER TABLE `r_factures$ventes_devis`
  ADD PRIMARY KEY (`id_factures$ventes`,`id_devis`) USING BTREE,
  ADD KEY `id_devis` (`id_devis`);

--
-- Index pour la table `r_ventes_factures$ventes`
--
ALTER TABLE `r_ventes_factures$ventes`
  ADD PRIMARY KEY (`id_ventes`,`id_factures$ventes`),
  ADD KEY `id_facturevente` (`id_factures$ventes`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mode` (`mode$paiement`) USING BTREE,
  ADD KEY `client1` (`clients`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=741;

--
-- AUTO_INCREMENT pour la table `autorisation$Achats`
--
ALTER TABLE `autorisation$Achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `autorisation$Comptes`
--
ALTER TABLE `autorisation$Comptes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `autorisation$CRM`
--
ALTER TABLE `autorisation$CRM`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `autorisation$Statistique`
--
ALTER TABLE `autorisation$Statistique`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `autorisation$Transactions`
--
ALTER TABLE `autorisation$Transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `autorisation$Ventes`
--
ALTER TABLE `autorisation$Ventes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `mode$paiement`
--
ALTER TABLE `mode$paiement`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5433;

--
-- AUTO_INCREMENT pour la table `raison$sociale`
--
ALTER TABLE `raison$sociale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `achat_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`),
  ADD CONSTRAINT `depanse_ibfk_2` FOREIGN KEY (`mode$paiement`) REFERENCES `mode$paiement` (`id`);

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$Achats`
--
ALTER TABLE `autorisation$Achats`
  ADD CONSTRAINT `autorisation_Achats` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$Comptes`
--
ALTER TABLE `autorisation$Comptes`
  ADD CONSTRAINT `autorisation_Comptes` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$CRM`
--
ALTER TABLE `autorisation$CRM`
  ADD CONSTRAINT `autorisation_CRM` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$Statistique`
--
ALTER TABLE `autorisation$Statistique`
  ADD CONSTRAINT `autorisation_Statistique` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$Transactions`
--
ALTER TABLE `autorisation$Transactions`
  ADD CONSTRAINT `autorisation_Transactions` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `autorisation$Ventes`
--
ALTER TABLE `autorisation$Ventes`
  ADD CONSTRAINT `autorisation_Ventes` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  ADD CONSTRAINT `avoirs$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  ADD CONSTRAINT `bons$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `devisss` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  ADD CONSTRAINT `factures$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  ADD CONSTRAINT `FV_ibfk_1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_achat`
--
ALTER TABLE `r_achats_achat`
  ADD CONSTRAINT `d_paiement_depense_ibfk_1` FOREIGN KEY (`id_achat`) REFERENCES `achat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_depense_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_avoirs$achats`
--
ALTER TABLE `r_achats_avoirs$achats`
  ADD CONSTRAINT `d_paiement_avoir_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_avoir_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_factures$achats`
--
ALTER TABLE `r_achats_factures$achats`
  ADD CONSTRAINT `d_paiement_facture_ibfk_1` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_facture_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_avoirs$achats_bons$achats`
--
ALTER TABLE `r_avoirs$achats_bons$achats`
  ADD CONSTRAINT `d_avoir_bl_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_avoir_bl_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_avoirs$achats_factures$achats`
--
ALTER TABLE `r_avoirs$achats_factures$achats`
  ADD CONSTRAINT `d_avoir_facture_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_avoir_facture_ibfk_2` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_bons$achats_commandes`
--
ALTER TABLE `r_bons$achats_commandes`
  ADD CONSTRAINT `R_bl_commande_ibfk_1` FOREIGN KEY (`id_commandes`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `R_bl_commande_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_commandes_clients`
--
ALTER TABLE `r_commandes_clients`
  ADD CONSTRAINT `R_cc_ibfk_1` FOREIGN KEY (`id_commandes`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `R_cc_ibfk_2` FOREIGN KEY (`id_clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_factures$achats_bons$achats`
--
ALTER TABLE `r_factures$achats_bons$achats`
  ADD CONSTRAINT `d_facture_bl_ibfk_1` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_facture_bl_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_factures$ventes_devis`
--
ALTER TABLE `r_factures$ventes_devis`
  ADD CONSTRAINT `d_factur_ibfk_1` FOREIGN KEY (`id_factures$ventes`) REFERENCES `factures$ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_factus_ibfk_2` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_ventes_factures$ventes`
--
ALTER TABLE `r_ventes_factures$ventes`
  ADD CONSTRAINT `d_vente_facture_ibfk_1` FOREIGN KEY (`id_ventes`) REFERENCES `ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_vente_facture_ibfk_2` FOREIGN KEY (`id_factures$ventes`) REFERENCES `factures$ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `client1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mp_2` FOREIGN KEY (`mode$paiement`) REFERENCES `mode$paiement` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


SELECT
 list$articles.id as list$articles_id , 
list$articles.Qte as list$articles_Qte , 
list$articles.prix as list$articles_prix , 
list$articles.remarque as list$articles_remarque ,
 list$articles.date_ajoute as list$articles_date_ajoute ,
 list$articles.date_modifier as list$articles_date_modifier ,
  articles.articles 
             FROM articles
             INNER JOIN  r_articles_list$articles 
                       ON articles.id =r_articles_list$articles.id_articles
             INNER JOIN  list$articles 
                      ON list$articles.id =r_articles_list$articles.id_list$articles
             INNER JOIN articles 
                     ON articles.id = list$articles.articles
                      WHERE ( articles.id = 1 )
