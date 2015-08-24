<?php

namespace KingdomHall\ServiceBundle\Service;


use KingdomHall\TaskBundle\Exception\TaskException;

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
     * @throws TaskException
     */
    public function sendMail($subject, $from, $to, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        $sent = $this->mailer->send($message, $failedRecipients);
        if ($failedRecipients) {
            throw new TaskException('Failed to send message to the following recipients: ' . print_r($failedRecipients));
        }
        error_log('Message sent to ' . $sent . ' recipients');
    }
}