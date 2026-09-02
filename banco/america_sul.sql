-- ============================================================
-- BANCO DE DADOS: america_sul
-- Projeto: Sistema de Países da América do Sul
-- Tecnologias: PHP + MySQL
-- ============================================================

CREATE DATABASE IF NOT EXISTS `america_sul` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `america_sul`;

-- ------------------------------------------------------------
-- Estrutura da Tabela: `paises`
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `capital` VARCHAR(100) NOT NULL,
  `idioma` VARCHAR(100) NOT NULL,
  `moeda` VARCHAR(100) NOT NULL,
  `populacao` VARCHAR(50) NOT NULL,
  `area` VARCHAR(50) NOT NULL,
  `presidente` VARCHAR(100) NOT NULL,
  `idh` DECIMAL(4,3) NOT NULL,
  `pib` VARCHAR(50) NOT NULL,
  `educacao` ENUM('Alta', 'Média', 'Baixa') NOT NULL DEFAULT 'Média',
  `seguranca` ENUM('Alta', 'Moderada', 'Baixa') NOT NULL DEFAULT 'Moderada',
  `saude` ENUM('Alta', 'Média', 'Baixa') NOT NULL DEFAULT 'Média',
  `latitude` DECIMAL(10,6) NOT NULL DEFAULT 0.000000,
  `longitude` DECIMAL(10,6) NOT NULL DEFAULT 0.000000,
  `descricao` TEXT NOT NULL,
  `bandeira` VARCHAR(255) NOT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- População dos 12 Países da América do Sul
-- ------------------------------------------------------------
INSERT INTO `paises` 
(`id`, `nome`, `capital`, `idioma`, `moeda`, `populacao`, `area`, `presidente`, `idh`, `pib`, `educacao`, `seguranca`, `saude`, `latitude`, `longitude`, `descricao`, `bandeira`) 
VALUES
(1, 'Argentina', 'Buenos Aires', 'Espanhol', 'Peso Argentino', '46.000.000', '2.780.400 Km²', 'Javier Milei', 0.845, 'USD 1.1 Trilhões', 'Alta', 'Moderada', 'Alta', -34.603722, -58.381592, 'A Argentina é o segundo maior país da América do Sul. Destaca-se pela agricultura, turismo, indústria e produção de alimentos. Possui grande importância econômica e cultural no continente.', 'argentina.svg'),

(2, 'Bolívia', 'Sucre', 'Espanhol, Quíchua, Aimará', 'Boliviano', '12.100.000', '1.098.581 Km²', 'Luis Arce', 0.692, 'USD 44 Bilhões', 'Média', 'Moderada', 'Média', -19.033320, -65.262740, 'A Bolívia é um país encravado no centro da América do Sul, famoso pelo Salar de Uyuni, rica diversidade cultural indígena e geografia impressionante que vai dos Andes à Amazônia.', 'bolivia.svg'),

(3, 'Brasil', 'Brasília', 'Português', 'Real', '214.000.000', '8.515.767 Km²', 'Luiz Inácio Lula da Silva', 0.754, 'USD 2.1 Trilhões', 'Média', 'Moderada', 'Média', -15.797500, -47.891900, 'O Brasil é o maior país da América do Sul e o quinto maior do mundo em área. Possui a maior floresta tropical do planeta (Amazônia), biodiversidade inigualável e a maior economia do continente.', 'brasil.svg'),

(4, 'Chile', 'Santiago', 'Espanhol', 'Peso Chileno', '19.500.000', '756.102 Km²', 'Gabriel Boric', 0.855, 'USD 317 Bilhões', 'Alta', 'Alta', 'Alta', -33.448890, -70.669265, 'O Chile é uma estreita faixa de terra entre a Cordilheira dos Andes e o Oceano Pacífico. Possui o maior IDH da América do Sul, forte setor de mineração de cobre e paisagens que vão do Deserto do Atacama às geleiras da Patagônia.', 'chile.svg'),

