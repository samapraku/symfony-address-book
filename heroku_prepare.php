<?php
echo "preparing for heroku deployment";
echo "Resetting prod database...";
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:schema:drop --env=prod --force --no-interaction',
        __DIR__
    ));
passthru(sprintf(
    'php "%s/../bin/console" doctrine:schema:update --env=prod --force --no-interaction',
    __DIR__
));