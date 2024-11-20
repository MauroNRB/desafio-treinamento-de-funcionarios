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

Ao rodar o comando, irá aparecer no console a seguinte informação:

```                                                                                      
 [OK] Web server listening                                                                                              
      The Web server is using PHP CGI 7.1.33                                                                            
      http://127.0.0.1:8000       
```

Simbolizado que está operacional, dependendo das portas disponiveis, poderá estar diferente a porta para acessar a aplicação, todavia no geral é URL é: http://127.0.0.1:8000
