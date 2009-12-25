-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 25 Décembre 2009 à 10:32
-- Version du serveur: 5.1.37
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `facturier`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(255) NOT NULL DEFAULT '',
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `num` varchar(6) NOT NULL DEFAULT '0',
  `boite` varchar(5) DEFAULT NULL,
  `cp` varchar(25) NOT NULL DEFAULT '',
  `localite` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `tva` varchar(20) NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Structure de la table `facturesEntrantes`
--

CREATE TABLE IF NOT EXISTS `facturesEntrantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `denomination` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `pourcent_tva` decimal(4,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_tvac` decimal(10,2) NOT NULL,
  `deductibilite` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=248 ;

-- --------------------------------------------------------

--
-- Structure de la table `facturesSortantes`
--

CREATE TABLE IF NOT EXISTS `facturesSortantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `numero` int(11) NOT NULL,
  `objet` text NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `pourcent_tva` decimal(4,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_tvac` decimal(10,2) NOT NULL,
  `paid` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Structure de la table `trimestres`
--

CREATE TABLE IF NOT EXISTS `trimestres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee` int(4) NOT NULL DEFAULT '0',
  `trimestre` int(1) NOT NULL DEFAULT '0',
  `montant_htva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `montant_tva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `montant_tvac` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `legende` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `numero` varchar(11) NOT NULL,
  `boite` varchar(11) NOT NULL,
  `codepostal` varchar(20) NOT NULL,
  `localite` varchar(100) NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `portable` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `tva` varchar(100) NOT NULL,
  `comptebancaire` varchar(100) NOT NULL,
  `iban` varchar(100) NOT NULL,
  `bic` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
