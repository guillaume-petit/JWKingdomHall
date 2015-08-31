<?php

namespace KingdomHall\ServiceBundle\Tasks;

use Doctrine\ORM\EntityManager;
use KingdomHall\DataBundle\Entity\Territory;
use KingdomHall\ServiceBundle\Service\MailService;
use KingdomHall\TaskBundle\Exception\TaskException;
use KingdomHall\TaskBundle\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class NotifyTerritoryTask extends TaskService
{
    /** @var MailService $mailer */
    protected $mailer;

    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var Translator $translator */
    protected $translator;

    public function __construct(EntityManager $entityManager, MailService $mailer, Translator $translator)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->translator = $translator;
    }
    /**
     * process a task
     *
     * @param integer $jobId the id of the job being processed
     * @param array $parameters an array of parameters
     *
     * @throws TaskException
     * @return void
     */
    public function process($jobId, $parameters = array())
    {
        $territories = $this->entityManager->getRepository('KingdomHallDataBundle:Territory')->findAll();

        $tNotifs = array_filter(
            $territories,
            function (Territory $territory) {
                return $territory->getStatus() == Territory::TERRITORY_STATUS_WARNING ||
                    $territory->getStatus() == Territory::TERRITORY_STATUS_ALERT;
            }
        );

        /** @var Territory $territory */
        foreach ($tNotifs as $territory) {
            if ($territory->getPublisher()->getEmail() && $territory->getNotified() != $territory->getStatus()) {

                $settings = $territory->getCongregation()->getSettings();
                $alertDate = clone $territory->getBorrowDate();
                $alertDate->add(\DateInterval::createFromDateString('+'.$settings->get('territory_max_borrow_time')->getValue()));

                $this->mailer->sendMail(
                    $this->translator->trans(
                        'jwkh.territories.email.'.$territory->getStatus().'.subject',
                        array (
                            '%number%'    => $territory->getNumber() . ' - ' . $territory->getName(),
                        ),
                        null,
                        $territory->getCongregation()->getDefaultLocale()
                    ),
                    'territory@jwkh.com',
                    $territory->getPublisher()->getEmail(),
                    $this->translator->trans(
                        'jwkh.territories.email.'.$territory->getStatus().'.body',
                        array (
                            '%firstName%' => $territory->getPublisher()->getFirstName(),
                            '%number%'    => $territory->getNumber() . ' - ' . $territory->getName(),
                            '%date%'      => $alertDate->format($settings->get('date_format_twig')->getValue()),
                        ),
                        null,
                        $territory->getCongregation()->getDefaultLocale()
                    )
                );

                $territory->setNotified($territory->getStatus());
                $this->entityManager->persist($territory);
                $this->entityManager->flush();
            }
        }
    }

    /**
     * get service task name
     *
     * @return string
     */
    public function getName()
    {
        return 'task.notify_territory';
    }
}