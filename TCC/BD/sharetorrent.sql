-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Nov-2019 às 02:14
-- Versão do servidor: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sharetorrent`
--
CREATE DATABASE IF NOT EXISTS `sharetorrent` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sharetorrent`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivo`
--

CREATE TABLE `arquivo` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `titulo` varchar(30) NOT NULL,
  `caminho` varchar(60) DEFAULT NULL,
  `descricao` longtext NOT NULL,
  `tamanho` varchar(20) NOT NULL,
  `nome_usuario` varchar(60) NOT NULL,
  `id_pasta` int(11) DEFAULT NULL,
  `criado` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `arquivo`
--

INSERT INTO `arquivo` (`id`, `nome`, `titulo`, `caminho`, `descricao`, `tamanho`, `nome_usuario`, `id_pasta`, `criado`) VALUES
(217, 'Linux_Mint217', 'Linux Mint', 'arquivos/Linux_Mint217.torrent', 'Sistema Operacional de codigo aberto constituido Ã  partir do nÃºcleo linux', '37.7 KB', 'Darabas', NULL, '2019-11-26 22:08:09'),
(216, 'Mageia216', 'Mageia', 'arquivos/Mageia216.torrent', 'Sistema Operacional de codigo aberto constituido Ã  partir do nÃºcleo linux', '42.97 KB', 'Darabas', NULL, '2019-11-26 22:07:00'),
(215, 'openSUSE215', 'openSUSE', 'arquivos/openSUSE215.torrent', 'Sistema Operacional baseado em GNU', '303.1 KB', 'Darabas', NULL, '2019-11-26 22:06:16'),
(202, 'Ubuntu202', 'Ubuntu', 'arquivos/Ubuntu202.torrent', 'Sistema Operacional baseado em GNU', '46.22 KB', 'Darabas', NULL, '2019-11-26 21:53:50'),
(205, 'CC_TheGood205', 'CC TheGood', 'arquivos/CC_TheGood205.torrent', 'Filme de Charlie Chaplin', '11.84 KB', 'Darabas', NULL, '2019-11-26 21:57:15'),
(204, 'CC_Film_Fest204', 'CC Film Fest', 'arquivos/CC_Film_Fest204.torrent', 'Filme de Charlie Chaplin', '41.68 KB', 'Darabas', NULL, '2019-11-26 21:56:01'),
(206, 'CC_TheVagabond206', 'CC TheVagabond', 'arquivos/CC_TheVagabond206.torrent', 'Filme de Charlie Chaplin', '21.95 KB', 'Darabas', NULL, '2019-11-26 21:57:39'),
(207, 'CC_PawnShop207', 'CC PawnShop', 'arquivos/CC_PawnShop207.torrent', 'Filme de Charlie Chaplin', '16.54 KB', 'Darabas', NULL, '2019-11-26 21:58:02'),
(208, 'SpeedRun_FF208', 'SpeedRun FF', 'arquivos/SpeedRun_FF208.torrent', 'Speed Run de final fantasy', '174.76 KB', 'Darabas', NULL, '2019-11-26 21:58:46'),
(209, 'HL2_SpeedRun209', 'HL2 SpeedRun', 'arquivos/HL2_SpeedRun209.torrent', 'Speed Run de half life 2', '43.1 KB', 'Darabas', NULL, '2019-11-26 21:59:32'),
(210, 'SpeedRun_Mario210', 'SpeedRun Mario', 'arquivos/SpeedRun_Mario210.torrent', 'Speed Run de Super mario bros', '15.73 KB', 'Darabas', NULL, '2019-11-26 22:00:21'),
(211, 'RE4_SpeedRun211', 'RE4 SpeedRun', 'arquivos/RE4_SpeedRun211.torrent', 'Speed Run de resident evil 4', '43.36 KB', 'Darabas', NULL, '2019-11-26 22:00:57'),
(212, 'PokemonRed_SpeedRun212', 'PokemonRed SpeedRun', 'arquivos/PokemonRed_SpeedRun212.torrent', 'Speed Run de pokemon red', '158.84 KB', 'Darabas', NULL, '2019-11-26 22:01:35'),
(213, 'ArchLinux213', 'ArchLinux', 'arquivos/ArchLinux213.torrent', 'Sistema Operacional de codigo aberto constituido Ã  partir do nÃºcleo linux', '40.87 KB', 'Darabas', NULL, '2019-11-26 22:03:54'),
(214, 'Fedora214', 'Fedora', 'arquivos/Fedora214.torrent', 'Sistema Operacional baseado em GNU', '284.5 KB', 'Darabas', NULL, '2019-11-26 22:04:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pastas`
--

CREATE TABLE `pastas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `fk_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pastas`
--

INSERT INTO `pastas` (`id`, `nome`, `fk_usuario`) VALUES
(5, 'Teste 1', 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `apelido` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `criado` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `apelido`, `email`, `senha`, `criado`) VALUES
(41, 'Guilherme', 'Darabas', 'darabas@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-11-26 21:51:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arquivo`
--
ALTER TABLE `arquivo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pastas`
--
ALTER TABLE `pastas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arquivo`
--
ALTER TABLE `arquivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;
--
-- AUTO_INCREMENT for table `pastas`
--
ALTER TABLE `pastas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
