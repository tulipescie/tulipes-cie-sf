<?php

namespace AppBundle\Utils;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use AppBundle\Entity\Contact;

class Mailer
{
    protected $mailer;
    protected $router;
    protected $templating;
    protected $translator;
    protected $adminsEmails = [];
    protected $onTestHtml = false;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->mailer           = $mailer;
        $this->router           = $router;
        $this->templating       = $templating;
        $this->translator       = $translator;
    }

    public function setOnTestHtml($onTestHtml)
    {
        $this->onTestHtml = !!$onTestHtml;
    }

    public function setAdminEmails($adminEmails)
    {
        if (is_string($adminEmails)) {
            $adminEmails = explode(',', $adminEmails);
        }

        if (!is_array($adminEmails)) {
            throw new \InvalidArgumentException("adminEmails should be type array or type string separated with commas");
        }

        array_walk($adminEmails, 'trim');

        $this->adminEmails = array_filter($adminEmails, function($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        });
    }

    /**
     * Not Used ??
     */
    public function sendProContactEmail(Contact $contact)
    {
        $template = 'Email/contact_pro.email.twig';

        $rendered = $this->templating->render($template, array(
            'contact'
        ));

        $subject = $this->translator->trans('email.contact_pro.subject');
        return $this->sendMessage($rendered, $subject, 'noreply@tulipes-cie.com', $contact->getEmail());
    }

    /**
     * Sent after a contact form submition
     */
    public function sendContactEmail(Contact $contact)
    {
        $template = 'Email/contact.email.html.twig';

        $subject = "Demande " . $contact->getObject();

        $uri = $this->router->generate('admin_app_contact_show', ['id' => $contact->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render($template, array(
            'title' => $subject,
            'contact' => $contact,
            'bo_uri' => $uri,
        ));

        $toEmails = [
            'charles.drouin@tulipes-cie.com',
            'laure.cousin@tulipes-cie.com',
            'camille@tulipes-cie.com',
        ];

        $message = $this->preparMessage($rendered, $subject, 'noreply@tulipes-cie.com', $toEmails);

        if (null !== $contact->getFile()) {
            $attachment = \Swift_Attachment::fromPath($contact->getFile()->getRealPath());
            $attachment->setFilename($contact->getFileOriginalName());

            $message->attach($attachment);
        }
        return $this->_sendMessage($message);
    }

    /**
     * Sending email
     *
     * @param string $renderedTemplate email content
     * @param string $subject email subject
     * @param string $fromEmail from whom
     * @param string $toEmail email whom is sending
     * @param \Swift_Message $message the message to be sent
     *
     * @return null
     */
    protected function sendMessage($renderedTemplate, $subject, $fromEmail, $toEmails, \Swift_Message $message = null)
    {
        if (null === $message) {
            $message = $this->preparMessage($renderedTemplate, $subject, $fromEmail, $toEmails);
        }

        return $this->_sendMessage($message);
    }

    /**
     * Create Swift_Message instance and set parameters
     * 
     * @param  [type] $renderedTemplate [description]
     * @param  [type] $subject          [description]
     * @param  [type] $fromEmail        [description]
     * @param  [type] $toEmails         [description]
     * @return \Swift_Message           [description]
     */
    protected function preparMessage($renderedTemplate, $subject, $fromEmail, $toEmails)
    {
        if ($this->onTestHtml) {
            return $renderedTemplate;
        }

        if (!is_array($toEmails)) {
            $toEmails = [$toEmails];
        }

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmails)
            ->setBody($renderedTemplate, 'text/html')
        ;

        // If not an adminEmail, set adminEmails as BCC
        foreach(array_diff($this->adminEmails, $toEmails) as $adminEmail) {
            $message->addBcc($adminEmail);
        }

        return $message;
    }

    protected function _sendMessage(\Swift_Message $message)
    {
        $this->mailer->send($message);
    }
}