<?php
echo "preparing for heroku deployment";
echo "Resetting prod database...";
passthru('php bin/console doctrine:schema:drop --env=prod --force --no-interaction');
passthru('php bin/console doctrine:schema:update --env=prod --force --no-interaction');
passthru('php bin/console cache:clear --env=prod --no-debug');