-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/05/2025 às 00:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `promais`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chaves_liberacao`
--

CREATE TABLE `chaves_liberacao` (
  `id` int(11) NOT NULL,
  `chave` varchar(64) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `plano_id` int(11) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `expira_em` datetime NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `empresa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chaves_liberacao`
--

INSERT INTO `chaves_liberacao` (`id`, `chave`, `usuario_id`, `plano_id`, `ativo`, `expira_em`, `criado_em`, `empresa_id`) VALUES
(1, 'ffc263c24e502a53443522fce3506247', 1, 1, 1, '2026-01-01 21:54:12', '2025-01-08 00:54:12', 1),
(2, '94fa99fbe1826957c25bac51299cdba2', 3, 2, 1, '2025-04-03 21:54:12', '2025-01-04 00:54:12', 2),
(3, 'c9e4a48e5e3d78d22609329c4a761c47', 2, 3, 1, '2026-01-03 21:54:12', '2025-01-04 00:54:12', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `codigo_ibge` varchar(7) DEFAULT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`id`, `empresa_id`, `nome`, `estado`, `codigo_ibge`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'São Paulo', 'SP', NULL, 'Ativo', '2025-01-22 00:38:49', '2025-01-22 01:20:25'),
(2, 2, 'Rio de Janeiro', 'RJ', NULL, 'Ativo', '2025-01-22 00:38:49', '2025-01-22 01:20:28'),
(3, 2, 'São Paulo', 'SP', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:30'),
(4, 2, 'Rio de Janeiro', 'RJ', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:32'),
(5, 2, 'Belo Horizonte', 'MG', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:34'),
(6, 2, 'Salvador', 'BA', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:35'),
(7, 3, 'Brasília', 'DF', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:36'),
(8, 3, 'Curitiba', 'PR', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:38'),
(9, 1, 'Fortaleza', 'CE', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:40'),
(10, 2, 'Recife', 'PE', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:41'),
(11, 2, 'Porto Alegre', 'RS', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:43'),
(12, 1, 'Manaus', 'AM', NULL, 'Ativo', '2025-01-22 00:53:56', '2025-01-22 01:20:44'),
(13, 1, 'Alto Araguaia', 'MT', NULL, 'Ativo', '2025-01-22 00:57:51', '2025-01-22 01:20:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clinicas`
--

