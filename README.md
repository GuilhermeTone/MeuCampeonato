Este projeto foi feito utilizando docker-composer, Laravel, Mysql, algumas libs react, como React-select, Swal

Para instala-lo é necessario ao menos ter o docker desktop instalado no meu caso que utilizo windows, uso o WSL 2 para utiliza-lo

O passo a passo é simples após ter o docker funcionando corretamente basta

1 - abrir o terminal na pasta raiz do projeto
2 - utilizar o comando "composer install", para fazer o download das dependencias do projeto
3 - utilizar o comando "docker compose up -d" para subir o container
4 - utilizar o comando "docker-compose exec app bash" para acessar o terminal do container
5 - Terminal do container acessado dar o comando "php artisan migrate" para criar as tabelas do banco de dados
6 - Popular a tabela de participantes, abra mysql em seu workbench, no caso eu utilizo o heidisql e rode o comando

INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time A', '2024-01-15 22:48:37', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time B', '2024-01-15 22:48:38', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time C', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time D', '2024-01-15 22:48:38', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time E', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time F', '2024-01-15 22:48:40', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time G', '2024-01-15 22:48:39', NULL, NULL);
INSERT INTO `participantes` (`name`, `created_at`, `updated_at`, `deleted_at`) VALUES ('Time H', '2024-01-15 22:48:40', NULL, NULL);


O projeto pode ser acessado na rota http://localhost:8989/


Para carregar os produtos eu utilizo um ajax para uma rota, que acessa o banco de dados e traz os dados que eu preciso, normalmente eu não faço dessa forma, eu prefiro trazer os produtos direto para view na rota que a rota é acessada, o front-end é simples, você seleciona um produto que pode ser pesquisado por nome ou referencia utilizando numeros, o cep consulta a API passada no readme do teste, ele consulta na hora que é inserido o ultimo digito do CEP, ele faz uma validação no back-end utilizando a Classe validade do Laravel que ajuda bastante para validações, e mostra na tela os campos inválidos, venda cadastrada, irá fazer uma busca no banco trazendo assim o json de dados, e renderizando em um dataTable, uma biblioteca que gosto bastante de utilizar para trabalhar com tabelas e que já inclui um filtro geral
