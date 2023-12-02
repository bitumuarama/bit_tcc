-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 02:22 PM
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
(1, 'ADMINISTRADOR', '2000-01-01', '00.000.000-0', '080.391.989-17', '(00) 00000-0000', '0000-000', 'PR', 'Umuarama', 'Zona V', 'Avenida Rio Grande do Norte', '000000'),
(24, 'CLIENTE 06', '1999-09-09', '00.000.000-0', '221.856.143-39', '(99) 99999-9999', '87504-00', 'PR', 'Umuarama', 'Zona V', 'Avenida Rio Grande do Norte', '00'),
(29, 'CLIENTE 11', '1994-04-16', '00.000.000-0', '558.652.838-04', '(44) 99999-9999', '13833-00', 'SP', 'Santo Antônio de Posse', 'Jardim Vila Rica', 'Rua Maestro Adelino Menuzzo', '1421'),
(30, 'CLIENTE 12', '1994-04-16', '00.000.000-0', '056.288.111-57', '(44) 99999-9999', '13833-00', 'SP', 'Santo Antônio de Posse', 'Jardim Vila Rica', 'Rua Maestro Adelino Menuzzo', '1672');

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(40) DEFAULT 'Membro',
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `data_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funcionario`
--

INSERT INTO `funcionario` (`id`, `nome`, `cargo`, `usuario`, `senha`, `email`, `celular`, `path`, `data_upload`) VALUES
(1, 'Admin', 'Administrador', 'Admin', '123abC', 'comercialexemplo@bit.com', '(44) 44444-4444', NULL, '2023-11-17'),
(8, 'Bruno Pereira Bertolli', 'Suporte', 'brb', '@1', 'bertolli.pb@gmail.com', '(44) 99839-9410', NULL, '2023-12-02'),
(9, 'Ednei do Esporte', 'Membro', 'ednei', '123', 'ednelsuduisport@gimeiu.cum', '(69) 96970-6024', NULL, '2023-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `ordem_de_servico`
--

CREATE TABLE `ordem_de_servico` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `equipamento` varchar(255) NOT NULL,
  `problema_relatado` text DEFAULT NULL,
  `problema_constatado` text DEFAULT NULL,
  `servico_executado` text DEFAULT NULL,
  `servicos` varchar(255) DEFAULT NULL,
  `valor_servico` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_fechamento` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordem_de_servico`
--

INSERT INTO `ordem_de_servico` (`id`, `cliente_id`, `equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servicos`, `valor_servico`, `valor_total`, `data_criacao`, `data_fechamento`, `status`) VALUES
(1, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:09:01', '2023-12-01 00:00:00', 'Ativo'),
(2, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:09:40', '2023-12-01 00:00:00', 'Ativo'),
(3, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:10:08', '2023-12-01 00:00:00', 'Ativo'),
(4, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-15 22:37:22', '2023-12-01 00:00:00', 'Ativo'),
(5, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-15 22:37:24', '2023-12-01 00:00:00', 'Ativo'),
(7, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-16 11:11:23', '2023-12-01 00:00:00', 'Ativo'),
(9, 1, 'PC', 'ABC', 'ABC', 'ABC', 'formatacao', 1.20, 1.20, '2023-11-19 16:35:06', '2023-12-01 00:00:00', 'Ativo'),
(12, 1, 'BROCA DE ELIXIR DO CLASH OF CLANS', 'Deu tela AZUL', 'HIN TU PIO', 'Parafusuuus  e SSD', 'formatacao,limpeza,trocadepeca,instalacao', 160.00, 160.00, '2023-11-19 17:18:11', '2023-12-01 00:00:00', 'Ativo'),
(17, 1, 'Notebook Asus', '', '', '', '', 200.00, 300.00, '2023-11-22 18:10:56', '2023-12-01 00:00:00', 'Ativo'),
(18, 1, 'Notebook Asus', '', '', '', '', 200.00, 300.00, '2023-11-22 18:11:05', '2023-12-01 00:00:00', 'Ativo'),
(19, 1, 'a', 'a', 'a', 'a', 'formatacao', 300.00, 300.00, '2023-11-23 13:04:35', '2023-12-01 00:00:00', 'Ativo'),
(20, 1, 'a', 'a', 'a', 'a', 'formatacao', 150.00, 0.00, '2023-11-23 13:07:31', '2023-12-01 00:00:00', 'Ativo'),
(21, 1, 'a', 'a', 'a', 'a', 'formatacao', 150.00, 0.00, '2023-11-23 13:07:32', '2023-12-01 00:00:00', 'Ativo'),
(28, 1, 'Máquina Potente', 'Danificado', 'Sem funcionamento', 'Comprou um novo', 'formatacao,limpeza,trocadepeca,montagem', 1.00, 500.00, '2023-12-01 13:14:49', '2023-12-01 00:00:00', 'Ativo'),
(30, 1, 'Notebook Asus', 'Abc', 'A', 's', NULL, NULL, NULL, '2023-12-01 13:34:28', '2023-12-01 00:00:00', 'Ativo'),
(31, 1, 'Notebook Asus', 'Abc', 'A', 's', NULL, NULL, NULL, '2023-12-01 13:34:41', '2023-12-01 00:00:00', 'Ativo'),
(32, 1, 'Notebook Asus', 'Abc', 'A', 's', NULL, NULL, NULL, '2023-12-01 13:34:48', '2023-12-01 00:00:00', 'Ativo'),
(45, 24, 'Note', 'Asus', NULL, NULL, NULL, NULL, NULL, '2023-12-02 04:24:34', '0000-00-00 00:00:00', 'Ativo'),
(46, 24, 'Notebook', 'Derramou café no teclado', NULL, NULL, NULL, NULL, NULL, '2023-12-02 11:34:25', '0000-00-00 00:00:00', 'Ativo'),
(47, 29, 'BROCA DE ELIXIR DO CLASH OF CLANS', 'Está sujo', NULL, NULL, NULL, NULL, NULL, '2023-12-02 11:35:58', '0000-00-00 00:00:00', 'Ativo'),
(48, 30, 'BROCA DE ELIXIR DA NASA', 'Sistema corrompido', NULL, NULL, NULL, NULL, NULL, '2023-12-02 11:36:16', '0000-00-00 00:00:00', 'Ativo'),
(49, 30, 'Notebook da Nasa', 'Sistema corrompido', NULL, NULL, NULL, NULL, NULL, '2023-12-02 11:36:42', '0000-00-00 00:00:00', 'Ativo');

-- --------------------------------------------------------

--
-- Table structure for table `ordem_de_servico_peca`
--

CREATE TABLE `ordem_de_servico_peca` (
  `ordem_de_servico_id` int(11) NOT NULL,
  `peca_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordem_de_servico_peca`
--

INSERT INTO `ordem_de_servico_peca` (`ordem_de_servico_id`, `peca_id`, `quantidade`) VALUES
(1, 1, 1),
(1, 1, 1),
(2, 1, 1),
(2, 1, 1),
(2, 1, 5),
(3, 1, 3),
(4, 2, 1),
(5, 2, 1),
(7, 1, 1),
(9, 2, 1),
(10, 2, 1),
(10, 6, 30),
(12, 2, 1),
(12, 6, 20),
(13, 2, 1),
(17, 3, 1),
(18, 3, 1),
(19, 2, 2),
(20, 2, 1),
(21, 2, 1),
(28, 3, 1);

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
  `valor_custo` decimal(10,2) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peca`
--

INSERT INTO `peca` (`id`, `nome`, `descricao`, `marca`, `categoria`, `estoque_minimo`, `estoque_atual`, `valor_custo`, `valor_venda`) VALUES
(1, 'SSD 120 Gb Gigabyte', '', '', '', 2, 2, 120.00, 140.00),
(2, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'SSD', 5, 4, 90.00, 150.00),
(3, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'SSD', 5, 7, 90.00, 150.00),
(4, 'Fonte para Testes', 'Fonte de testes da loja', 'Indefinido', 'Fontes', 1, 1, 200.00, 1.00),
(5, 'Fonte para Testes', 'Fonte de testes da loja', 'Indefinido', 'Fontes', 1, 1, 200.00, 1.00),
(6, 'Parafuso', 'Parafuso da dona tereza', 'Casa dos Parafusos', 'Essencial', 1, 80, 0.10, 0.50),
(7, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 0.00, 0.00),
(8, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 1.00, 2.00),
(9, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 0.00, 0.00),
(10, 'Teste', 'Teste', 'TEste', 'Teste', 1, 22, 50.00, 50.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indexes for table `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD KEY `ordem_de_servico_id` (`ordem_de_servico_id`),
  ADD KEY `peca_id` (`peca_id`);

--
-- Indexes for table `peca`
--
ALTER TABLE `peca`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `peca`
--
ALTER TABLE `peca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `ordem_de_servico_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_1` FOREIGN KEY (`ordem_de_servico_id`) REFERENCES `ordem_de_servico` (`id`),
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_2` FOREIGN KEY (`peca_id`) REFERENCES `peca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
