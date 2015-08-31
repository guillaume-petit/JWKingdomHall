#!/usr/bin/env php
<?php
// NotifyTerritoryRun.php

require '../../../../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \KingdomHall\ServiceBundle\Command\NotifyTerritoryCommand());
$application->run();
