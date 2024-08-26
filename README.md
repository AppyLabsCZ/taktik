## O aplikaci

Aplikace je vypracováním testovacího úkolu pro programátora. Aplikace splňuje následující požadavky.

- Vytvoření modelů a vztahu mezi nimi. 
- Plnou podporu CRUD operací (GET, POST, PUT, DELETE) přes API. 
- Výstup dat ve formátu JSON. 
- Implementaci cachování. 
- Ochranu před přetížením (rate limiting). 
- Dokumentace API v [apiary.io](https://app.apiary.io/taktik). 
- Základní testy ověřující funkčnost.

## Požadavky

Aplikace byla otestována v Linuxovém prostředí, konkrétně ve verzi Debian 12 s verzí PHP 8.3. Dále budete potřebovat přístup k SSH.

Za účelem psaní této dokumentace budu pracovat s doménou https://taktik.appylabs.cz kde je i nasazená tato aplikace.

1. přesuneme se do složky, kam chceme naší aplikaci nainstalovat, v našem případě to bude: 
```sh
cd /www/hosting/appylabs.cz/taktik
```
2. naklonujeme projekt 
```sh
git clone git@github.com:AppyLabsCZ/taktik.git
```
a následně je potřeba doinstalovat veškeré další requirments, to můžeme udělat pomocí příkazu
```sh
composer update
```

3. vytvoří se nám další podsložka taktik, přesuneme se do ní
```sh
cd taktik
```

4. je potřeba nakonfigurovat náš .env soubor, k tomu můžeme využít .env.example, stačí odstranit .example. Heslo k databázi jsem vám zaslal v emailu, ale můžete si samozřejmně nastavit svou vlastní DB. Nezapomeňte si v produkčním prostředí nastavit APP_DEBUG na hodnotu false a vygenerovat nový klíč aplikace (APP_KEY) pomocí příkazu:
```sh
php artisan key:generate
```

5. spustíme migraci tabulek pomocí příkazu:
```sh
php artisan migrate
```

6. naplníme tabulku daty, pro tento účel jsem vytvořil seedery, které naplní tabulku náhodnými daty. Použijeme příkaz:
```sh
php artisan db:seed
```

7. vytvořil jsem custom command pro vytvoření uživatele včetně personal Bearer Tokenu, který je potřeba pro práci s API. Můžete použít příkaz:
```sh
php artisan app:create-api-user
```

8. předtím, než začneme pracovat s aplikací, je potřeba vykonat posledních pár příkazů, které zajistí správné fungování aplikace, bez těchto kroků vám pravděpodobně bude aplikace vyhazovat Internal 500 error
```sh
chown -R www-data:www-data /www/hosting/appylabs.cz/taktik/taktik
find /www/hosting/appylabs.cz/taktik/taktik -type d -exec chmod 755 {} \;
find /www/hosting/appylabs.cz/taktik/taktik -type f -exec chmod 644 {} \;
chmod -R 775 /www/hosting/appylabs.cz/taktik/taktik/storage
chmod -R 775 /www/hosting/appylabs.cz/taktik/taktik/bootstrap/cache
```

JE HODNĚ DŮLEŽITÉ, ABYSTE ZADÁVALI ABSOLUTNÍ CESTU U NASTAVOVÁNÍ PRÁV, V OPAČNÉM PŘÍPADĚ SI MŮŽETE ROZBÍT SERVER A PŘIPRAVIT SE NA REINSTALL, nestačí pouze být v požadované složce (vlastní zkušenost)

9. vytvořil jsem jeden PHP Unit test, spustit ho můžete příkazem: 
```sh
php artisan test --filter BookTest
```
