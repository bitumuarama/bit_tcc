-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2023 at 10:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bit_tcc`
--
CREATE DATABASE IF NOT EXISTS `bit_tcc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bit_tcc`;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `rg` varchar(30) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `cep` varchar(40) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cpf`, `rg`, `cidade`, `endereco`, `cep`, `estado`, `telefone`, `data_nascimento`) VALUES
(1, 'BRUNO PEREIRA BERTOLLI', '', '', 'Umuarama', 'Casa', '87504-020', 'PR', '', '0000-00-00'),
(99, 'a', '', '', '', '', '', 'PR', '', '0000-00-00'),
(100, 'a', '', '', '', '', '', 'PR', '', '0000-00-00'),
(101, 'BRUNO PEREIRA BERTOLLI', '', '', 'Umuarama', 'Casa', '87504-020', 'PR', '', '0000-00-00'),
(102, 'a', '', '', '', '', '', 'PR', '', '0000-00-00'),
(103, 'a', '', '', '', '', '', 'PR', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `ordem_de_servico`
--

CREATE TABLE `ordem_de_servico` (
  `id` int(11) NOT NULL,
  `equipamento` varchar(250) NOT NULL,
  `problema_relatado` varchar(250) NOT NULL,
  `problema_constatado` varchar(250) NOT NULL,
  `servico_executado` varchar(250) NOT NULL,
  `servico` varchar(100) NOT NULL,
  `valor_servico` double NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_peca` int(11) NOT NULL,
  `valor_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peca`
--

CREATE TABLE `peca` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estoque_minimo` int(11) NOT NULL,
  `estoque_atual` int(11) NOT NULL,
  `valor_custo` double NOT NULL,
  `valor_venda` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peca`
--

INSERT INTO `peca` (`id`, `nome`, `descricao`, `marca`, `categoria`, `estoque_minimo`, `estoque_atual`, `valor_custo`, `valor_venda`) VALUES
(1, 'SSD 120 Gb Gigabyte', '', '', '', 2, 2, 120, 140);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL DEFAULT 'Indefinido',
  `senha` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `path` varchar(100) NOT NULL,
  `data-upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `cargo`, `senha`, `email`, `path`, `data-upload`) VALUES
(1, 'Admin', 'Indefinido', '123abC', 'admin@example.com', '', '2023-08-07 13:13:34'),
(2, '', 'Indefinido', '', '', '', '2023-08-07 13:13:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_cliente` (`id_cliente`),
  ADD KEY `codigo_peca` (`id_peca`);

--
-- Indexes for table `peca`
--
ALTER TABLE `peca`
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
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peca`
--
ALTER TABLE `peca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD CONSTRAINT `ordem_de_servico_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `ordem_de_servico_ibfk_3` FOREIGN KEY (`id_peca`) REFERENCES `peca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
