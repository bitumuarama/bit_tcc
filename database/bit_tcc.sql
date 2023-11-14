-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 09:20 PM
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
  `data_nascimento` date NOT NULL,
  `rg` varchar(12) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(50) NOT NULL,
  `numero` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `data_nascimento`, `rg`, `cpf`, `celular`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'ADMINISTRADOR', '2000-01-01', '00.000.000-0', '000.000.000-00', '(00) 00000-0000', '00000-00', 'PR', 'Cidade', 'Centro', 'Av. Tecnologias', '000000'),
(2, 'João Silva', '1990-01-01', 'MG-10.123.45', '000.000.001-91', '(31) 90000-0001', '31000-00', 'MG', 'Belo Horizonte', 'Centro', 'Rua da Bahia', '100'),
(3, 'Maria Souza', '1991-02-02', 'SP-20.234.56', '000.000.002-72', '(11) 90000-0002', '01000-00', 'SP', 'São Paulo', 'Brás', 'Rua São Caetano', '200'),
(4, 'Pedro Santos', '1992-03-03', 'RJ-30.345.67', '000.000.003-53', '(21) 90000-0003', '22000-00', 'RJ', 'Rio de Janeiro', 'Copacabana', 'Avenida Atlântica', '300'),
(5, 'Ana Costa', '1993-04-04', 'RS-40.456.78', '000.000.004-34', '(51) 90000-0004', '90000-00', 'RS', 'Porto Alegre', 'Centro', 'Rua dos Andradas', '400'),
(6, 'Lucas Martins', '1994-05-05', 'PR-50.567.89', '000.000.005-15', '(41) 90000-0005', '80000-00', 'PR', 'Curitiba', 'Batel', 'Avenida Sete de Setembro', '500'),
(7, 'Patrícia Oliveira', '1995-06-06', 'SC-60.678.90', '000.000.006-96', '(48) 90000-0006', '88000-00', 'SC', 'Florianópolis', 'Centro', 'Rua Felipe Schmidt', '600'),
(8, 'Rafael Almeida', '1996-07-07', 'BA-70.789.01', '000.000.007-77', '(71) 90000-0007', '40000-00', 'BA', 'Salvador', 'Itapuã', 'Avenida Dorival Caymmi', '700'),
(9, 'Fernanda Gomes', '1997-08-08', 'PE-80.890.12', '000.000.008-58', '(81) 90000-0008', '50000-00', 'PE', 'Recife', 'Boa Viagem', 'Avenida Conselheiro Aguiar', '800'),
(10, 'Carlos Rodrigues', '1998-09-09', 'CE-90.901.23', '000.000.009-39', '(85) 90000-0009', '60000-00', 'CE', 'Fortaleza', 'Meireles', 'Avenida Beira Mar', '900'),
(11, 'Sandra Lima', '1999-10-10', 'PA-01.012.34', '000.000.010-10', '(91) 90000-0010', '66000-00', 'PA', 'Belém', 'Nazaré', 'Avenida Nazaré', '1000');

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

--
-- Dumping data for table `ordem_de_servico`
--

INSERT INTO `ordem_de_servico` (`id`, `equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servico`, `valor_servico`, `id_cliente`, `id_peca`, `valor_total`) VALUES
(3, 'Laptop', '', '', '', 'formatacao', 120, 1, 1, 120);

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
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(40) NOT NULL DEFAULT 'Indefinido',
  `senha` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `path` varchar(255) NOT NULL,
  `data_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `cargo`, `senha`, `email`, `celular`, `path`, `data_upload`) VALUES
(1, 'Admin', 'Administrador', '123abC', 'administrador@bit.com', '(00) 00000-0000', '', '2023-11-13');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peca`
--
ALTER TABLE `peca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
