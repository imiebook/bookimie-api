<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Users;

class UsersService
{

    /* @var EntityManager */
    private $em;

    /* @var Mailer */
    private $mailer;

    private $container;

    public function __construct(EntityManager $entityManager, \Swift_Mailer $mailer, $container) {
        $this->em = $entityManager;
        $this->mailer = $mailer;
        $this->container = $container;
    }

    public function sendResetPasswordEmail(Users $user, string $password) {
        // construct message
        $message = (new \Swift_Message())
            ->setSubject("Imie Book - Demo Resetting")
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($user->getEmail())
            ->setBody(
            $this->container->get('templating')->render(
                'email/password_resetting.email.twig',
                array(
                    'name' => $user->getUsername(),
                    'password' => $password
                )
            ),
            'text/plain'
        );

        // send message
        $this->mailer->send($message);
    }

    public function resetPasswordUser(Users $user) {
        // get new password
        $password = $this->generateRandumPassword();
        // get user
        $encoder = $this->container->get('security.password_encoder');
        $user->setPassword($encoder->encodePassword($user, $password));
        // persit user
        $this->em->persist($user);
        $this->em->flush();
        // send email of confirmation
        $this->sendResetPasswordEmail($user, $password);
    }

    private function generateRandumPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
