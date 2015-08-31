#!/usr/bin/env php
<?php
// CronRun.php

require '../../../../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \KingdomHall\TaskBundle\Command\CronCommand());
$application->run();
