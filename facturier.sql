-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 03 Octobre 2009 à 13:20
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
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`idClient`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `facturesEntrantes`
--

CREATE TABLE IF NOT EXISTS `facturesEntrantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `objet` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `pourcent_tva` decimal(4,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_tvac` decimal(10,2) NOT NULL,
  `deductibilite` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=207 ;

-- --------------------------------------------------------

--
-- Structure de la table `facturesSortantes`
--

CREATE TABLE IF NOT EXISTS `facturesSortantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClient` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `numero` int(11) NOT NULL,
  `objet` text NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `pourcent_tva` decimal(4,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_tvac` decimal(10,2) NOT NULL,
  `paid` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=209 ;

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
  `type` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=201 ;
