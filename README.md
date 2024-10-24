# brewery-api

## Komendy [Symfony 6.0]

- `php bin/console doctrine:generate:entity` - dodatnie nowej encji
- `php bin/console doctrine:schema:update --force` - aktualizacja bazy
- `php bin/console doctrine:fixtures:load` - wczytanie danych do bazy (nadpisuje wszystkie dane)
- `php bin/console doctrine:fixtures:load --append` - wczytanie danych do bazy (dodaje do istniejacych)
- `php bin/console debug:router` - wyświetla wszystkie ścieżki w aplikacji.
- `php bin/console cache:clear` - czyszczenie cache
- `php bin/console cache:pool:clear cache.app` - czyszczenie cache dla cache.app pool
- `symfony console debug:autowiring NAZWA` - wyświetla wszystkie kontenety do DI z NAZWA
- `php bin/console make:controller` - stwórz automatycznie kontroler
- `php bin/phpunit` - run phpunit tests

### New symfony security

- https://symfony.com/doc/current/security/custom_authenticator.html
- /admin
- w pierwszej kolejności należy utworzyć usera z rolą: ROLE_ADMIN
- na stronie /login zalogować się jako admin

### Easy Admin

- https://symfony.com/doc/current/the-fast-track/pl/9-backend.html

### Sentry.io

Integracja z Sentry https://docs.sentry.io/platforms/php/guides/symfony/

## Komendy [custom]

- `php bin/console users:create EMAIL NICK PASSWORD` - Create new user in database.
- `php bin/console users:create EMAIL NICK PASSWORD --admin` - Create new admin in database.
- `php bin/console code:generator:usecase MyUseCase` - generowanie nowego use case w strukturze Domain/Infrastructure
- `php bin/console beer:collect BEER_CODE USER_EMAIL`
- `php bin/console beer:create`
- `php bin/console users:push-notifications --all "Tytuł" "Body wiadomości"` - wysyłka push do wszystkich userów
- `php bin/console users:push-notifications "Mamy nowe piwko!" "Na amerykańskim chmielu cascade" nickname` - wysyłka
  push tylko do usera o nicku "nickname"

## TODO: symfony 6 (https://symfony.com/doc/current/the-fast-track/pl/index.html)

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
- migracje: 'symfony console make:migration' > Aktualizacja bazy danych, wgranie migracji: 'symfony console doctrine:
  migrations:migrate'
- generowanie CRUD dla wszystkich encji dla panelu: 'symfony console make:admin:crud'
- do zarządzania stringami: https://packagist.org/packages/symfony/string
- API: 'symfony composer req api' (https://api-platform.com/docs/distribution/)

## Ficzery do zrobienia:

- kolejkowanie asynchroniczne emaili

## PHPStan

- https://www.drupal.org/docs/develop/development-tools/phpstan/getting-started
- `php vendor/bin/phpstan.phar`

## Testy (codeception)

- `vendor/bin/phpunit` - uruchomienie unit testów
- `vendor/bin/phpunit --coverage-html var/cache/coverage` - generuje raport pokrycia kodu testami [todo]
- `vendor/bin/codecept run` - uruchomienie testów codeception: integracyjne/akceptacyjne
- `vendor/bin/codecept g:cest api User` - dodanie nowego pustego testu akceptacyjnego o nazwie UserCest

# Update Symfony to 7.1, todo:

- swagger: https://github.com/zircote/swagger-php
- JWT: https://packagist.org/packages/lexik/jwt-authentication-bundle
- DDD: https://github.com/ddd-by-examples/library-php
- codeception for tests