CREATE TABLE `clinicas` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `codigo` varchar(10) NOT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clinicas`
--

INSERT INTO `clinicas` (`id`, `empresa_id`, `codigo`, `nome_fantasia`, `razao_social`, `cnpj`, `endereco`, `numero`, `complemento`, `bairro`, `cidade_id`, `cep`, `email`, `telefone`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'CL001', 'Clínica São Lucas', 'São Lucas Serviços Médicos LTDA', '12.345.678/0001-01', 'Av. Paulista', '1000', 'Sala 101', 'Bela Vista', 1, '01310-100', 'contato@saolucas.com.br', '(11) 3333-1111', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(2, 1, 'CL002', 'Centro Médico Santa Maria', 'Santa Maria Centro Médico LTDA', '23.456.789/0001-02', 'Rua Augusta', '500', 'Andar 5', 'Consolação', 1, '01304-001', 'contato@santamaria.com.br', '(11) 3333-2222', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(3, 1, 'CL003', 'Clínica Vida Plena', 'Vida Plena Serviços de Saúde LTDA', '34.567.890/0001-03', 'Av. Atlântica', '200', NULL, 'Centro', 12, '69020-010', 'contato@vidaplena.com.br', '(92) 3333-3333', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(4, 1, 'CL004', 'Centro de Saúde Alto Araguaia', 'Centro de Saúde AA LTDA', '45.678.901/0001-04', 'Rua Principal', '150', 'Térreo', 'Centro', 13, '78780-000', 'contato@csaa.com.br', '(66) 3333-4444', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(5, 1, 'CL005', 'Clínica Bem Estar', 'Bem Estar Medicina LTDA', '56.789.012/0001-05', 'Av. Dom Pedro II', '300', 'Conjunto 45', 'Centro', 9, '60020-010', 'contato@bemestar.com.br', '(85) 3333-5555', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(28, 2, 'CL001', 'Unisys', 'UNISYS BRASIL LTDA', '33.426.420/0004-36', 'Rua Teixeira de Freitas', '31', 'Rua 14 de Julho, 5141', 'Centro', 10, '77777-777', 'neto_br_8@hotmail.com', '(99) 98998-9898', 'Ativo', '2025-04-29 02:41:00', '2025-04-29 03:33:10'),
(29, 2, 'CL001', 'Unisys', 'UNISYS BRASIL LTDA', '33.426.420/0001-93', 'Avenida das Nacoes Unidas', '17891', 'Conj 801/parte Dp10 12e13', 'Vila Almeida', 12, '04795-920', 'mauricio.miranda@br.unisys.com', '2139007765', 'Ativo', '2025-04-29 05:13:00', '2025-04-29 03:12:36'),
(30, 2, '', 'Unisys', 'UNISYS BRASIL LTDA', '33.426.420/0001-93', 'Avenida das Nacoes Unidas', '17891', 'Conj 801/parte Dp10 12e13', 'Vila Almeida', 3, '04795-920', 'mauricio.miranda@br.unisys.com', '2139007765', 'Ativo', '2025-04-29 05:15:00', '2025-04-29 01:15:37'),
(31, 2, 'CL001', 'coca cola bebida boa', 'SPAL INDUSTRIA BRASILEIRA DE BEBIDAS S/A', '61.186.888/0098-16', 'rua terere', '2803', 'centro', 'Chacara das Mansoes', 9, '79079-005', 'fiscal@kof.com', '1121025500', 'Ativo', '2025-04-29 05:16:00', '2025-04-29 03:00:34'),
(32, 2, 'CL001', 'Coca Cola e Fanta', 'REFRIGERANTES DO OESTE LTDA', '03.025.988/0001-31', 'Rodovia Campo Grande/sao Paulo', 'S/N11', 'Km 01', 'Vila Albuquerque', 6, '79060-000', 'rosactb@terra.com.br', '(33) 33333-3333', 'Ativo', '2025-04-29 07:19:00', '2025-04-29 03:33:15'),
(33, 2, 'CL001', 'teste', 'SPAL INDUSTRIA BRASILEIRA DE BEBIDAS S/A', '61.186.888/0098-16', 'Rodovia Br-163', '2803', 'teste teste', 'Chacara das Mansoes', 0, '79079-005', 'fiscal@kof.com', '1121025500', 'Ativo', '2025-04-29 03:37:09', '2025-04-29 18:00:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `chave_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome`, `cnpj`, `endereco`, `telefone`, `email`, `chave_id`) VALUES
(1, 'Promais - Segurança do Trabalho', '12.345.678/0001-90', 'Rua Exemplo, 123, São Paulo', '(11) 1234-5678', 'contato@promais.com.br', 1),
(2, 'Empresa B', '23.456.789/0001-01', 'Avenida Central, 456, Rio de Janeiro', '(21) 2345-6789', 'contato@empresaB.com', 2),
(3, 'Empresa C', '34.567.890/0001-12', 'Rua das Flores, 789, Belo Horizonte', '(31) 3456-7890', 'contato@empresaC.com', 3),
(4, 'Empresa D', '45.678.901/0001-23', 'Rua do Comércio, 1011, Curitiba', '(41) 4567-8901', 'contato@empresaD.com', NULL),
(5, 'Empresa E', '56.789.012/0001-34', 'Avenida Paulista, 2020, São Paulo', '(11) 5678-9012', 'contato@empresaE.com', NULL),
(9, 'Rd Construcoes', '13.277.519/0001-63', 'Avenida Marechal Rondon,4844,Manaus ', '6933412245', 'ricardodallavalle@gmail.com', 0),
(10, 'Rd Construcoes', '13.277.519/0001-63', 'Avenida Marechal Rondon,4844,Salvador ', '6933412245', 'ricardodallavalle@gmail.com', 0),
(11, 'Rd Construcoes', '13.277.519/0001-63', 'Avenida Marechal Rondon,4844,Manaus,AM', '6933412245', 'ricardodallavalle@gmail.com', 0),
(12, 'Rd Construcoes', '13.277.519/0001-63', 'Avenida Marechal Rondon,4844,Salvador , BA', '6933412245', 'ricardodallavalle@gmail.com', 0),
(13, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Salvador , BA', '6796385622', 'neto_br_8@hotmail.com', 0),
(14, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Manaus , AM', '6796385622', 'rezende@gmail.com', 0),
(15, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Fortaleza , CE', '6796385622', 'rezende@gmail.com', 0),
(16, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Fortaleza , CE', '6796385622', 'rezende@gmail.com', 0),
(17, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Salvador , BA', '6796385622', 'rezende@gmail.com', 0),
(18, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Salvador , BA', '6796385622', 'rezende@gmail.com', 0),
(19, 'Rd Construtora', '30.077.647/0001-82', 'Rua Amazonas,850,Fortaleza , CE', '6796385622', 'rezende@gmai.com', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `crm` varchar(20) NOT NULL,
  `pcmso` varchar(50) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicos`
