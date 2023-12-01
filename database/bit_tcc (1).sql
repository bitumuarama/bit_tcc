-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/12/2023 às 15:36
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bit_tcc`
--
CREATE DATABASE IF NOT EXISTS `bit_tcc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bit_tcc`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
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
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `data_nascimento`, `rg`, `cpf`, `celular`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'ADMINISTRADOR', '2000-01-01', '00.000.000-0', '000.000.000-00', '(00) 00000-0000', '00000-00', 'PR', 'Cidade', 'Centro', 'Av. Tecnologias', '000000'),
(2, 'João Silva', '1990-01-01', 'MG-10.123.45', '000.000.001-91', '(31) 90000-0001', '87502-27', 'PR', 'Umuarama', 'Jardim Aratimbó', 'Rua José Dias Lopes', '100'),
(3, 'Maria Souza da silva', '1991-02-02', 'SP-20.234.56', '000.000.002-72', '(11) 90000-0002', '01000-00', 'SP', 'São Paulo', 'Brás', 'Rua São Caetano', '200'),
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
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(40) DEFAULT 'Funcionario',
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `data_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `nome`, `cargo`, `usuario`, `senha`, `email`, `celular`, `path`, `data_upload`) VALUES
(1, 'Admin', 'Administrador', 'Admin', '123abC', 'comercialexemplo@bit.com', '(00) 00000-0000', NULL, '2023-11-17'),
(2, 'Bruno Pereira Bertolli', '', 'Bruno', '1471', '', '', NULL, '2023-11-17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_de_servico`
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
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_de_servico`
--

INSERT INTO `ordem_de_servico` (`id`, `cliente_id`, `equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servicos`, `valor_servico`, `valor_total`, `data_criacao`) VALUES
(1, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:09:01'),
(2, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:09:40'),
(3, 1, 'Laptop', 'Não sei', 'Não sei', 'Não sei', 'limpeza', 240.00, 300.00, '2023-11-15 22:10:08'),
(4, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-15 22:37:22'),
(5, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-15 22:37:24'),
(7, 1, '', '', '', '', '', 0.00, 0.00, '2023-11-16 11:11:23'),
(9, 1, 'PC', 'ABC', 'ABC', 'ABC', 'formatacao', 1.20, 1.20, '2023-11-19 16:35:06'),
(10, 11, 'Notebook Asus', 'Está lento', 'HD danificado', 'Troca do HD por SSD e colocado parafusos', 'formatacao,trocadepeca,montagem', 165.00, 165.00, '2023-11-19 16:37:52'),
(12, 1, 'BROCA DE ELIXIR DO CLASH OF CLANS', 'Deu tela AZUL', 'HIN TU PIO', 'Parafusuuus  e SSD', 'formatacao,limpeza,trocadepeca,instalacao', 160.00, 160.00, '2023-11-19 17:18:11'),
(13, 11, 'Notebook Asus', 'Algo deu ruim no teclado', 'Teclado tá com merda de gato', 'Trocamos o teclado e o SSD, mas o teclado novo era do cliente', 'formatacao,trocadepeca,instalacao', 200.00, 200.00, '2023-11-19 17:21:17'),
(15, 1, 'NOTE ASUS', 'sé', 'asdsadf', 'fasfsaf', 'formatacao', 0.00, 0.00, '2023-11-30 13:43:27'),
(16, 5, 'NOTEBOOK', 'SAS', 'SAS', 'SAS', 'formatacao,trocadepeca', 0.00, 100.00, '2023-12-01 11:53:39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_de_servico_peca`
--

CREATE TABLE `ordem_de_servico_peca` (
  `ordem_de_servico_id` int(11) NOT NULL,
  `peca_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_de_servico_peca`
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
(15, 2, 1),
(16, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `peca`
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
-- Despejando dados para a tabela `peca`
--

INSERT INTO `peca` (`id`, `nome`, `descricao`, `marca`, `categoria`, `estoque_minimo`, `estoque_atual`, `valor_custo`, `valor_venda`) VALUES
(1, 'SSD 120 Gb Gigabyte', '', 'Kingstom', '', 2, 5, 120.00, 140.00),
(2, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'SSD', 5, 7, 90.00, 150.00),
(3, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'SSD', 5, 9, 90.00, 150.00),
(4, 'Fonte para Testes', 'Fonte de testes da loja', 'Indefinido', 'Fontes', 1, 1, 200.00, 1.00),
(5, 'Fonte para Testes', 'Fonte de testes da loja', 'Indefinido', 'Fontes', 1, 1, 200.00, 1.00),
(6, 'Parafuso', 'Parafuso da dona tereza', 'Casa dos Parafusos', 'Essencial', 1, 80, 0.10, 0.50),
(7, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 0.00, 0.00),
(8, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 1.00, 2.00),
(9, 'Teclado ASUS', 'Teclado para notebook', 'SEi lá', 'Teclado', 1, 1, 0.00, 0.00),
(10, 'Teste', 'Teste', 'TEste', 'Teste', 1, 22, 50.00, 50.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `recebimento`
--

CREATE TABLE `recebimento` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `os_id` int(11) NOT NULL,
  `data_recebimento` date NOT NULL,
  `valor_pago` double NOT NULL,
  `forma_pagamento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD KEY `ordem_de_servico_id` (`ordem_de_servico_id`),
  ADD KEY `peca_id` (`peca_id`);

--
-- Índices de tabela `peca`
--
ALTER TABLE `peca`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `recebimento`
--
ALTER TABLE `recebimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `os_idpk` (`os_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `peca`
--
ALTER TABLE `peca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `recebimento`
--
ALTER TABLE `recebimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD CONSTRAINT `ordem_de_servico_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_1` FOREIGN KEY (`ordem_de_servico_id`) REFERENCES `ordem_de_servico` (`id`),
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_2` FOREIGN KEY (`peca_id`) REFERENCES `peca` (`id`);

--
-- Restrições para tabelas `recebimento`
--
ALTER TABLE `recebimento`
  ADD CONSTRAINT `os_idpk` FOREIGN KEY (`os_id`) REFERENCES `ordem_de_servico` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
