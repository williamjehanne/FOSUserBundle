<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Util;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class updating the hashed password in the user when there is a new password.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class PasswordUpdater
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function hashPassword(UserInterface $user)
    {
        $plainPassword = $user->getPlainPassword();

        if (0 ===  strlen($plainPassword)) {
            return;
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }
}
