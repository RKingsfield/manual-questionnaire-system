<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

// executes the "php bin/console cache:clear" command
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" cache:clear --no-warmup',
        $_ENV['APP_ENV'],
        __DIR__
    )
);

// Drop the existing test DB - executes the "php bin/console doctrine:database:drop" command
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:database:drop --force --if-exists --no-interaction',
        $_ENV['APP_ENV'],
        __DIR__
    )
);

// Create a new test DB - executes the "php bin/console doctrine:database:create" command
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:database:create --no-interaction',
        $_ENV['APP_ENV'],
        __DIR__
    )
);

// Loads the schema - executes the "php bin/console doctrine:schema:create" command
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:schema:create --no-interaction',
        $_ENV['APP_ENV'],
        __DIR__
    )
);

// Loads the DB with fixtures - executes the "php bin/console doctrine:fixtures:load" command
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:fixtures:load --no-interaction',
        $_ENV['APP_ENV'],
        __DIR__
    )
);