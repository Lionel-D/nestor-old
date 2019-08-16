<?php

// First execute cache:clear for test environment
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" cache:clear --no-warmup',
    $_ENV['BOOTSTRAP_LOCAL_TEST_ENV'],
    __DIR__
));

// Then drop existing test database
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:database:drop --force',
    $_ENV['BOOTSTRAP_LOCAL_TEST_ENV'],
    __DIR__
));

// And recreate fresh database
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:database:create',
    $_ENV['BOOTSTRAP_LOCAL_TEST_ENV'],
    __DIR__
));

// Execute migrations
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:migrations:migrate --no-interaction',
    $_ENV['BOOTSTRAP_LOCAL_TEST_ENV'],
    __DIR__
));

// And load fixtures
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:fixtures:load --no-interaction',
    $_ENV['BOOTSTRAP_LOCAL_TEST_ENV'],
    __DIR__
));

require __DIR__.'/../config/bootstrap.php';