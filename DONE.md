# DONE.md

## Co zostało zrobione
- Pełna aplikacja To-Do list na Laravel 11 (CRUD, walidacja, autoryzacja, migracje, Eloquent, REST API, Blade)
- Filtrowanie zadań po statusie, priorytecie, terminie
- Powiadomienia e-mail na 1 dzień przed terminem (Queue, Scheduler, Mailhog)
- Historia zmian zadań (TaskHistory)
- Udostępnianie zadań przez link z tokenem (wygasa po 7 dniach)
- Obsługa wielu użytkowników (Breeze)
- Dockerfile i docker-compose.yml (aplikacja, MySQL, Mailhog)
- Seeder, fabryka, przykładowy test Feature
- Przygotowane szablony Blade (CRUD, historia, udostępnianie, e-mail)

## Przemyślenia
- Kod jest zgodny z dobrymi praktykami Laravel (SOLID, KISS, Eloquent, walidacja, polityki, obsługa błędów).
- Integracja z Google Calendar wymaga uzupełnienia danych w .env i panelu Google Cloud (zgodnie z dokumentacją spatie laravel-google-calendar).
- System powiadomień e-mail można łatwo rozbudować o inne kanały (np. SMS, Slack).
- Docker ułatwia uruchomienie projektu na dowolnym środowisku.

(zespół-IT.pl) Grzegorz Skotniczny