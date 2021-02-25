<p align="center"><img src="https://raw.githubusercontent.com/MatheusMiliorini/tech-challenge-dm/master/public/img/logo_delivery_much.png" width="200"></p>

# Delivery Much Tech Challenge - PHP 

Este projeto foi realizado visando atender ao desafio ténico para a vaga [Full Stack na Delivery Much](https://boards.greenhouse.io/deliverymuch/jobs/4353203003).

## Tecnologias

- O back-end foi desenvolvido utilizando a última versão da framework PHP [Laravel](https://laravel.com/).
- O front-end foi desenvolvido em Vue.js, utilizando a framework [Quasar](https://quasar.dev/).

## Como iniciar o projeto

### Build da imagem Docker

Após clonar o repositório, acesse o diretório Docker e faça build do Dockerfile com o seguinte comando:
```
docker build . --tag <delivery>:<1.0>
```

```<delivery>``` e ```<1.0>``` são respectivamente o nome da imagem e a versão, podendo ser alterados conforme preferência.

O build da imagem instala tanto o [Composer](https://getcomposer.org/) quanto o [npm](https://www.npmjs.com/), necessários para rodar/desenvolver encima do projeto.

### Iniciando o container

Após o build realizado, utilize o seguinte comando para iniciar o container da aplicação:
```
docker run --name delivery -p 8080:80/tcp -v <caminho>:/var/www/html -d delivery:1.0
```

Uma breve explicação do comando acima:
- ```--name delivery``` é o nome que o container terá. Caso omitido, o Docker irá gerar um nome aleatório;
- ```-p 8080:80/tcp```indica que o container irá mapear a porta 8080 do host para a porta 80 do container;
- ```-v <caminho>:/var/www/html``` faz um binding de armazenamento entre um caminho no host e um caminho no container. Neste caso, o caminho é o local onde o repositório foi clonado, no meu caso ```C:\Users\milio\Desktop\tech-challenge-dm```, e ```/var/www/html``` é o caminho padrão para os sites do Apache;
- ```-d```indica para o container rodar em background;
- E por fim, ```delivery:1.0```é o nome da imagem criada com o comando ```docker build```.

### Instalando as dependências

Agora que o container está rodando, basta instalar os pacotes do PHP utilizando Composer. Apenas para rodar o projeto não é necessário instalar os pacotes npm, pois todos os scripts já estão prontos para uso.

Por comodidade, deixei um script no container que instala todas as dependências, o ```setup.sh```. Para executá-lo, utilizem o seguinte comando:
```
docker exec delivery /setup.sh
```

### Configurando o .env

Para que o back-end possa buscar os gifs na API do Giphy, será necessário informar a chave da API no arquivo <b>.env</b>. Isso pode ser feito por fora do container, visto que os arquivos então compartilhados entre host <-> container.
A chave da API deve ser informada em <b>GIPHY_KEY</b>.

### Está pronto!

Agora basta acessar o endereço [http://localhost:8080](http://localhost:8080) para ver o projeto em execução!

## Desenvolver

O projeto utiliza o webpack através do Laravel Mix. Para isso, alguns scrips npm estão disponíveis para o desenvolvimento:
- ```npm run dev``` faz o bundle dos arquivos em modo desenvolvimento;
- ```npm run prod``` faz o bundle dos arquivos em modo produção;
- ```npm run watch``` faz o bundle em tempo real enquanto o desenvolimento ocorre, acelerando o desenvolvimento.

## Rodando testes

- O back-end acompanha testes para o endpoint de receitas, que podem ser vistos em ```tests\Feature\ListRecipesTest.php```;
- <b>Não indico</b> rodar os testes diretamente através do comando ```.\vendor\bin\phpunit``` <b>dentro</b> do container, pois ao entrar no container utilizando o comando ```docker exec -it delivery bash``` o shell estará usando o usuário root, enquanto que o Apache roda no usuário www-data. Por conta disso, recomendo utilizar o script ```test.sh```;
- Para executar o script, utilize o seguinte comando <b>fora</b> do container: ```docker exec delivery /test.sh```;
- O comando acima habilita o shell para o usuário www-data e roda os testes com ele. Logo após a finalização dos testes, remove o acesso shell.

## Observações

- Como a API RecipePuppy não tinha uma lista de ingredientes (não que eu tenha encontrado), acabei fazendo uma forma "alternativa" de buscar esses ingredientes, que é a rota ```/ingredients``` da API. O código está dentro do Controller junto com a listagem de receitas. Adicionei essa lista em um arquivo .js para utilizar no projeto;
- Como a API é totalmente em inglês, resolvi fazer o front-end em inglês também, para manter a consistência;
- A API do Giphy aceita um parâmetro de rating do conteúdo. Utilizei o rating para todas as idades, mas mesmo assim ainda vem algumas coisas NSFW dependendo da receita...
- Fazer UIs bonitas não é meu forte, mas eu tentei ❤
