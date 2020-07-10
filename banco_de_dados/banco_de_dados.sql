-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/01/2020 às 15:18
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ongceu28_ceuazul`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabbaixa`
--

CREATE TABLE `tabbaixa` (
  `idtabbaixa` int(11) NOT NULL,
  `iddoacaobaixa` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idoperadorbaixa` int(11) DEFAULT NULL,
  `idmensageirobaixa` int(11) DEFAULT NULL,
  `databaixa` date DEFAULT NULL,
  `valorbaixa` varchar(45) DEFAULT NULL,
  `vencimentobaixa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabcontato`
--

CREATE TABLE `tabcontato` (
  `idtabcontato` int(11) NOT NULL,
  `idcontribuintecontato` int(11) DEFAULT NULL,
  `idoperadorcontato` int(11) DEFAULT NULL,
  `idmensageirocontato` int(11) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabcontribuinte`
--

CREATE TABLE `tabcontribuinte` (
  `idcontribuinte` int(11) NOT NULL,
  `nomecontribuinte` varchar(45) NOT NULL,
  `idopercontribuinte` int(11) DEFAULT '0',
  `datacadastrocontribuinte` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabdoacao`
--

CREATE TABLE `tabdoacao` (
  `iddoacao` int(11) NOT NULL,
  `idcontribuintedoacao` int(11) DEFAULT NULL,
  `idoperadordoacao` int(11) NOT NULL DEFAULT '0',
  `datainclusaodoacao` date DEFAULT NULL,
  `datavencimentodoacao` date DEFAULT NULL,
  `valordoacao` decimal(5,2) DEFAULT NULL,
  `doacaostatus` int(11) DEFAULT '1',
  `tipodoacao` varchar(1) DEFAULT NULL,
  `idmensageirodoacao` int(11) DEFAULT '0',
  `datamensageirodoacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabendereco`
--

CREATE TABLE `tabendereco` (
  `idtabendereco` int(11) NOT NULL,
  `idoperadorendereco` int(11) DEFAULT NULL,
  `idcontribuinteendereco` int(11) DEFAULT NULL,
  `idmensageiroendereco` int(11) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `rua` varchar(45) DEFAULT NULL,
  `bairro` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `referencia` varchar(200) DEFAULT NULL,
  `obs` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabhistorico`
--

CREATE TABLE `tabhistorico` (
  `idhistorico` int(11) NOT NULL,
  `idcontribuinte` int(11) DEFAULT NULL,
  `historico` varchar(100) DEFAULT NULL,
  `datacontato` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabmensageiro`
--

CREATE TABLE `tabmensageiro` (
  `idmensageiro` int(11) NOT NULL,
  `nomemensageiro` varchar(45) NOT NULL,
  `fonemensageiro` varchar(45) DEFAULT NULL,
  `veiculo` int(11) DEFAULT NULL,
  `placa` varchar(45) DEFAULT NULL,
  `rgmensageiro` varchar(45) DEFAULT NULL,
  `cpfmensageiro` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `taboperador`
--

CREATE TABLE `taboperador` (
  `idoperador` int(11) NOT NULL,
  `nomeoperador` varchar(45) NOT NULL,
  `emailoperador` varchar(45) DEFAULT NULL,
  `comissaoporcent` float DEFAULT '10',
  `comissaofix` float NOT NULL DEFAULT '3',
  `rgoperador` varchar(45) DEFAULT NULL,
  `cpfoperador` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabperfil`
--

CREATE TABLE `tabperfil` (
  `idperfil` int(10) UNSIGNED NOT NULL,
  `nomeperfil` varchar(45) NOT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `tabperfil`
--

INSERT INTO `tabperfil` (`idperfil`, `nomeperfil`, `ativo`) VALUES
(1, 'Administrador', NULL),
(2, 'Operador', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabstatus`
--

CREATE TABLE `tabstatus` (
  `idtabstatus` int(11) NOT NULL,
  `nomestatus` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `tabstatus`
--

INSERT INTO `tabstatus` (`idtabstatus`, `nomestatus`) VALUES
(5, '<p style=\'color: brown\'>Não contribuiu</p>'),
(3, '<p style=\'color: green\'>Quitado</p>'),
(4, '<p style=\'color: grey\'>Indeferido</p>'),
(2, '<p style=\'color: orange\'>Em cobrança</p>'),
(1, '<p style=\'color: red\'>Em aberto</p>');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabusuario`
--

CREATE TABLE `tabusuario` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `ativo` int(11) DEFAULT NULL,
  `idperfilusuario` int(11) DEFAULT NULL,
  `operadorusuario` int(11) DEFAULT NULL,
  `idoperadorusuario` int(11) DEFAULT NULL,
  `idadmusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `tabusuario`
--

INSERT INTO `tabusuario` (`idusuario`, `usuario`, `senha`, `ativo`, `idperfilusuario`, `operadorusuario`, `idoperadorusuario`, `idadmusuario`) VALUES
(1, 'adm', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 0, NULL, NULL)

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabveiculo`
--

CREATE TABLE `tabveiculo` (
  `idtabveiculo` int(11) NOT NULL,
  `nomeveiculo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tabbaixa`
--
ALTER TABLE `tabbaixa`
  ADD PRIMARY KEY (`idtabbaixa`);

--
-- Índices de tabela `tabcategoriacontribuinte`
--
ALTER TABLE `tabcategoriacontribuinte`
  ADD PRIMARY KEY (`idtabcategoriacontribuinte`);

--
-- Índices de tabela `tabcontato`
--
ALTER TABLE `tabcontato`
  ADD PRIMARY KEY (`idtabcontato`),
  ADD UNIQUE KEY `idcontribuinte_UNIQUE` (`idcontribuintecontato`),
  ADD UNIQUE KEY `idoperdador_UNIQUE` (`idoperadorcontato`),
  ADD UNIQUE KEY `idmensageiro_UNIQUE` (`idmensageirocontato`);

--
-- Índices de tabela `tabcontribuinte`
--
ALTER TABLE `tabcontribuinte`
  ADD PRIMARY KEY (`idcontribuinte`),
  ADD UNIQUE KEY `idcontribuinte` (`idcontribuinte`);

--
-- Índices de tabela `tabdoacao`
--
ALTER TABLE `tabdoacao`
  ADD PRIMARY KEY (`iddoacao`),
  ADD UNIQUE KEY `iddoacao` (`iddoacao`);

--
-- Índices de tabela `tabendereco`
--
ALTER TABLE `tabendereco`
  ADD PRIMARY KEY (`idtabendereco`);

--
-- Índices de tabela `tabhistorico`
--
ALTER TABLE `tabhistorico`
  ADD PRIMARY KEY (`idhistorico`),
  ADD UNIQUE KEY `idhistorico` (`idhistorico`);

--
-- Índices de tabela `tabmensageiro`
--
ALTER TABLE `tabmensageiro`
  ADD PRIMARY KEY (`idmensageiro`),
  ADD UNIQUE KEY `idmensageiro` (`idmensageiro`);

--
-- Índices de tabela `taboperador`
--
ALTER TABLE `taboperador`
  ADD PRIMARY KEY (`idoperador`),
  ADD UNIQUE KEY `idoperador` (`idoperador`);

--
-- Índices de tabela `tabperfil`
--
ALTER TABLE `tabperfil`
  ADD PRIMARY KEY (`idperfil`),
  ADD UNIQUE KEY `idperfil` (`idperfil`);

--
-- Índices de tabela `tabstatus`
--
ALTER TABLE `tabstatus`
  ADD PRIMARY KEY (`idtabstatus`),
  ADD UNIQUE KEY `idtabstatus_UNIQUE` (`idtabstatus`),
  ADD UNIQUE KEY `nomestatus_UNIQUE` (`nomestatus`);

--
-- Índices de tabela `tabusuario`
--
ALTER TABLE `tabusuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD UNIQUE KEY `idOper_UNIQUE` (`idoperadorusuario`),
  ADD UNIQUE KEY `idadm_UNIQUE` (`idadmusuario`);

--
-- Índices de tabela `tabveiculo`
--
ALTER TABLE `tabveiculo`
  ADD PRIMARY KEY (`idtabveiculo`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tabbaixa`
--
ALTER TABLE `tabbaixa`
  MODIFY `idtabbaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `tabcategoriacontribuinte`
--
ALTER TABLE `tabcategoriacontribuinte`
  MODIFY `idtabcategoriacontribuinte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabcontato`
--
ALTER TABLE `tabcontato`
  MODIFY `idtabcontato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT de tabela `tabcontribuinte`
--
ALTER TABLE `tabcontribuinte`
  MODIFY `idcontribuinte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT de tabela `tabdoacao`
--
ALTER TABLE `tabdoacao`
  MODIFY `iddoacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=802;

--
-- AUTO_INCREMENT de tabela `tabendereco`
--
ALTER TABLE `tabendereco`
  MODIFY `idtabendereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT de tabela `tabhistorico`
--
ALTER TABLE `tabhistorico`
  MODIFY `idhistorico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabmensageiro`
--
ALTER TABLE `tabmensageiro`
  MODIFY `idmensageiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `taboperador`
--
ALTER TABLE `taboperador`
  MODIFY `idoperador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tabperfil`
--
ALTER TABLE `tabperfil`
  MODIFY `idperfil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tabstatus`
--
ALTER TABLE `tabstatus`
  MODIFY `idtabstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tabusuario`
--
ALTER TABLE `tabusuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
