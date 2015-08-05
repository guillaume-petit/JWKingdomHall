<?php

namespace KingdomHall\ServiceBundle\Service;


class MailService
{

    /** @var \Swift_Mailer $mailer */
    protected $mailer;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $body
     */
    public function sendMail($subject, $from, $to, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        $this->mailer->send($message);
    }
}