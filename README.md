# Desafio treinamento de funcionarios

## Requisitos:
- PHP 7.1+ 
- MySQL: 5.7 
- Composer 
- Symfony

## Iniciar projeto:

```
composer install --ignore-platform-reqs
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force

symfony server:start
```
