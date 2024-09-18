<p align="center"> 
  <a href="" rel="noopener"> 
    <img width=200px height=200px src="https://i.imgur.com/6wj0hh6.jpg" alt="Project logo">
  </a> 
  </p> 
  
  <h3 align="center">Projeto Yii2 Framework API</h3> <div align="center">


[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> 
  Uma API simples para cadastro de clientes e livros, incluindo validação de CEP, CPF e ISBN, com autenticação via Authorization Bearer Token.<br> 
</p>

## 📝 Table of Contents

- [Sobre](#sobre)
- [Como Começar](#comecar)
- [Deploy](#deploy)
- [Uso](#uso)
- [Construído Com](#construido_com)
- [Autor](#autor)

<!-- Comando via terminal para criar o usuario -->

<!-- Trocar login senha nome pelos valores desejados -->


## 🧐 Sobre <a name = "sobre"></a>

Este projeto foi desenvolvido como parte de um teste técnico para a construção de uma API utilizando o framework Yii2. O objetivo é gerenciar o cadastro de clientes e livros, com funcionalidades como a validação de CPF, CEP e ISBN. A autenticação é feita utilizando Authorization Bearer Token, permitindo a criação de usuários e tokens de acesso seguros.

## 🏁 Como Começar <a name = "comecar"></a>

Essas instruções ajudarão você a obter uma cópia do projeto em execução no seu ambiente local para desenvolvimento e testes.

### Pré-requisitos

- PHP 8.0 ou superior
- MySQL 8
- Composer
- Docker (opcional, caso queira usar containers)
- API Client(Postman ou outro API Client de sua preferencia)

### Instalando

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/seu-projeto.git
```

2. Instale as dependências do Composer:
```bash
composer install
```

3. Configure o arquivo `config/db.php` com suas credenciais de banco de dados.
4. Execute os migrates do banco de dados:
```bash
php yii migrate
```

5. Inicie o servidor de desenvolvimento:
```bash
php yii serve
```

## 🎈 Uso <a name="uso"></a>
- Crie o usuário para gerar o Access Token para ser utilizado nas requisições com Authorization Bearer para autenticação, utilizando o comando via terminal:
```bash
php yii user/create login senha nome
```
- Faça requisições para a API utilizando tokens para acessar endpoints protegidos e utilizando o envio via Raw em Json.
- Endpoints disponíveis incluem:
  - `/clientes` para gerenciamento de clientes
    ```
    - GET /clientes: listar todos os clientes página por página;
      Opções de paginação/filtrar/ordenar:
        - GET /clientes?limit=20&offset=0
        - GET /clientes?nome=João&cpf=12345678901
        - GET /clientes?sort=nome
        - GET /clientes?sort=cpf
        - GET /clientes?sort=cidade
    - POST /clientes: criar um novo clientes(Campos: nome, cpf, sexo, cep, logradouro, numero, bairro, cidade, estado);
    - GET /clientes/123: retorna detalhes do cliente 123;
    - PATCH /clientes/123 e PUT /clientes/123: atualiza o cliente 123;
    - DELETE /clientes/123: deleta o cliente 123;
    ```

  - `/livros` para gerenciamento de livros
    ```
    - GET /livros: listar todos os livros página por página;
      Opções de paginação/filtrar/ordenar:
        - GET /livros?limit=20&offset=0
        - GET /livros?titulo=Guerra&preco=100
        - GET /livros?sort=titulo
        - GET /livros?sort=autor
        - GET /livros?sort=isbn
    - POST /livros: criar um novo livros;(Campos: isbn, titulo, autor, preco, estoque)
    - GET /livros/123: retorna detalhes do livro 123;
    - PATCH /livros/123 e PUT /livros/123: atualiza o livro 123;
    - DELETE /livros/123: deleta o livro 123;
    ```
  - Recuperação das informações para autenticação
    ```
    - POST /user/login: listar access_token do usuario(login, password);
    ```


## 🚀 Deploy <a name = "deploy"></a>

Para implantar o projeto em um ambiente de produção, siga as etapas abaixo:

1. Configure o servidor com PHP 8.0+, Nginx/Apache, e MySQL.
2. Suba o código para o servidor de produção.
3. Atualize as variáveis para acesso ao banco de dados no arquivo `/config/db.php`.
4. Execute as migrações do banco de dados:
php yii migrate
5. Configure o Nginx/Apache para servir o aplicativo Yii2.

## ⛏️ Construído Com <a name = "construido_com"></a>

- [Yii2](https://www.yiiframework.com/) - Framework
- [MySQL](https://www.mysql.com/) - Banco de Dados
- [OAuth 2.0](https://oauth.net/2/) - Autenticação
- [BrasilAPI](https://brasilapi.com.br/) - Validação do CEP e ISBN

## ✍️ Autor <a name = "autor"></a>

- [@AguiarDG](https://github.com/AguiarDG) 