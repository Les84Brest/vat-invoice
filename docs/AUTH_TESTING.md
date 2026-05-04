# Инструкции для тестирования аутентификации

## Предварительные условия

Убедитесь что Docker контейнеры запущены:
```bash
# PHP контейнер
docker exec -it universal-php bash

# Node.js контейнер  
docker exec -it universal-node sh
```

## Шаги для тестирования

### 1. **Подготовка бэкенда**

В PHP контейнере:
```bash
cd ./vat-invoice

# Убедитесь что база данных настроена
php artisan migrate --fresh --seed

# Проверьте что Sanctum настроен правильно
php artisan config:show sanctum
```

### 2. **Проверка API endpoints**

```bash
# Проверьте что /api/v1/login endpoint доступен
curl -X GET http://localhost:8000/api/v1/login
# Должно вернуть 404 (GET не поддерживается)

# Проверьте что можно получить CSRF токен
curl -X GET http://localhost:8000/sanctum/csrf-cookie
```

### 3. **Подготовка фронтенда**

В Node.js контейнере:
```bash
cd ./vat-invoice

# Установите зависимости если ещё не установлены
npm install

# Запустите Vite dev сервер
npm run dev
```

### 4. **Тестирование в браузере**

1. Откройте http://localhost:5173/login
2. Введите учетные данные одного из тестовых пользователей:
   - Email: `a1@bbb.com`
   - Password: `secret`
3. Нажмите кнопку "Войти"
4. Должны увидеть успешное сообщение и перенаправление на дашборд

### 5. **Проверка localStorage**

В DevTools консоли браузера:
```javascript
// Проверьте что auth флаг установлен
localStorage.getItem('auth')  // Должен вернуть "true"

// Если нужно вывести пользователя
JSON.stringify(localStorage.getItem('auth'))
```

## Troubleshooting

### Ошибка 401 при логине
- Проверьте что база данных seeded с пользователями
- Убедитесь что пароль правильный (case-sensitive)
- Проверьте что CSRF токен получен

### Ошибка 419 (CSRF токен невалиден)
- Убедитесь что `/sanctum/csrf-cookie` endpoint доступен
- Проверьте CORS конфигурацию в `config/sanctum.php`
- Очистите cookies браузера и попробуйте снова

### Ошибка сессии (401 после логина)
- Проверьте что `auth:sanctum` middleware подключен
- Убедитесь что cookies передаются с `withCredentials: true`
- Проверьте `config/sanctum.php` stateful домены включают ваш localhost

### Компонент не загружает дашборд после логина
- Проверьте что router имеет правильное имя роута: `vat.dashboard`
- Убедитесь что `/vat` маршрут требует auth middleware

## Тестирование API напрямую

### Логин (POST)
```bash
# 1. Получите CSRF токен
COOKIE=$(curl -s -c - http://localhost:8000/sanctum/csrf-cookie | grep XSRF | awk '{print $NF}')

# 2. Логинитесь
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"a1@bbb.com","password":"secret"}' \
  -b "XSRF-TOKEN=$COOKIE" \
  -c cookieJar.txt

# 3. Это должно вернуть JSON с user данными
```

### Получение данных аутентифицированного пользователя (GET)
```bash
# Используя cookies из предыдущего логина
curl -X GET http://localhost:8000/api/v1/auth_user \
  -b cookieJar.txt
```

### Выход (POST)
```bash
curl -X POST http://localhost:8000/api/v1/logout \
  -b cookieJar.txt
```

## Логирование и Debugging

### Проверьте Laravel логи
```bash
cd ./vat-invoice
tail -f storage/logs/laravel.log
```

### Включите debug режим в `.env`
```
APP_DEBUG=true
```

### Проверьте Network tab в DevTools
- Смотрите на запрос к `/api/v1/login`
- Проверьте Response headers и cookies
- Убедитесь что есть Set-Cookie header

## Дополнительные заметки

- Sanctum использует **session-based authentication** для SPA (не API tokens)
- CSRF токен автоматически отправляется через `withXSRFToken: true` в axios
- Cookies отправляются автоматически через `withCredentials: true` в axios
- Session length контролируется в `config/session.php`