(5, 'Colômbia', 'Bogotá', 'Espanhol', 'Peso Colombiano', '51.500.000', '1.141.748 Km²', 'Gustavo Petro', 0.752, 'USD 363 Bilhões', 'Média', 'Moderada', 'Média', 4.710989, -74.072092, 'A Colômbia é reconhecida por sua biodiversidade vibrante, produção de café de alta qualidade, flores e rica tradição cultural e literária. É o único país sul-americano com costas nos oceanos Pacífico e Atlântico.', 'colombia.svg'),

(6, 'Equador', 'Quito', 'Espanhol', 'Dólar Americano', '18.000.000', '283.561 Km²', 'Daniel Noboa', 0.740, 'USD 115 Bilhões', 'Média', 'Moderada', 'Média', -0.180653, -78.467838, 'O Equador fica exatamente na linha do Equador e abriga as famosas Ilhas Galápagos, referência mundial em estudos de evolução e biodiversidade marinha.', 'ecuador.svg'),

(7, 'Guiana', 'Georgetown', 'Inglês', 'Dólar da Guiana', '800.000', '214.969 Km²', 'Irfaan Ali', 0.714, 'USD 15 Bilhões', 'Média', 'Moderada', 'Média', 6.801270, -58.155120, 'A Guiana é o único país sul-americano cujo idioma oficial é o inglês. Apresenta forte crescimento econômico recente impulsionado por descobertas de grandes reservas de petróleo no oceano.', 'guayana.svg'),

(8, 'Paraguai', 'Assunção', 'Espanhol, Guarani', 'Guarani', '7.400.000', '406.752 Km²', 'Santiago Peña', 0.717, 'USD 41 Bilhões', 'Média', 'Moderada', 'Média', -25.263740, -57.575926, 'O Paraguai é um país sem saída para o mar com forte produção agropecuária e geração hidroelétrica abundante, com destaque para a usina binacional de Itaipu.', 'paraguay.svg'),

(9, 'Peru', 'Lima', 'Espanhol, Quíchua, Aimará', 'Sol', '33.700.000', '1.285.216 Km²', 'Dina Boluarte', 0.762, 'USD 242 Bilhões', 'Média', 'Moderada', 'Média', -12.046374, -77.042793, 'O Peru foi o coração do Império Inca e abriga Machu Picchu, uma das sete maravilhas do mundo moderno. Possui gastronomia reconhecida mundialmente e rica história arqueológica.', 'peru.svg'),

(10, 'Suriname', 'Paramaribo', 'Holandês', 'Dólar do Suriname', '618.000', '163.820 Km²', 'Chan Santokhi', 0.730, 'USD 3.6 Bilhões', 'Média', 'Moderada', 'Média', 5.852036, -55.203827, 'O Suriname é o menor país independente da América do Sul. Tem o holandês como idioma oficial e ostenta uma das maiores coberturas florestais preservadas do planeta.', 'suriname.svg'),

(11, 'Uruguai', 'Montevidéu', 'Espanhol', 'Peso Uruguaio', '3.400.000', '176.215 Km²', 'Luis Lacalle Pou', 0.809, 'USD 71 Bilhões', 'Alta', 'Alta', 'Alta', -34.901112, -56.164532, 'O Uruguai destaca-se por seus elevados índices de democracia, igualdade social e qualidade de vida. É famoso por sua produção pecuária, litoral praiano e estabilidade institucional.', 'uruguay.svg'),

(12, 'Venezuela', 'Caracas', 'Espanhol', 'Bolívar Soberano', '28.300.000', '916.445 Km²', 'Nicolás Maduro', 0.691, 'USD 93 Bilhões', 'Média', 'Baixa', 'Baixa', 10.480594, -66.903606, 'A Venezuela possui as maiores reservas comprovadas de petróleo do mundo e atrativos naturais exuberantes, como o Salto Ángel, a queda d\'água mais alta da Terra.', 'venezuela.svg');