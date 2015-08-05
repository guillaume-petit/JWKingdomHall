<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/5/15
 * Time: 11:46 AM
 */

namespace KingdomHall\ServiceBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyTerritoryCommand extends ContainerAwareCommand
{
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this->setName('kingdomhall:territory:notify')
            ->setDescription('Notify publishers about the status of their territories.');
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('kingdomhall.service.cron')->addJob('task.notify_territory');
    }
}