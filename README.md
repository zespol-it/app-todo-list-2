# To-Do List (Laravel 11)

Aplikacja do zarządzania zadaniami z powiadomieniami e-mail, historią zmian, udostępnianiem i integracją z Google Calendar.

## Wymagania
- Docker + Docker Compose
- (lub) PHP 8.2+, Composer, Node.js, MySQL

## Szybki start (Docker)
```bash
git clone ...
cd app-todo-list-laravel/laravel-app
docker-compose up --build -d
```

1. Skopiuj plik `.env.example` do `.env` i dostosuj ustawienia (np. DB, mail, Google Calendar).
2. W kontenerze uruchom migracje i seed:
```bash
docker-compose exec app php artisan migrate --seed
```
3. Utwórz użytkownika (rejestracja przez UI lub seed).
4. Aplikacja dostępna na `localhost:9000` (np. przez nginx lub artisan serve).
5. Mailhog: [http://localhost:8025](http://localhost:8025)

## Testy
```bash
docker-compose exec app php artisan test
```

## Powiadomienia e-mail
- Powiadomienia wysyłane dzień przed terminem zadania (komenda: `php artisan tasks:send-reminders`).
- Możesz dodać do crona:
```
0 8 * * * docker-compose exec app php artisan tasks:send-reminders
```

## Integracja z Google Calendar
- Skonfiguruj bibliotekę [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar) zgodnie z dokumentacją.
- Dodaj odpowiednie dane w `.env` i panelu Google Cloud.

## Udostępnianie zadań
- Wygeneruj link do zadania, który działa przez 7 dni.

## Historia zmian
- Każda zmiana zadania jest zapisywana i widoczna w szczegółach zadania.

## Autor
- (zespół-IT.pl) Grzegorz Skotniczny