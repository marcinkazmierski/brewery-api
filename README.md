# brewery-api

## Komendy [Symfony]

- `php bin/console doctrine:generate:entity` - dodatnie nowej encji
- `php bin/console doctrine:schema:update --force` - aktualizacja bazy
- `php bin/console doctrine:fixtures:load` - wczytanie danych do bazy (nadpisuje wszystkie dane)
- `php bin/console doctrine:fixtures:load --append` - wczytanie danych do bazy (dodaje do istniejacych)
- `php bin/console debug:router` - wyświetla wszystkie ścieżki w aplikacji.
- `php bin/console cache:clear` - czyszczenie cache
- `php bin/console cache:pool:clear cache.app` - czyszczenie cache dla cache.app pool
- `symfony console debug:autowiring NAZWA` - wyświetla wszystkie kontenety do DI z NAZWA

## Komendy [custom]
- `php bin/console users:create EMAIL NICK PASSWORD` - Create new user in database.
- `php bin/console code:generator:usecase MyUseCase` - generowanie nowego use case w strukturze Domain/Infrastructure

## TODO: symfony 5 (https://symfony.com/doc/current/the-fast-track/pl/index.html)
- php: 8.0
- symfony CLI
- Uruchomienie lokalnego serwera WWW > 'symfony server:start -d' > 'symfony open:local'
- profiler: 'symfony composer req profiler --dev'
- logger: 'symfony composer req logger'
- narzędzie developerskie 'symfony composer req debug --dev'
- logi w cli: 'symfony server:log'
- instalacja zdebuga z phpstormem, w php.ini coś typu: "xdebug.file_link_format=vscode://file/%f:%l"
- Maker Bundle > 'symfony composer req maker --dev' > 'symfony console list make'
- generowanie controllera: 'symfony console make:controller ConferenceController'
- tworzenie encji 'symfony console make:entity Conference'
- migracje: 'symfony console make:migration' > Aktualizacja bazy danych, wgranie migracji: 'symfony console doctrine:migrations:migrate'
- panel admina: 'symfony composer req "admin:^3"' 
- generowanie CRUD dla wszystkich encji dla panelu: 'symfony console make:admin:crud'
- do zarządzania stringami: https://packagist.org/packages/symfony/string
- API: 'symfony composer req api' (https://api-platform.com/docs/distribution/)

## Ficzery do zrobienia:
- kolekkowanie asynchroniczne maili
