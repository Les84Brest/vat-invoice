# 🔐 Аутентификация Laravel + Vue 3 (Sanctum) – Полная реализация

Я реализовал полную логику аутентификации для вашего приложения с использованием **Laravel Sanctum** (session-based) и **Vue 3 SPA**.

## ✨ Что было реализовано

### **Бэкенд (Laravel)**

#### 1. **API Controller для аутентификации**
- 📁 **Файл**: `app/Http/Controllers/Api/V1/AuthController.php`
- ✅ Два метода: `login()` и `logout()`
- 🔐 Использует `Auth::attempt()` для валидации
- 🎯 Возвращает user через `AuthUserResource` (правильное форматирование данных)

#### 2. **Form Request для валидации**
- 📁 **Файл**: `app/Http/Requests/Auth/LoginRequest.php`
- ✅ Валидирует email (обязателен, формат) и пароль (обязателен, min 6)
- 🌐 Сообщения ошибок на русском

#### 3. **API Routes**
- 📁 **Файл**: `routes/api_v1.php`
- ✅ `POST /api/v1/login` – без middleware (доступен всем)
- ✅ `POST /api/v1/logout` – с middleware `auth:sanctum`

### **Фронтенд (Vue 3 + Pinia)**

#### 4. **LoginPage.vue компонент**
- 📁 **Файл**: `resources/js/pages/LoginPage.vue`
- ✅ Форма с полями email и password
- ✅ Валидация клиента Element Plus компонентами
- ✅ Обработка ошибок с dismissible alert
- ✅ Loading состояние при отправке
- ✅ Успешное сообщение и редирект на дашборд

#### 5. **Pinia Auth Store**
- 📁 **Файл**: `resources/js/store/auth.ts`
- ✅ Обновлены методы `loginIn()` и `logOut()`
- ✅ Используют новые API endpoints (`/api/v1/login`, `/api/v1/logout`)
- ✅ Правильная обработка Resource-wrapped данных

#### 6. **Bootstrap конфигурация**
- 📁 **Файл**: `resources/js/bootstrap.js`
- ✅ Исправлена ошибка: `err.response` → `error.response`
- ✅ Обновлены маршруты перенаправления

### **Дополнительно**

#### 📄 Документация для тестирования
- 📁 **Файл**: `AUTH_TESTING.md` (создан в корне проекта)
- 📋 Пошаговые инструкции по тестированию
- 🧪 curl примеры для API тестирования
- 🐛 Troubleshooting секция

## 🚀 Как запустить и тестировать

### **Шаг 1: Подготовка бэкенда**

```bash
# Зайти в PHP контейнер
docker exec -it universal-php bash
cd ./vat-invoice

# Миграция и seeding (БД уже готова после моих команд выше)
php artisan migrate:fresh --seed
```

### **Шаг 2: Запуск фронтенда**

```bash
# Зайти в Node.js контейнер
docker exec -it universal-node sh
cd ./vat-invoice

# Запустить Vite dev сервер
npm run dev
```

Приложение будет доступно по адресу: **http://localhost:5173**

### **Шаг 3: Тестирование**

#### 📍 Перейти на страницу логина:
`http://localhost:5173/login`

#### 👤 Учетные данные тестовых пользователей:

| Email | Password | Name |
|-------|----------|------|
| a1@bbb.com | secret | Гордей Давыдов |
| a2@bbb.com | secret | Руслан Махов |
| a3@bbb.com | secret | Инесса Благово |
| a4@bbb.com | secret | Братислава Дондукова |

#### ✅ Ожидаемый результат:
1. Вводите email и пароль
2. Нажимаете "Войти"
3. Видите успешное сообщение "Успешный вход"
4. Автоматически перенаправляется на `/vat` дашборд

## 🔄 Authentication Flow

```
┌─────────────────┐
│  LoginPage.vue  │  User enters credentials
└────────┬────────┘
         │
         ├─► 1. Fetch CSRF token: GET /sanctum/csrf-cookie
         │
         ├─► 2. POST /api/v1/login { email, password }
         │
         ├─► 3. Laravel Auth::attempt() validates
         │
         ├─► 4. Returns: { user: AuthUserResource, message: "..." }
         │
         ├─► 5. Store updates localStorage["auth"] = "true"
         │
         ├─► 6. Store updates Pinia state
         │
         └─► 7. Router guard allows access to protected routes
                  Redirect to /vat
```

## 🔒 Как это работает (Sanctum + Session)

- **CSRF Protection**: Token получается через `/sanctum/csrf-cookie` и отправляется с каждым запросом
- **Session-based**: Используются HTTP-only cookies для хранения session ID
- **Stateful домены**: Localhost:5173 уже в конфигурации (`config/sanctum.php`)
- **Middleware**: Используется `auth:sanctum` для защиты routes

## 📁 Созданные файлы

```
✅ app/Http/Controllers/Api/V1/AuthController.php      (новый)
✅ app/Http/Requests/Auth/LoginRequest.php             (новый)
✅ resources/js/pages/LoginPage.vue                     (обновлен)
✅ resources/js/store/auth.ts                           (обновлен)
✅ resources/js/bootstrap.js                            (исправлен)
✅ routes/api_v1.php                                    (обновлен)
✅ AUTH_TESTING.md                                      (новый)
```

## 🧪 Тестирование с curl (опционально)

```bash
# 1. Получить CSRF токен
curl -i GET http://localhost:8000/sanctum/csrf-cookie

# 2. Логинитесь (замените cookie значения)
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "X-XSRF-TOKEN: your-token" \
  -d '{"email":"a1@bbb.com","password":"secret"}' \
  -b "XSRF-TOKEN=your-token" \
  -c cookies.txt

# 3. Проверить аутентификацию
curl http://localhost:8000/api/v1/auth_user -b cookies.txt

# 4. Выйти
curl -X POST http://localhost:8000/api/v1/logout -b cookies.txt
```

## ⚙️ Конфигурация Sanctum

Уже настроена в `config/sanctum.php`:
- ✅ Stateful домены включают `localhost:5173`
- ✅ Guard установлен на `web` (для session-based auth)
- ✅ CSRF protection включена

## 🐛 Частые проблемы и решения

| Проблема | Решение |
|----------|---------|
| 401 Unauthorized при логине | Проверьте правильность email/password, БД содержит пользователей |
| 419 Token mismatch | Убедитесь что `/sanctum/csrf-cookie` вызывается перед логином |
| Cookies не отправляются | Проверьте `withCredentials: true` в axios (уже настроено) |
| 404 на `/api/v1/login` | Убедитесь что route в `api_v1.php` добавлен правильно |

## 📚 Дополнительные ресурсы

- **Auth Testing Guide**: `AUTH_TESTING.md` (в корне проекта)
- **Laravel Sanctum**: https://laravel.com/docs/11.x/sanctum
- **Element Plus Form**: https://element-plus.org/en-US/component/form.html

## ✅ Готово!

Полная аутентификация на Laravel Sanctum + Vue 3 реализована и готова к использованию! 🎉

Если возникнут проблемы при тестировании, проверьте logs:
```bash
docker exec -it universal-php bash
cd ./vat-invoice
tail -f storage/logs/laravel.log
```
