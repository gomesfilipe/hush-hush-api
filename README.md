# Hush Hush API

API para o aplicativo Hush Hush desenvolvido para a disciplina de Programação Mobile 2023/1.
Ela é responsável por manipular as entidades referentes e Usuários, Postagens, Comentários e Avaliações.

## Autores
Elaine Dias Pires **2020101903**\
Filipe Gomes Arante de Souza **2020100625**

## Tecnologias Utilizadas
- PHP 8.1.23
- Laravel 10.28.0
- PostgreSQL 15

## Rodando API com Docker
Para rodar o backend, siga os seguintes passos:

1. Clonar este repositório localmente;
```
$ git clone <LINK_REPOSITÓRIO>
```

2. Executar o comando ``make`` presente no Makefile. Ele roda o backend na porta 8000, portanto certifique-se dela estar disponível;

```
$ make
```

Aguarde um pouco e... prontinho! O backend já está em execução.

Para encerrar a aplicação, utilize o comando ``make down``.

```
$ make down
```

## Makefile

O Makefile desenvolvido possui comandos além do ``make`` e ``make down``, que foram utilizados no tópico anterior. Confira abaixo:

1. Gerar o arquivo ``.env``. Esse comando apenas faz uma cópia do arquivo ``.env.example``;
```
$ make env
```

2. Importar arquivos de configuração do ``vendor`` e geração do ``.env``. Deve ser executado antes de qualquer outro comando:
```
$ make install
```

3. Sobe os contêineres da API e do Banco de Dados.
```
$ make up
```

4. Derruba os contêineres da API e do Banco de Dados.
```
$ make down
```

5. Reseta e insere dados fictícios no Banco de Dados.
```
$ make seed
```

6. Executa os comandos 2, 3 e 5, respectivamente. Serve para quem quer apenas rodar a aplicação com um único comando.
```
$ make
```

## Documentação com Swagger

Com a API rodando,  acesse a URL abaixo para ver detalhes dos endpoints implementados:

<a href="http://localhost:8000/docs">http://localhost:8000/docs </a>

## Tabelas do Banco de Dados
Foram criadas as tabelas ``users``, ``posts``, ``comments`` e ``evaluations``. Segue abaixo diagrama ER com mais detalhes:

<div style="text-align: center;">
  <img 
    src="readme-assets/hush-hush-db.svg"
    alt="Hush Hush ER Diagram"
    style="max-width: 500px; height: auto"  
  />
</div>
