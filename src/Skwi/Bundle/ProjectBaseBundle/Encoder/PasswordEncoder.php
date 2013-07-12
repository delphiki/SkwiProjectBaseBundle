<?php

namespace Skwi\Bundle\ProjectBaseBundle\Encoder;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordEncoder implements PasswordEncoderInterface
{

    private $algorithm;

    public function __construct($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function encodePassword($raw, $salt)
    {
        $string = $salt.$raw.$salt;
        return call_user_func($this->algorithm, $string);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $this->encodePassword($raw, $salt) === $encoded;
    }

}