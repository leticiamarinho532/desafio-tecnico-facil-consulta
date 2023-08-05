# Desafio Técnico

## Uma API para listar, adicionar e atualizar as cidades, médicos e pacientes cadastrados no banco de dados.

### Sumário

1. Documentação da API
2. Tecnologias
3. BoilerPlate
4. Como usar na sua máquina
    - Clonando
    - Definindo Variáveis de Ambiente
    - Rodando
5. Testes
    - Unidade / Integração
    - Como Está sendo usado o banco de dados

## **1. Documentação da API**
Foi utilizado a collection disponibilizada no desafio técnico e adicionado algumas informações>

https://documenter.getpostman.com/view/8202053/2s9XxyRDLS

## **2. Tecnologias**
1. PHP 8.1
2. Laravel 10.10
3. JWT (tymon/jwt-auth) 2.0
4. MYSql 8.0
6. PHPUnit 10.1

## **3. Boilerplate**

Com o uso do laravel, existe pastas e arquivos que são default.
Código que foi feito/alterado por mim está localizado nas seguintes pastas:

```
.
├── app                    
│   |
│   ├── Http                                    # Here
│   ├── Models                                  # Here
│   ├── Repositories                            # Here
│   └── Services                                # Here
│   └── ... 
├── config
├── ...
├── database                                    # Here
|
├── ...               
├── ...
├── routes                                      # Here
├── ...
├── tests                                       # Here
└── .env                                        # Here
└── .env.testing                                # Here
└── .gitignore                                # Here
```

## **4. Como usar na sua máquina**

#### Clonando
- Instale o Docker no seu local [site Docker](https://docs.docker.com/desktop/).
- Clone  esse repositório.

#### Definindo Variáveis de Ambiente
- Copie a .env.example para o arquivo .env
#### Rodando

- Rode esse comando `./vendor/bin/sail up` (no terminal) na pasta raiz (onde o arquivo docker-compose.yaml está).
- Use seu Ip local para usar as rotas do back-end que estão na documentação da api.
- Já tem migrations e seeders prontas para uso! para utiliza-las é necessário rodar o comando `./vendor/bin/sail artisan migrate` e depois `./vendor/bin/sail artisan db:seed`.

## **5. Testes**
- Unidade / Integração

    Os testes de unidade foram aplicados para assegurar comportamento correto nos menores pedaços de código, que nesse projeto se encontram nos `Services`.

    Os testes de integração foram aplicados para assegurar que a junção de tecnologias, que no caso foi a junção com banco de dados, funcione corretamente.

    Para executar os testes, roda o comando `./vendor/bin/sail test`.

- Como Está sendo usado o banco de dados

    Para os testes não poluirem o banco principal, foi utilizado um outro database na mesma conexão o principal (laravel sail cria automaticamente esse database). Foi utilizado um arquivo `.env` de testes, com nome de `env.testing` e para os testes funcinarem corretamente, é necessário rodar as migrations no banco de teste com o comando `./vendor/bin/sail artisan migrate --env=testing`.
