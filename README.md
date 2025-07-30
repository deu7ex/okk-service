Laravel-сервис для имитации постановки задач на распознавание аудио, их асинхронной обработки, проверки статусов и логирования результатов.

---

## 🚀 Возможности
- Авторизация по токену (Laravel Sanctum)
- Создание задач на распознавание аудио
- Имитация транскрибации и диаризации
- Асинхронная очередь обработки (RabbitMQ)
- Планировщик проверки статусов (Laravel Scheduler)
- Фейковый сервис проверки статуса
- REST API с JSON-ответами

---

## ⚙️ Установка

- [Установить Docker][docker-install]
- Клонировать репозиторий:
```bash
git clone git@github.com:deu7ex/okk-service.git
```
- Скопировать .env в корне проекта и папке docker:
```bash
cp .env.example .env
```
- Сгенерировать ключ приложения:
```
php artisan key:generate
```
- Запустить Docker из корня проекта:
```bash
./docker-run.sh
```
- (опицонально) Если необходимо остановить Docker:
```bash
./docker-run.sh down
```
- Выполнить миграции и сиды из корня проекта:
```
docker exec okk-app php artisan migrate --seed
```
- Получить данные пользователя, чтобы использовать их для аутентификации:
```
docker exec -it okk-app /bin/sh -c "php artisan tinker --execute='dump(DB::table(\"users\")->first());'"
```

---

## 📡 API эндпоинты

### 🔐 Аутентификация
```
POST /api/login
{
  "email": "test@example.com",
  "password": "password"
}
```
####Ответ:
```
{
  "token": "Bearer <ваш_токен>",
  "user": {
    "id": 2,
    "name": "Ariel Treutel",
    "email": "test@example.com",
    ...
  }
}
```

### 📥 Создать задачу

```
POST /api/tasks
Accept: application/json
Authorization: Bearer <token>
{
  "audio_url": "https://example.com/audio.mp3",
  "parameters": { "lang": "ru" },
  "metadata": { "user_id": 123 }
}
```
####Ответ
```
{
  "message": "Task created",
  "data": {
    "audio_url": "https://example.com/audio.mp3",
    "status": 1,
    "status_label": "new"
    ...
  }
}
```

##🪄 Фейковая логика
- Сервис имитирует распознавание (с задержкой)
- Очереди управляются через RabbitMQ 
- Проверка статуса запускается каждые 5 минут через планировщик 
- В случае ошибки лог сохраняется в таблицу logs

##🛠️ Структура Docker
- app — Laravel-приложение 
- consumer — консумер очередей 
- scheduler — Laravel Scheduler 
- rabbitmq — брокер очередей

## ✅ Примеры
 - `GET /api/tasks` — список задач 
 - `GET /api/tasks/{id}` — подробности по задаче 
 - `GET /api/segments` — список информации по аудио файлам
 - `GET /api/segments/{id}` — подробности по аудио файлу
 - `GET /api/evaluations` — список оценок
 - `GET /api/evaluations/{id}` — подробности по оценке
 - `GET /api/logs` — логи ошибок
 - `GET /api/logs/{id}` — подробности по ошибоке

## 👨‍💻 Технологии
- PHP 8.2 
- Laravel 10+ 
- RabbitMQ 
- Docker 
- Sanctum 
- Faker

[docker-install]: https://docs.docker.com/install/#supported-platforms
