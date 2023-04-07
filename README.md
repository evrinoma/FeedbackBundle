# Installation

Добавить в kernel

    Evrinoma\FeedbackBundle\EvrinomaFeedbackBundle::class => ['all' => true],

Добавить в routes

    feedback:
        resource: "@EvrinomaFeedbackBundle/Resources/config/routes.yml"

Добавить в composer

    composer config repositories.dto vcs https://github.com/evrinoma/DtoBundle.git
    composer config repositories.dto-common vcs https://github.com/evrinoma/DtoCommonBundle.git
    composer config repositories.utils vcs https://github.com/evrinoma/UtilsBundle.git

# Configuration

преопределение штатного класса сущности

    feedback:
        db_driver: orm модель данных
        factory: App\Feedback\Factory\Feedback\Factory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Feedback\Entity\Feedback сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto: App\Feedback\Dto\FeedbackDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд обратной связи 
          query - декоратор mediator запросов обратной связи
        services:
          pre_validator - переопределение сервиса валидатора обратной связи
          handler - переопределение сервиса обработчика сущностей
          file_system - переопределение сервиса сохранения файла

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_FEEDBACK, API_CRITERIA_FEEDBACK - получение обратной связи
    2. API_POST_FEEDBACK - создание обратной связи
    3. API_PUT_FEEDBACK -  редактирование обратной связи

# Статусы:

    создание:
        обратная связь создана HTTP_CREATED 201
    обновление:
        обратная связь обновлена HTTP_OK 200
    удаление:
        обратная связь удалена HTTP_ACCEPTED 202
    получение:
        обратная связь(и) найдены HTTP_OK 200
    ошибки:
        если обратная связь не найдена FeedbackNotFoundException возвращает HTTP_NOT_FOUND 404
        если обратная связь не уникальна UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если обратная связь не прошла валидацию FeedbackInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если обратная связь не может быть сохранена FeedbackCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности feedback нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.feedback.constraint.property

    evrinoma.feedback.constraint.property.custom:
        class: App\Feedback\Constraint\Property\Custom
        tags: [ 'evrinoma.feedback.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    COMPOSER_NO_DEV=0 composer install

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
   