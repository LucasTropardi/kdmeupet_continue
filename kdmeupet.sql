-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Ago-2023 às 04:31
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `kdmeupet`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_adocao`
--

CREATE TABLE `cadastro_adocao` (
  `p_id` int(10) NOT NULL,
  `p_nome` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `p_foto` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `p_descricao` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `p_contato` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `p_idade` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `p_tipo` int(10) DEFAULT NULL,
  `p_raca` int(10) DEFAULT NULL,
  `p_tamanho` int(10) DEFAULT NULL,
  `p_cor` int(10) DEFAULT NULL,
  `p_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `cadastro_adocao`
--

INSERT INTO `cadastro_adocao` (`p_id`, `p_nome`, `p_foto`, `p_descricao`, `p_contato`, `p_idade`, `p_tipo`, `p_raca`, `p_tamanho`, `p_cor`, `p_status`) VALUES
(1, 'Bolinha', '7070faac4467291cd454cc6a52aa0ab5.jpg', 'teste ok, cachorro dócil para ser adotado. ', 'Apap', '10 anos', 2, 24, 1, 8, 1),
(4, 'Doguinho', '', 'Cachorro bem tranquilo que precisa de um lar.', 'Apap', '1 ano', 2, 15, 1, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_adocao_interesse`
--

CREATE TABLE `cadastro_adocao_interesse` (
  `i_id` int(11) NOT NULL,
  `i_adocao` int(11) NOT NULL,
  `i_usuario` int(11) NOT NULL,
  `i_mensagem` varchar(250) DEFAULT NULL,
  `i_lida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cadastro_adocao_interesse`
--

INSERT INTO `cadastro_adocao_interesse` (`i_id`, `i_adocao`, `i_usuario`, `i_mensagem`, `i_lida`) VALUES
(1, 1, 1, 'Que doguinho lindo, quero ele pra mim!', 1),
(2, 1, 3, 'Me interessei nesse pet. ', 1),
(3, 4, 3, 'Gostei, queria ele.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_animal`
--

CREATE TABLE `cadastro_animal` (
  `c_id` int(11) NOT NULL,
  `c_nomeanimal` varchar(250) DEFAULT NULL,
  `c_foto` varchar(250) DEFAULT NULL,
  `c_descricao` text DEFAULT NULL,
  `c_usuario` int(11) DEFAULT NULL,
  `c_raca` int(11) DEFAULT NULL,
  `c_tamanho` int(11) DEFAULT NULL,
  `c_data` datetime DEFAULT NULL,
  `c_finalizado` int(11) DEFAULT NULL,
  `id_cor` int(11) DEFAULT NULL,
  `c_situacao` int(11) DEFAULT NULL,
  `c_endereco` varchar(200) DEFAULT NULL,
  `c_contato` varchar(200) DEFAULT NULL,
  `c_latitude` varchar(200) NOT NULL,
  `c_longitude` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_animal`
--

INSERT INTO `cadastro_animal` (`c_id`, `c_nomeanimal`, `c_foto`, `c_descricao`, `c_usuario`, `c_raca`, `c_tamanho`, `c_data`, `c_finalizado`, `id_cor`, `c_situacao`, `c_endereco`, `c_contato`, `c_latitude`, `c_longitude`) VALUES
(34, 'cadelo', '119137dba0a714d755120cb26c6c961e.jpg', 'um animal gordos', 9, 45, 2, '2022-11-15 22:30:48', 1, 15, 1, '', 'jj.jose@outlook.com', '', ''),
(41, 'Miento', 'bd056b15c4d127b8b2307d7c73036fe6.jpg', 'Gato encontrado próximo a FUNEPE. De tanta fome que o bichinho estava, não teve nem medo do resgate.\r\nAgora ele está alimentado, a espera de seu dono. Caso não apareça, irá para adoção, mas não voltará a situação de abandono que foi encontrado.', 13, 14, 1, '2022-11-17 20:31:11', 1, 21, 1, NULL, '18 995989698', '-21.426427888827693', '-50.07163385515056'),
(42, 'Bóris', '', 'Cachorro dócil e brincalhão, fugiu de casa com os rojões que soltaram ontem a noite (17/11/2022).', 13, 31, 3, '2022-11-18 19:52:20', 1, 4, 2, NULL, '11 35387512', '-21.4326099204503', '-50.07097828764042'),
(44, 'Rastero', '88f8b4d5238122ead7dcdabdffa2d41a.jpg', 'Cachorro manso, fugiu de casa durante a queima de fogos de artifício ontem a noite.', 13, 15, 2, '2022-11-18 20:13:16', 1, 1, 2, NULL, '65 52336565', '-21.428206599567517', '-50.071134415883925'),
(48, 'Miau', '86bf708dad8b82e1458dbbc53b154c71.jpg', 'Gato manso e brincalhão.', 13, 6, 1, '2022-11-27 00:02:26', 1, 14, 2, NULL, '18 9898998898', '-21.427531485558426', '-50.07045730618709'),
(50, 'Cachorro', '4db6587eec02024b2d5c29e467c84439.jpg', 'Cachorro', 21, 24, 1, '2022-12-01 19:02:09', 1, 2, 1, NULL, '18 98989898', '-21.42039541177911', '-50.07364002578445'),
(53, 'Belka e Strelka', '2d70387f6226674d7bfe08e485e01ad9.jpg', 'Duas cachorrinhas fêmeas com duas semanas de idade no máximo, dóceis e brincalhonas, Zona Sul de SP, entrego no metrô, doação responsável.', 31, 15, 1, '2023-04-21 16:04:16', 1, 20, 1, NULL, '(11)989578940', '-23.659586068927844', '-46.67125042717117'),
(54, 'Caramelo', '72b08c10363531ae7276ce3b5a144af3.png', '**CACHORRO REALMENTE ACHADO, DADOS REAIS**\r\n\r\nEsse cãozinho encontra-se próximo à FUNEPE, no entroncamento da Av São José com a Rua Brasil.\r\nProcura-se o responsável.', 13, 15, 2, '2023-05-05 12:17:32', 0, 25, 1, NULL, '(18) 99730 0117 / contato@kdmeupetplis.com.br', '-21.427509966141358', '-50.07188558578492'),
(55, 'bob', '', 'bonito e saudável', 33, 45, 1, '2023-05-12 22:31:15', 1, 25, 2, NULL, '', '', ''),
(56, 'Bobzinho', '', 'bonito e saudavel', 33, 46, 1, '2023-05-12 22:33:56', 1, 20, 2, NULL, '', '', ''),
(57, 'cachorro', NULL, 'Cachorro grande', 35, 31, 3, '2023-08-28 11:24:55', 0, 6, 1, NULL, '18 9898998898', '-21.420250043111082', '-50.07417766100868'),
(62, 'Fulano José', 'a50e3d698aaed7e60fe4e9844f51fadc.png', 'Gato do mato que não pega rato.', 38, 14, 1, '2023-08-29 22:40:01', 0, 21, 2, NULL, 'lucas@gmail.com', '-21.41772436620722', '-50.06247525632617');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_cor`
--

CREATE TABLE `cadastro_cor` (
  `c_id` int(11) NOT NULL,
  `c_cor` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_cor`
--

INSERT INTO `cadastro_cor` (`c_id`, `c_cor`) VALUES
(1, 'Preto'),
(2, 'Branco'),
(3, 'Amarelo'),
(4, 'Laranja'),
(5, 'Marrom'),
(6, 'Cinza'),
(7, 'Cinza Azul'),
(8, 'Bege'),
(9, 'Malhado Branco e Preto'),
(10, 'Malhado Branco e Laranja'),
(11, 'Malhado Branco e Amarelo'),
(12, 'Malhado Branco e Cinza'),
(13, 'Malhado Branco e Cinza Azul'),
(14, 'Malhado Branco e Marrom'),
(15, 'Malhado Branco e Bege'),
(16, 'Malhado Bege e Marrom'),
(17, 'Malhado Preto e Amarelo'),
(18, 'Malhado Amarelo e Laranja'),
(19, 'Malhado Marrom e Preto'),
(20, 'Malhado Bege e Preto'),
(21, 'Malhado três cores ou mais'),
(22, 'Outra'),
(23, 'Verde'),
(24, 'verde malhada'),
(25, 'Caramelo'),
(26, 'Cor-de-rosa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_gerenciador`
--

CREATE TABLE `cadastro_gerenciador` (
  `g_id` int(11) NOT NULL,
  `g_email` varchar(250) DEFAULT NULL,
  `g_senha` varchar(250) DEFAULT NULL,
  `g_nivel` int(11) DEFAULT NULL,
  `g_nome` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_gerenciador`
--

INSERT INTO `cadastro_gerenciador` (`g_id`, `g_email`, `g_senha`, `g_nivel`, `g_nome`) VALUES
(7, 'contato@kdmeupetplis.com.br', '$2y$10$SPouHThIcXkVXB4q1741pebCM2UL6hsijaRU.8hRWZVSKOuz19mj6', 0, 'Administrador do site');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_raca`
--

CREATE TABLE `cadastro_raca` (
  `r_id` int(11) NOT NULL,
  `r_nome` varchar(250) DEFAULT NULL,
  `r_tipos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_raca`
--

INSERT INTO `cadastro_raca` (`r_id`, `r_nome`, `r_tipos`) VALUES
(1, 'Perça', 1),
(2, 'Brithis Shorthair', 1),
(3, 'Sphynx', 1),
(4, 'Siamês', 1),
(5, 'Angorá', 1),
(6, 'Maine Coon', 1),
(7, 'Himalaio', 1),
(8, 'Bengal', 1),
(9, 'Ragdoll', 1),
(10, 'Munchkin', 1),
(11, 'Scottish Fold', 1),
(12, 'Abissínio', 1),
(13, 'Birmanês', 1),
(14, 'SRD', 1),
(15, 'SRD', 2),
(16, 'Pug', 2),
(17, 'Maltês', 2),
(18, 'Shih Tzu', 2),
(19, 'Buldogue', 2),
(20, 'Pit Bull', 2),
(21, 'Spitz Alemão', 2),
(22, 'Dachshund', 2),
(23, 'Pastor Alemão', 2),
(24, 'Basset', 2),
(25, 'Schnauzer', 2),
(26, 'Poodle', 2),
(27, 'Rottweiler', 2),
(28, 'Labrador', 2),
(29, 'Pinscher', 2),
(30, 'Lasha Apso', 2),
(31, 'Golden Retriever', 2),
(32, 'Yorkshire', 2),
(33, 'Border Collie', 2),
(34, 'Beagle', 2),
(35, 'Boxer', 2),
(36, 'Chihuahua', 2),
(37, 'Cocker', 2),
(38, 'Chow Chow', 2),
(39, 'Corgi', 2),
(40, 'Buldogue Francês', 2),
(41, 'Buldogue Inglês', 2),
(42, 'Bull Terrier', 2),
(43, 'Dog de Bordeaux', 2),
(44, 'Husky Siberiano', 2),
(45, 'Fox Paulistinha', 2),
(46, 'Dogo Argentino', 2),
(47, 'Pequinês', 2),
(48, 'Poodle Toy', 2),
(49, 'Dalmata', 2),
(50, 'São Bernardo', 2),
(51, 'Whippet', 2),
(52, 'Somali', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_situacao`
--

CREATE TABLE `cadastro_situacao` (
  `s_id` int(11) NOT NULL,
  `s_nome` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_situacao`
--

INSERT INTO `cadastro_situacao` (`s_id`, `s_nome`) VALUES
(1, 'Encontrado'),
(2, 'Perdido');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_tamanho`
--

CREATE TABLE `cadastro_tamanho` (
  `t_id` int(11) NOT NULL,
  `t_nometm` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_tamanho`
--

INSERT INTO `cadastro_tamanho` (`t_id`, `t_nometm`) VALUES
(1, 'Pequeno porte'),
(2, 'Médio porte'),
(3, 'Grande porte');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_tipo`
--

CREATE TABLE `cadastro_tipo` (
  `t_id` int(11) NOT NULL,
  `t_nome` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_tipo`
--

INSERT INTO `cadastro_tipo` (`t_id`, `t_nome`) VALUES
(1, 'Gato'),
(2, 'Cachorro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_usuario`
--

CREATE TABLE `cadastro_usuario` (
  `u_id` int(11) NOT NULL,
  `u_email` varchar(250) DEFAULT NULL,
  `u_senha` varchar(250) DEFAULT NULL,
  `u_nomecompleto` varchar(250) DEFAULT NULL,
  `u_endereco` varchar(250) DEFAULT NULL,
  `u_telefone` varchar(250) DEFAULT NULL,
  `u_data` datetime DEFAULT NULL,
  `id_google` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cadastro_usuario`
--

INSERT INTO `cadastro_usuario` (`u_id`, `u_email`, `u_senha`, `u_nomecompleto`, `u_endereco`, `u_telefone`, `u_data`, `id_google`) VALUES
(1, 'hebertn88@gmail.com', 'c33367701511b4f6020ec61ded352059', 'Hebert', 'Rua Vereador Chauky Rahal, 62', '18997687785', NULL, '116522922484011188285'),
(3, 'thaismarqui_g@hotmail.com', '698dc19d489c4e4db73e28a713eab07b', 'Thais Marqui Guilherme', 'Rua Doutor Ramalho Franco', '99141461', NULL, NULL),
(4, 'caique.bsa@gmail.com', 'e108498318fb27a485b301b5c01d24eb', 'caique', 'sadadsaasdaqs', '1065106510', NULL, '108666645620833733209'),
(5, 'lulu.silva@hotmail.com', '200820e3227815ed1756a6b531e7e0d2', 'Luiz Henrique', 'Rua lulu', '18996396733', NULL, NULL),
(6, 'rrsilva@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Robervaldo Romualdo Silva', 'Rua dos imigrantes 389, Penápolis', '18252627289', NULL, NULL),
(7, 'gabreus@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Gerônimo da Silva Abreu', 'Av dos Bandeirantes 259', '18998899899', NULL, NULL),
(8, 'jj.jose@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 'João José', 'Rua dos imigrantes 389, PenÃ¡polis', '18994550201', NULL, NULL),
(9, 'robervaldopereira@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 'Robervaldo Silva Pereira', 'Rua do mineiro 618', '18 9565995624', NULL, NULL),
(10, 'brunohenriqueadm@hotmail.com', '1c63129ae9db9c60c3e8aa94d3e00495', 'Bruno', 'Av 123 penapolis', '18996559547', NULL, NULL),
(13, 'lucastropardi@gmail.com', NULL, 'Lucas Carvalhal Tropardi', NULL, NULL, NULL, '117530769135423713863'),
(14, 'antoniotropardi@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Antonio Carlos Tropardi', 'Avenida virando da rua na esquina, 178', '18 34782588', NULL, NULL),
(15, '2000517@aluno.univesp.br', NULL, 'LUCAS CARVALHAL TROPARDI', NULL, NULL, NULL, '116102945017912881546'),
(16, 'antoniocarlostropardi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Antonio Carlos Tropardi', 'rua virando a esquina da avenida, 628', '18 368565841', NULL, '117158649949961419320'),
(19, 'andrelinasantonio@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Andrelina Antonio dos Santos', 'Rua do mineiro, 963', '18 877578985', NULL, NULL),
(20, 'lucas@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lucas Completo', 'av 123456', '18 98989898', NULL, NULL),
(21, 'lucas@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'lucas', 'rua que vira na esquina da avenida 123', '18 989898988', NULL, NULL),
(22, 'teste@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', 'Lucas', 'Rua da esquina curva, 365', '18981582946', NULL, NULL),
(23, 'wesley.ramosborges@gmail.com', '98c83b22ae198b8a2762e0cd11cca51f', 'Wesley Ramos', NULL, NULL, NULL, '118188081839787954276'),
(24, 'jg@g.com', 'e10adc3949ba59abbe56e057f20f883e', 'hot bacon', 'este é um endereço', '12988845487', NULL, NULL),
(25, 'brunolli.sp@gmail.com', 'fe167d7ce615c317ed2eaf8b77da2e38', 'Bruno Alves', NULL, NULL, NULL, '108004558339014410680'),
(26, 'ipoiop@ho.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'mailson', 'mnbmnb', '~çl~çl', NULL, NULL),
(27, 'evvihls@gmail.com', '98affdbaca6a1711454001c65eebf1d8', 'Emily Vitória', NULL, NULL, NULL, '111006010109327699879'),
(28, 'gabrieljhonatan2003@gmail.com', 'ca5785bd35eda7d436254e02e6357237', 'Gabriel Jhonatan Balbino Chaves', 'Rua Chauá 66', '11946434759', NULL, NULL),
(29, 'lucas10nov@gmail.com', '0b4cfc77502312c1ba497c0bc6a7473b', 'Lucas Silva Freire de Souza ', 'Viela limeira 14 a ', '11977378171', NULL, NULL),
(30, 'amandaduraes255@gmail.com', '30712a27ab220c508dd32f5ae62ee06b', 'Amanda Durães', NULL, NULL, NULL, '104242843980907029693'),
(31, 'orlandodemoraesferia@gmail.com', 'ab2083f99fb41e7b26650bb05a0fd084', 'Gabriela Pieratti Stellato', NULL, NULL, NULL, '118257889679664265848'),
(32, 'gscgabriela.2005@gmail.com', '27dcecd587345ca13746e33a7ee1ba1e', 'Gabih Cruz', NULL, NULL, NULL, '105602558914768938604'),
(33, 'bob@bob.com', '9f9d51bc70ef21ca5c14f307980a29d8', 'bobzera', 'rua bob, numero bob', '11999999999', NULL, NULL),
(34, 'novousuario@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'novo usuario', 'Rua das avenidas número 1234', '18 987898789', NULL, NULL),
(35, 'pedroroberto@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Pedro Roberto da Silva', 'Aquela rua com aquela casa lá', '19854512541', NULL, NULL),
(36, 'caiocaiaio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Caio Caiaio', 'Minha Casa', '18981582946', NULL, NULL),
(37, 'lucastropardi@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lucas Carvalhal Tropardi', 'Minha Casa', '18981582946', NULL, NULL),
(38, 'antoniotropardi@gmail.com', '$2y$10$h7nirpoL5LEpem8pL4NUYes3XUQ6mUMj8svGzpxBbEQqeX73eSOrS', 'Antonio Carlos Tropardi', 'Av Alberto Domingues da Silva 218, Vila Formosa', '18 98197 1737', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contacts_msg`
--

CREATE TABLE `contacts_msg` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contato_organizacao` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(250) NOT NULL,
  `aprovado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `contacts_msg`
--

INSERT INTO `contacts_msg` (`id`, `nome`, `email`, `telefone`, `titulo`, `msg`, `contato_organizacao`, `created`, `imagem`, `aprovado`) VALUES
(46, 'Lucas Carvalhal Tropardi', 'lucastropardi@hotmail.com', '18981582946', 'Organização mais desorganizada', 'Um resumo tão bem resumido que não contem informações...', '18 98989889', '2023-08-28 19:54:43', '01706edeef6d089e377386f65c551de0.jpg', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cadastro_adocao`
--
ALTER TABLE `cadastro_adocao`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `cadastro_adocao_ibfk_1` (`p_tipo`),
  ADD KEY `cadastro_adocao_ibfk_2` (`p_raca`),
  ADD KEY `cadastro_adocao_ibfk_3` (`p_tamanho`),
  ADD KEY `cadastro_adocao_ibfk_4` (`p_cor`);

--
-- Índices para tabela `cadastro_adocao_interesse`
--
ALTER TABLE `cadastro_adocao_interesse`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `FK_interesse_adocao` (`i_adocao`),
  ADD KEY `FK_interesse_usuario` (`i_usuario`);

--
-- Índices para tabela `cadastro_animal`
--
ALTER TABLE `cadastro_animal`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `cadastro_animal_ibfk_1` (`c_usuario`),
  ADD KEY `cadastro_animal_ibfk_3` (`c_tamanho`),
  ADD KEY `cadastro_animal_ibfk_4` (`c_situacao`),
  ADD KEY `cadastro_animal_ibfk_2` (`c_raca`),
  ADD KEY `cadastro_animal_ibfk_5` (`id_cor`);

--
-- Índices para tabela `cadastro_cor`
--
ALTER TABLE `cadastro_cor`
  ADD PRIMARY KEY (`c_id`);

--
-- Índices para tabela `cadastro_gerenciador`
--
ALTER TABLE `cadastro_gerenciador`
  ADD PRIMARY KEY (`g_id`);

--
-- Índices para tabela `cadastro_raca`
--
ALTER TABLE `cadastro_raca`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `cadastro_raca_ibfk_1` (`r_tipos`);

--
-- Índices para tabela `cadastro_situacao`
--
ALTER TABLE `cadastro_situacao`
  ADD PRIMARY KEY (`s_id`);

--
-- Índices para tabela `cadastro_tamanho`
--
ALTER TABLE `cadastro_tamanho`
  ADD PRIMARY KEY (`t_id`);

--
-- Índices para tabela `cadastro_tipo`
--
ALTER TABLE `cadastro_tipo`
  ADD PRIMARY KEY (`t_id`);

--
-- Índices para tabela `cadastro_usuario`
--
ALTER TABLE `cadastro_usuario`
  ADD PRIMARY KEY (`u_id`);

--
-- Índices para tabela `contacts_msg`
--
ALTER TABLE `contacts_msg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro_adocao`
--
ALTER TABLE `cadastro_adocao`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cadastro_adocao_interesse`
--
ALTER TABLE `cadastro_adocao_interesse`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cadastro_animal`
--
ALTER TABLE `cadastro_animal`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `cadastro_cor`
--
ALTER TABLE `cadastro_cor`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `cadastro_gerenciador`
--
ALTER TABLE `cadastro_gerenciador`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `cadastro_raca`
--
ALTER TABLE `cadastro_raca`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `cadastro_situacao`
--
ALTER TABLE `cadastro_situacao`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cadastro_tamanho`
--
ALTER TABLE `cadastro_tamanho`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cadastro_tipo`
--
ALTER TABLE `cadastro_tipo`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cadastro_usuario`
--
ALTER TABLE `cadastro_usuario`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `contacts_msg`
--
ALTER TABLE `contacts_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cadastro_adocao`
--
ALTER TABLE `cadastro_adocao`
  ADD CONSTRAINT `cadastro_adocao_ibfk_1` FOREIGN KEY (`p_tipo`) REFERENCES `cadastro_tipo` (`t_id`),
  ADD CONSTRAINT `cadastro_adocao_ibfk_2` FOREIGN KEY (`p_raca`) REFERENCES `cadastro_raca` (`r_id`),
  ADD CONSTRAINT `cadastro_adocao_ibfk_3` FOREIGN KEY (`p_tamanho`) REFERENCES `cadastro_tamanho` (`t_id`),
  ADD CONSTRAINT `cadastro_adocao_ibfk_4` FOREIGN KEY (`p_cor`) REFERENCES `cadastro_cor` (`c_id`);

--
-- Limitadores para a tabela `cadastro_adocao_interesse`
--
ALTER TABLE `cadastro_adocao_interesse`
  ADD CONSTRAINT `FK_interesse_adocao` FOREIGN KEY (`i_adocao`) REFERENCES `cadastro_adocao` (`p_id`),
  ADD CONSTRAINT `FK_interesse_usuario` FOREIGN KEY (`i_usuario`) REFERENCES `cadastro_usuario` (`u_id`);

--
-- Limitadores para a tabela `cadastro_animal`
--
ALTER TABLE `cadastro_animal`
  ADD CONSTRAINT `cadastro_animal_ibfk_1` FOREIGN KEY (`c_usuario`) REFERENCES `cadastro_usuario` (`u_id`),
  ADD CONSTRAINT `cadastro_animal_ibfk_2` FOREIGN KEY (`c_raca`) REFERENCES `cadastro_raca` (`r_id`),
  ADD CONSTRAINT `cadastro_animal_ibfk_3` FOREIGN KEY (`c_tamanho`) REFERENCES `cadastro_tamanho` (`t_id`),
  ADD CONSTRAINT `cadastro_animal_ibfk_4` FOREIGN KEY (`c_situacao`) REFERENCES `cadastro_situacao` (`s_id`),
  ADD CONSTRAINT `cadastro_animal_ibfk_5` FOREIGN KEY (`id_cor`) REFERENCES `cadastro_cor` (`c_id`);

--
-- Limitadores para a tabela `cadastro_raca`
--
ALTER TABLE `cadastro_raca`
  ADD CONSTRAINT `cadastro_raca_ibfk_1` FOREIGN KEY (`r_tipos`) REFERENCES `cadastro_tipo` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