--

INSERT INTO `medicos` (`id`, `empresa_id`, `nome`, `especialidade`, `crm`, `pcmso`, `contato`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dr. João Silva', 'Clínico Geral', 'CRM/SP 123456', 'PCMSO-001', 'dr.joao@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(2, 1, 'Dra. Maria Santos', 'Medicina do Trabalho', 'CRM/SP 234567', 'PCMSO-002', 'dra.maria@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(3, 1, 'Dr. Pedro Oliveira', 'Ortopedia', 'CRM/AM 345678', 'PCMSO-003', 'dr.pedro@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(4, 1, 'Dra. Ana Costa', 'Medicina do Trabalho', 'CRM/MT 456789', 'PCMSO-004', 'dra.ana@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(5, 1, 'Dr. Carlos Souza', 'Cardiologia', 'CRM/CE 567890', 'PCMSO-005', 'dr.carlos@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(6, 1, 'Dra. Paula Lima', 'Clínico Geral', 'CRM/SP 678901', 'PCMSO-006', 'dra.paula@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(7, 1, 'Dr. Roberto Alves', 'Medicina do Trabalho', 'CRM/AM 789012', 'PCMSO-007', 'dr.roberto@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19'),
(8, 1, 'Dra. Lucia Ferreira', 'Medicina do Trabalho', 'CRM/CE 890123', 'PCMSO-008', 'dra.lucia@email.com', 'Ativo', '2025-01-22 01:36:19', '2025-01-22 01:36:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicos_clinicas`
--

CREATE TABLE `medicos_clinicas` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `medico_id` int(11) NOT NULL,
  `clinica_id` int(11) NOT NULL,
  `data_associacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicos_clinicas`
--

INSERT INTO `medicos_clinicas` (`id`, `empresa_id`, `medico_id`, `clinica_id`, `data_associacao`, `status`) VALUES
(1, 1, 1, 1, '2025-01-01 13:00:00', 'Ativo'),
(2, 1, 2, 1, '2025-01-01 13:00:00', 'Ativo'),
(3, 1, 6, 1, '2025-01-01 13:00:00', 'Ativo'),
(4, 1, 2, 2, '2025-01-01 13:00:00', 'Ativo'),
(5, 1, 6, 2, '2025-01-01 13:00:00', 'Ativo'),
(6, 1, 3, 3, '2025-01-01 13:00:00', 'Ativo'),
(7, 1, 7, 3, '2025-01-01 13:00:00', 'Ativo'),
(8, 1, 4, 4, '2025-01-01 13:00:00', 'Ativo'),
(9, 1, 5, 5, '2025-01-01 13:00:00', 'Ativo'),
(10, 1, 8, 5, '2025-01-01 13:00:00', 'Ativo'),
(11, 1, 1, 15, '2025-04-25 03:02:00', 'Ativo'),
(12, 1, 2, 15, '2025-04-25 03:02:00', 'Ativo'),
(13, 1, 1, 16, '2025-04-26 00:41:39', 'Ativo'),
(14, 1, 2, 16, '2025-04-26 00:41:39', 'Ativo'),
(15, 2, 1, 17, '2025-04-29 00:02:00', 'Inativo'),
(16, 2, 2, 17, '2025-04-29 00:02:00', 'Inativo'),
(17, 2, 1, 26, '2025-04-29 04:39:39', 'Ativo'),
(18, 2, 2, 26, '2025-04-29 04:39:39', 'Ativo'),
(19, 2, 3, 26, '2025-04-29 04:39:39', 'Ativo'),
(20, 2, 1, 27, '2025-04-29 04:39:53', 'Ativo'),
(21, 2, 2, 27, '2025-04-29 04:39:53', 'Ativo'),
(22, 2, 3, 27, '2025-04-29 04:39:53', 'Ativo'),
(23, 2, 1, 28, '2025-04-29 04:42:09', 'Ativo'),
(24, 2, 2, 28, '2025-04-29 04:42:09', 'Ativo'),
(25, 2, 4, 28, '2025-04-29 06:50:46', 'Ativo'),
(26, 2, 3, 28, '2025-04-29 07:11:41', 'Ativo'),
(27, 2, 1, 31, '2025-04-29 07:16:32', 'Ativo'),
(28, 2, 4, 31, '2025-04-29 07:16:32', 'Ativo'),
(29, 2, 2, 31, '2025-04-29 08:55:23', 'Ativo'),
(30, 2, 7, 31, '2025-04-29 08:55:23', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicos_empresas`
--

CREATE TABLE `medicos_empresas` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data_associacao` int(11) NOT NULL DEFAULT current_timestamp(),
  `status` enum('Ativo','Inativo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicos_empresas`
--

INSERT INTO `medicos_empresas` (`id`, `empresa_id`, `medico_id`, `data_associacao`, `status`) VALUES
(1, 15, 2, 2025, 'Ativo'),
(2, 16, 1, 2025, 'Ativo'),
(3, 19, 1, 2147483647, 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `duracao` int(11) NOT NULL COMMENT 'Duração em dias',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `planos`
--

INSERT INTO `planos` (`id`, `nome`, `descricao`, `preco`, `duracao`, `criado_em`) VALUES
(1, 'Plano Básico', 'Acesso ao sistema com recursos básicos', 49.90, 30, '2025-01-04 00:53:56'),
(2, 'Plano Profissional', 'Recursos avançados e relatórios', 99.90, 90, '2025-01-04 00:53:56'),
(3, 'Plano Corporativo', 'Todos os recursos para empresas', 199.90, 365, '2025-01-04 00:53:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `nivel_acesso` enum('admin','operador','cliente') DEFAULT 'cliente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `empresa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha_hash`, `nivel_acesso`, `criado_em`, `empresa_id`) VALUES
(1, 'Luis Silva', 'admin@empresa.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2025-01-07 00:53:41', 1),
(2, 'Vendedor João', 'joao@empresa.com', '21232f297a57a5a743894a0e4a801fc3', 'operador', '2025-01-04 00:53:41', 2),
(3, 'Cliente Maria', 'maria@empresa.com', '21232f297a57a5a743894a0e4a801fc3', 'cliente', '2025-01-04 00:53:41', 3),
(4, 'Vava', 'vava@vsagencia.net', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2025-01-07 19:17:39', 3),
(5, 'Idail', 'neto_br_8@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2025-04-23 03:10:35', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chaves_liberacao`
--
ALTER TABLE `chaves_liberacao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chave` (`chave`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `plano_id` (`plano_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clinicas`
--
ALTER TABLE `clinicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_codigo` (`codigo`),
  ADD KEY `idx_cnpj` (`cnpj`),
  ADD KEY `idx_status` (`status`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_crm` (`crm`),
  ADD KEY `idx_status` (`status`);

--
-- Índices de tabela `medicos_clinicas`
--
ALTER TABLE `medicos_clinicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_medico` (`medico_id`),
  ADD KEY `idx_clinica` (`clinica_id`);

--
-- Índices de tabela `medicos_empresas`
--
ALTER TABLE `medicos_empresas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chaves_liberacao`
--
ALTER TABLE `chaves_liberacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `clinicas`
--
ALTER TABLE `clinicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `medicos_clinicas`
--
ALTER TABLE `medicos_clinicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `medicos_empresas`
--
ALTER TABLE `medicos_empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chaves_liberacao`
--
ALTER TABLE `chaves_liberacao`
  ADD CONSTRAINT `chaves_liberacao_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chaves_liberacao_ibfk_2` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
