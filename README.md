# Configuration

преопределение штатного класса сущности

    feedback:
        db_driver: orm модель данных
        factory: App\Feedback\Factory\FeedbackFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Feedback\Entity\Feedback сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto_class: App\Feedback\Dto\FeedbackDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд соц сетей 
          query - декоратор mediator запросов соц сетей
        services:
          pre_validator - переопределение сервиса валидатора соц сетей
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

    1. API_GET_FEEDBACK, API_CRITERIA_FEEDBACK - получение соц сети
    2. API_POST_FEEDBACK - создание соц сети
    3. API_PUT_FEEDBACK -  редактирование соц сети

# Статусы:

    создание:
        описание создано HTTP_CREATED 201
    обновление:
        описание обновлено HTTP_OK 200
    удаление:
        описание удалено HTTP_ACCEPTED 202
    получение:
        описание(я) найдены HTTP_OK 200
    ошибки:
        если описание не найдено FeedbackNotFoundException возвращает HTTP_NOT_FOUND 404
        если описание не уникально UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если описание не прошло валидацию FeedbackInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если описание не может быть сохранено FeedbackCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
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

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
   