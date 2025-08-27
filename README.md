# API for Cars

![PHP](https://img.shields.io/badge/language-PHP-blue.svg)
![Status](https://img.shields.io/badge/status-active-brightgreen.svg)

## Описание
REST API для управления:
- **Брендами автомобилей**
- **Моделями автомобилей**
- **Автомобилями**

Проект реализован на **Laravel**, поддерживает авторизацию через **Laravel Sanctum** и включает CRUD операции для всех сущностей.

---

## Документация API (Swagger)

В проекте установлен **Swagger** через пакет [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger).

### Генерация документации

Для генерации актуальной документации выполните команду:
```
php artisan l5-swagger:generate
```

### Просмотр документации

Документация будет доступна по адресу:  
`http://localhost:8000/api/documentation`

---

## Запуск проекта

### 1. Установка зависимостей
```
composer install
```

### 2. Настройка окружения
```
cp .env.example .env
```
Укажите параметры подключения к вашей базе данных в файле **.env**.

### 3. Генерация ключа приложения
```
php artisan key:generate
```

### 4. Миграции и сиды
```
php artisan migrate --seed
```
Будут созданы таблицы и заполнены тестовыми брендами и моделями.

### 5. Запуск сервера
```
php artisan serve
```

API будет доступен по адресу:  
`http://localhost:8000/api`

---

## Структура проекта

```
app/
  Http/
    Controllers/Api/
      BrandController.php         // CRUD брендов
      CarModelController.php      // CRUD моделей
      CarController.php           // CRUD автомобилей
    Requests/
      BrandRequest.php            // Валидация бренда
      CarModelRequest.php         // Валидация модели
    Resources/
      BrandResource.php           // Ресурс бренда
      CarModelResource.php        // Ресурс модели
  Services/
    BrandService.php              // Бизнес-логика бренда
    CarModelService.php           // Бизнес-логика модели
    CarService.php                // Бизнес-логика автомобиля
  Models/
    Brand.php
    CarModel.php
    Car.php

database/
  seeders/
    BrandSeeder.php               // Сидер брендов
    CarModelSeeder.php            // Сидер моделей
    DatabaseSeeder.php
  factories/
    BrandFactory.php              // Фабрика брендов
    CarModelFactory.php           // Фабрика моделей

routes/
  api.php                         // Определение маршрутов API

composer.json
package.json
phpunit.xml
README.md
```

---

## Примеры API

### Бренды
- Получить список:  
  **GET** `/api/brands`

- Создать:  
  **POST** `/api/brands`
  ```
  { "name": "Mazda" }
  ```

- Получить бренд:  
  **GET** `/api/brands/{id}`

- Обновить:  
  **PUT** `/api/brands/{id}`
  ```
  { "name": "Mazda Updated" }
  ```

- Удалить:  
  **DELETE** `/api/brands/{id}`

### Модели
- Получить список:  
  **GET** `/api/car-models`

- Создать:  
  **POST** `/api/car-models`
  ```
  { "brand_id": 1, "name": "CX-5" }
  ```

- Получить модель:  
  **GET** `/api/car-models/{id}`

- Обновить:  
  **PUT** `/api/car-models/{id}`
  ```
  { "brand_id": 1, "name": "CX-5 Updated" }
  ```

- Удалить:  
  **DELETE** `/api/car-models/{id}`

### Автомобили (требуется авторизация)
- Получить список:
  **GET** `/api/cars`

- Создать:  
  **POST** `/api/cars`
  ```
  { 
    "brand_id": 1, 
    "car_model_id": 1, 
    "year": 2020, 
    "mileage": 15000, 
    "color": "red" 
  }
  ```

- Получить авто:  
  **GET** `/api/cars/{id}`

- Обновить:  
  **PUT** `/api/cars/{id}`
  ```
  { 
    "brand_id": 1, 
    "car_model_id": 1, 
    "year": 2021, 
    "mileage": 12000, 
    "color": "blue" 
  }
  ```

- Удалить:  
  **DELETE** `/api/cars/{id}`

---

## Авторизация
Для работы с **автомобилями** необходимо быть авторизованным пользователем.  
Используется **Laravel Sanctum**.

---

## Тестирование
Для тестирования API можно использовать:
- **Postman**
- **curl**

## Тесты

В проект добавлены unit-тесты для проверки основных функций.

---

API готов к использованию!
