# Установка через `composer`
При установке соглашаемся со всем что предлагается.<br>
[Документация](https://dev.1c-bitrix.ru/rest_help/) по использованию `bitrix24 rest api`
```
composer create-project aleks-bar/bitrix24-api директория
```
> [!WARNING]
> Обязательно нужно либо указать название директории после `aleks-bar/bitrix24-api` либо создать её заранее и установить из нёё. <br>
> Установка должна происходить в директорию которая расположена на одном уровне с основным composer.json

# Инициализация

Для инициализации берем данные из сгенерированного ура в битриксе `https://BX24_API_SUBDOMAIN.bitrix24.ru/rest/BX24_USER_ID/BX24_URL_HASH`
```
$bitrix24 = Bitrix24Api::getInstance();
$bitrix24->setUser(BX24_USER_ID);
$bitrix24->setSubdomain(BX24_API_SUBDOMAIN);
$bitrix24->setHash(BX24_URL_HASH);
```

# Отправка

Пример добавления лида
```
$lead = new Bitrix24Lead();
$lead->setTitle($title);
$lead->setName($name);
$lead->setLastName($last_name);
$lead->addPhone()->mobile($phone_1);
$lead->addPhone()->work($phone_2);
$lead->addEmail()->home($email_1);
$lead->addEmail()->mailing($email_2);

$bitrix24->addLead($lead->getData())
```

# Дополнительно
На данном этапе частично реализовано добавление лидов в CRM. В будущем возможно расширение класса
