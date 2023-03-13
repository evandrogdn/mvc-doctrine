## CRUD MVC Doctrine

### Como rodar o projeto?

#### Composer
Inicialmente é necessário realizar a instalação dos pacotes, usando o gerenciador de pacotes PHP, composer. Para instalar o mesmo, basta seguir o que é fornecido [aqui](https://getcomposer.org/download/).

Com o mesmo instalado, basta executar o seguinte comando:

```composer install --no-dev --ignore-platform-reqs -o -n```

As dependencias dos pacotes não precisam ser instaladas na maquina do desenvolvedor, pois o projeto é executado utilizando containers docker. Todos os pacotes complementares, já estarão incluidos dentro da imagem Docker.

#### Docker e docker-compose
Imagens Docker, servem para tornar a maquina do desenvolvedor igual ao servidor de produção.
Docker é utilizado para virtualizar aplicações e fazer com que cada container que é executado, rode com seu proprio conjunto de dependências.

A instalação do Docker, pode ser realizada seguindo os passos disponibilizados [aqui](https://docs.docker.com/engine/install/)

Já o docker-compose é uma ferramenta utilizada para fazer o gerenciamento desses containeres, fazendo a configuração que é necessária para que o mesmo execute. O processo de instalação do mesmo está disponível [aqui](https://docs.docker.com/compose/install/)

#### Subindo a aplicação
Para iniciar a aplicação, basta executar o seguinte comando:

```docker-compose up```

Na sequência, basta configurar uma conexão com o banco de dados, e executar os comandos disponibilizados [aqui](migrations/database.sql)

Agora a aplicação está pronta para uso! Basta operar a mesma.