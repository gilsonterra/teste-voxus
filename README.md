# Localização do Usuário

## Requisitos

Precisamos criar uma API REST que colete dados de localização de milhões de usuários e
consiga retornar para o usuário a posição dele.

- A API receberá latitude e longitude e salvará dados sobre um user_id.
- Quando consultado no método POST, a API deverá armazenar dados da localização do
usuário (banco de dados de sua preferência, inclusive, podendo usar cache ou arquivos
locais).
- É necessário criar um endpoint da API que retornará dados da localização do usuário requisitado.

## Instalação

- Primeiramente excute o composer:

```shell
composer install
```
