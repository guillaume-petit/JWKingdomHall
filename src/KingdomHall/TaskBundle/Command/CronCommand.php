<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/5/15
 * Time: 11:26 AM
 */

namespace KingdomHall\TaskBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('kingdomhall:cron:run')
            ->setDescription('Run cron jobs scheduled in jwkh database');
    }

    /**
     * execute
     *
     * @param InputInterface  $input  the input
     * @param OutputInterface $output the output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()
            ->get('kingdomhall.service.cron')->runJobs();
    }
}