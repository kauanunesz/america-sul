# 🌎 Sistema de Países da América do Sul

> **Disciplina:** Desenvolvimento de Sistemas  
> **Tecnologias:** PHP (PDO) + MySQL + HTML5 + CSS3 + Leaflet.js (Mapas) + Upload de Imagens

---

## 📌 Visão Geral do Projeto

O **Sistema de Países da América do Sul** é uma aplicação web completa desenvolvida com arquitetura modular PHP e MySQL. O sistema oferece um **CRUD completo** (Create, Read, Update, Delete) com upload de bandeiras, painel estatístico, busca com filtros, ordenação dinâmica e integração interativa com mapas geográficos através da biblioteca **Leaflet.js**.

---

## 📁 Estrutura de Pastas e Arquivos

```
america-sul/
│
├── banco/
│   └── america_sul.sql         # Script de criação do banco de dados e carga inicial dos 12 países
│
├── css/
│   └── style.css               # Design System moderno, glassmorphism, responsive grid e badges
│
├── includes/
│   ├── header.php              # Cabeçalho global com menu de navegação e botões obrigatórios
│   └── footer.php              # Rodapé global e scripts da biblioteca Leaflet.js
│
├── uploads/                    # Diretório de armazenamento das imagens das bandeiras
│   ├── argentina.svg
│   ├── bolivia.svg
│   ├── brasil.svg
│   ├── chile.svg
│   ├── colombia.svg
│   ├── ecuador.svg
│   ├── guayana.svg
│   ├── paraguay.svg
│   ├── peru.svg
│   ├── suriname.svg
│   ├── uruguay.svg
│   └── venezuela.svg
│
├── conexao.php                 # Conexão PDO segura com tratamento de erros UTF-8
├── index.php                   # Página principal com banner hero, estatísticas, botões e mapa geral
├── listar_paises.php           # Listagem em cards com pesquisa por nome, ordenação e ações CRUD
├── cadastrar_pais.php          # Formulário completo de cadastro de país com upload de foto
├── salvar_pais.php             # Processamento do formulário de inserção (INSERT PDO + Upload)
├── detalhes.php                # Ficha técnica individual do país e mapa interativo Leaflet
├── editar_pais.php             # Formulário de edição preenchido
├── atualizar_pais.php          # Processamento da atualização de dados e bandeira (UPDATE PDO)
├── excluir_pais.php            # Processamento de exclusão do registro e limpeza da bandeira (DELETE PDO)
└── README.md                   # Manual de instalação no XAMPP, documentação e exercícios
```

---

## 🚀 Guia de Instalação e Execução no XAMPP

### Passo 1: Copiar os arquivos para o XAMPP
1. Baixe ou copie a pasta do projeto `america-sul`.
2. Cole a pasta dentro do diretório `htdocs` do seu XAMPP.  
   - Exemplo no Windows: `C:\xampp\htdocs\america-sul`

### Passo 2: Iniciar os Serviços Apache e MySQL
1. Abra o **XAMPP Control Panel**.
2. Clique no botão **Start** ao lado de **Apache**.
3. Clique no botão **Start** ao lado de **MySQL**.

### Passo 3: Importar o Banco de Dados no phpMyAdmin
1. Acesse no navegador: [`http://localhost/phpmyadmin`](http://localhost/phpmyadmin)
2. No menu superior, clique em **Bancos de Dados**.
3. No campo *Nome do banco de dados*, digite `america_sul` e selecione o agrupamento `utf8mb4_unicode_ci`. Clique em **Criar**.
4. Selecione o banco de dados `america_sul` recém-criado na barra lateral esquerda.
5. Clique na aba **Importar** no topo da tela.
6. No campo *Arquivo a importar*, clique em **Escolher arquivo** e selecione o arquivo `banco/america_sul.sql` da pasta do projeto.
7. Role até o final da página e clique no botão **Importar**.

### Passo 4: Acessar o Sistema
Acesse o sistema através da URL no seu navegador:
👉 [`http://localhost/america-sul`](http://localhost/america-sul)

---

## 💡 Roteamento e Explicação Técnica do Código

### 1. Conexão com PDO (`conexao.php`)
A aplicação utiliza a biblioteca **PDO (PHP Data Objects)** com tratamento de exceções `PDOException`. Caso o MySQL não esteja rodando, uma tela didática e amigável é exibida informando o estudante sobre os passos de resolução no XAMPP.

### 2. Upload de Arquivos de Imagem (`salvar_pais.php` / `atualizar_pais.php`)
- Os formulários utilizam o atributo `enctype="multipart/form-data"`.
- O servidor valida a extensão do arquivo enviado (suporta `PNG`, `JPG`, `JPEG`, `SVG`, `WEBP`).
- Os arquivos são salvos com nomes sanitizados e timestamp na pasta `uploads/`.

### 3. Integração com Leaflet Maps (`detalhes.php` / `index.php`)
- O sistema utiliza a biblioteca JavaScript open-source **Leaflet.js**.
- As coordenadas geográficas (Latitude e Longitude) armazenadas no MySQL são convertidas em marcadores dinâmicos no mapa com popups customizados.

---

## 📚 Exercícios Práticos para Alunos

Para consolidar os aprendizados em **PHP, MySQL, CRUD e CSS**, execute os seguintes desafios propostos:

### 🧩 Exercício 1: Filtro por Nível de IDH
* **Objetivo:** Adicionar um botão de atalho na tela `listar_paises.php` que filtre apenas os países com **IDH Muito Alto (IDH > 0.800)** (Ex: Argentina, Chile, Uruguai).
* **Dica:** Utilize uma condição SQL `WHERE idh >= 0.800`.

### 🧩 Exercício 2: Cálculo de Densidade Demográfica
* **Objetivo:** Na página `detalhes.php`, calcular e exibir a **Densidade Demográfica** (Habitantes por Km²) dividindo a população total pela área.
* **Dica:** Converta os textos de população e área para números em PHP com `str_replace` ou regex e faça a divisão.

### 🧩 Exercício 3: Alternador de Tema (Light / Dark Mode)
* **Objetivo:** Criar um botão no cabeçalho (`includes/header.php`) que altere as variáveis CSS do `:root` via JavaScript para alternar entre Dark Mode e Light Mode.

### 🧩 Exercício 4: Relatório de Impressão
* **Objetivo:** Adicionar um botão "Imprimir Ficha" na página `detalhes.php` que utilize a função `window.print()` com um CSS `@media print` para ocultar menus e botões na hora da impressão.

### 🧩 Exercício 5: Adicionar Campo "Clima Predominante"
* **Objetivo:** Alterar a tabela `paises` no MySQL (acrescentar coluna `clima VARCHAR(50)`), atualizar os formulários de cadastro e edição para incluir esse novo campo e exibi-lo nos cards.
