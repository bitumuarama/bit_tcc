-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/10/2023 às 16:31
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
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `rg` varchar(30) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `cep` varchar(40) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `datanasc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`codigo`, `nome`, `cpf`, `rg`, `cidade`, `endereco`, `cep`, `estado`, `telefone`, `datanasc`) VALUES
(7, 'Murilo Augusto Cardoso', 'asdad', 'adasda', 'Umuarama', '4769 Rua José Dias Lopes', '87.502-270', 'PR', '44998843883', '2222-02-22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordemdeservico`
--

CREATE TABLE `ordemdeservico` (
  `codigo` int(11) NOT NULL,
  `equipamento` varchar(250) NOT NULL,
  `problemarelatado` varchar(250) NOT NULL,
  `problemaconstatado` varchar(250) NOT NULL,
  `servicoexecutado` varchar(250) NOT NULL,
  `servico` varchar(100) NOT NULL,
  `valorservico` double NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `codigo_peca` int(11) NOT NULL,
  `valortotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordemdeservico`
--

INSERT INTO `ordemdeservico` (`codigo`, `equipamento`, `problemarelatado`, `problemaconstatado`, `servicoexecutado`, `servico`, `valorservico`, `codigo_cliente`, `codigo_peca`, `valortotal`) VALUES
(21, 'note', 'não liga        ', '   problema no hd     ', '        troca de hd', 'formatacao', 10, 7, 1, 1),
(22, 'note', '        asdfad', '        sadasd', '        asdsad', 'formatacao, montagem', 10, 7, 1, 11);

-- --------------------------------------------------------

--
-- Estrutura para tabela `peca`
--

CREATE TABLE `peca` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estoqueminimo` int(11) NOT NULL,
  `estoqueatual` int(11) NOT NULL,
  `valorcusto` double NOT NULL,
  `valorvenda` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `peca`
--

INSERT INTO `peca` (`codigo`, `nome`, `descricao`, `marca`, `categoria`, `estoqueminimo`, `estoqueatual`, `valorcusto`, `valorvenda`) VALUES
(1, 'SSD 120 Gb Gigabyte', '', '', '', 2, 2, 120, 140);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
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
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `cargo`, `senha`, `email`, `path`, `data-upload`) VALUES
(1, 'Admin', 'Indefinido', '123abC', 'admin@example.com', '', '2023-08-07 13:13:34'),
(2, '', 'Indefinido', '', '', '', '2023-08-07 13:13:34');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `ordemdeservico`
--
ALTER TABLE `ordemdeservico`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_cliente` (`codigo_cliente`),
  ADD KEY `codigo_peca` (`codigo_peca`);

--
-- Índices de tabela `peca`
--
ALTER TABLE `peca`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `ordemdeservico`
--
ALTER TABLE `ordemdeservico`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `peca`
--
ALTER TABLE `peca`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ordemdeservico`
--
ALTER TABLE `ordemdeservico`
  ADD CONSTRAINT `ordemdeservico_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo`),
  ADD CONSTRAINT `ordemdeservico_ibfk_3` FOREIGN KEY (`codigo_peca`) REFERENCES `peca` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
