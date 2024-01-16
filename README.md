Este projeto foi feito utilizando docker-composer, Laravel, Mysql, algumas libs react, como React-select, Swal2, para economia de tempo fiz utilizando o Laravel-Breeze que já dá um interface robusta de cadastro, login e senha prontas, poupando tempo na criação do projeto e focando melhor no projeto em si

Para instala-lo é necessario ao menos ter o docker desktop instalado no meu caso que utilizo windows, uso o WSL 2 para utiliza-lo

O passo a passo é simples após ter o docker funcionando corretamente basta

1 - abrir o terminal na pasta raiz do projeto
2 - utilizar o comando "composer install", para fazer o download das dependencias do projeto
3 - utilizar o comando "docker compose up -d" para subir o container
4 - utilizar o comando "docker-compose exec app bash" para acessar o terminal do container caso não consiga talvez seja porque seu container está com outro nome ao invés de app, neste caso dê o docker ps e acesse diretamente pelo id do container
5 - Terminal do container acessado dar o comando "php artisan migrate" para criar as tabelas do banco de dados
6- dê o exit para sair do terminal do docker
6 - npm install
7 - Popular a tabela de participantes, abra mysql em seu workbench, no caso eu utilizo o heidisql e rode o comando

INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time A', '2024-01-15 22:48:37', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time B', '2024-01-15 22:48:38', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time C', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time D', '2024-01-15 22:48:38', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time E', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time F', '2024-01-15 22:48:40', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time G', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time H', '2024-01-15 22:48:40', NULL, NULL);

8 - npm run build


O projeto pode ser acessado na rota http://localhost:8989/

Normalmente com mais tempo e já sabendo das regras de negocio, eu faria bem melhor, utilizaria melhor os padrões REST para fazer as buscas, apenas um metodo está com muita resposabilidade, encapsularia melhor algumas funções auxiliares, entretanto o projeto está entregue utilizando um ambiente docker, espero que gostem e obrigado pela oportunidade, curtam os gifs
