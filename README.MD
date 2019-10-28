Тестовый CRUD "Гостевая книга"

Реализован с помощью Symfony 4, SQLite, Doctrine 2

Для начала работы необходимо будет установить php 7.2 c дополнениями,Composer.

После клонирования репозитория, внутри корневой директории необходимо выполнить:
$ composer:install

Затем запустить сервер :
$ php bin/console server:start

В файле ./test_database/guetbook.db уже имеются данные, но можно пойти по сценарию:
$ php bin/console doctrine:database:drop --force
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load

Старые данные сотрутся, загрузятся два юзера из фикстур:
admin: 12341234 - {ROLE_ADMIN,ROLE_USER}
kek: 1234       - {ROLE_USER}

В работе присутствует секьюрити компонент, работа с формами, твиг расширениями, репозиториями,
и многим другим. В запросах присутствуют и джоины, и группбаи, и селекты, и каунты, и многое другое,
пагинация делалась вручную вместо КНП проекта, часть задания реализовать не удалось из-за
жуткого графика.
