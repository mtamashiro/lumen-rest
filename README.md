# lumen-rest
## Resumo
API criada para um desafio PHP

## Objetivo
Criar api para efetuar transferências entre contas PF para PJ ou PF e 
somente a conta PF tem permissão de transferência.

## Tecnologias usadas

+ Docker
+ Lumen Framework
+ MySQL
+ NGINX

## Quickstart
### Pré-requisitos

+ Ter o docker instalado em seu ambiente
+ Para instalar é necessário que as seguintes portas do seu ambiente 
  estejam abertas:
<br>`80  9000 3306`
  
### Rodando o projeto

+ Clone o repositório utilizando `git clone --depth=1
  https://github.com/mtamashiro/lumen-rest.git`
+ Acesse a pasta do projeto `cd lumen-rest`
+ suba os containers: `docker-compose up --build -d`
+ acesse a image: `docker exec -it php /bin/sh` ou `docker exec -it php
  bash`
+ dentro da imagem, execute para adicionar as dependências
de exemplo: `composer update`
+ dentro da imagem, execute para criar as tabelas e adicionar os seeds
  de exemplo: `php artisan migrate:fresh --seed`
+ utilize o comando para rodar os testes: `./vendor/bin/pphunit`

### Documentação da API

As rotas disponíveis pode ser consultadas em: 
https://app.swaggerhub.com/apis/mtamashiro/lumen-rest/1.0.0

### Decisões de Engenharia/Arquitetura

Para a aplicação, a estrutura padrão do Lumen/Laravel foi alterado para 
ficar mais semelhante com o **"Laravel Beyond CRUD"** proposto pelo 
Brant 
Roose da Spatie.<br>
link para série de artigos sobre o Laravel Beyond CRUD:
https://stitcher.io/blog/laravel-beyond-crud-01-domain-oriented-laravel
<br>
O ideal desse design é para aplicações médias/grandes mas foi usado para
a prática da atividade.<br>
A idéia desse design é separar a aplicação da lógica do negócio 
utilizando uma camada denominada **DOMAIN** (é semelhante ao Domain de 
DDD mas não é igual).<br>
Utiliza-se o padrão **DTO** para ser a ponte de comunicação entre a 
camada 
Aplicação e a camada de Domínio, isso serve para garantir que os dados
que serão executados pelas ações do domínio não sofram alteração ( Isso
é especialmente importante porque o PHP possui tipagem fraca).<br>
Dentro do Domínio cada entidade executa diversas ações e cada ação é o
mais semelhante possível a uma ação do mundo real.<br>
A transferência em si possui diversos status (pendente, autorizado,
concluído,etc) e para controlar a transição entre os estados foi
utilizado o padrão **STATE**, Esse padrão remove os if's/switch's da 
aplicação e cada estado possui sua própria lógica de negócio, tornado-as
mais facéis de testar e alterar caso necessário.<br>
Para o usuário PF ou PJ foi utilizado a **Relação Polimórfica** do 
Laravel para definir qual o tipo de usuário de acordo com seu documento.

### Dívida técnica

+ Apesar dessa estrutura proposta pelo Brent Roose separar a aplicação
  do domínio, o domínio em si possui muita depedência do *Eloquent* do 
  Laravel. O ideal seria proteger o domínio criado uma camada 
  de repositório e removendo o ORM da camada de domínio.
+ Para esse projeto não foram criadas *enviroments* para teste ou produção.  
+ Necessário ter um entendimento melhor sobre o domínio do negócio para 
criar uma linguagem ubíqua mais adequada.
+ Devido a lógica do negócio se concentrarem nas classes *Actions* a 
classe modelo pode se tornar um *AnemicDomainModel* (
  https://www.martinfowler.com/bliki/AnemicDomainModel.html
  ) como citado por *Martin Fowler* e é necessário definir melhor se
  esse anti-pattern ainda deve ser utilizado ou não.