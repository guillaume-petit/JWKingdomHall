#!/usr/bin/env php
<?php
// CronRun.php

require __DIR__.'/../../../../vendor/autoload.php';
require_once __DIR__.'/../../../../app/AppKernel.php';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->add(new \KingdomHall\TaskBundle\Command\CronCommand());
$input = new \Symfony\Component\Console\Input\StringInput('k:c:r');
$application->run($input);
