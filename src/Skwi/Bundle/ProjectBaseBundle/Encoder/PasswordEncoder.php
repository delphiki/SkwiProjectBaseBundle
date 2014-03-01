<?php

namespace Skwi\Bundle\ProjectBaseBundle\Encoder;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    /**
     * Algorithm to use for password encoding
     * @var string
     */
    private $algorithm;

    /**
     * Class constructor
     * @param string $algorithm Algorithm to use for password encoding
     */
    public function __construct($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Encode password
     * @param  string $raw  The raw password
     * @param  string $salt The encoding salt
     * @return string       The encoded password
     */
    public function encodePassword($raw, $salt)
    {
        $string = strrpos($salt, 'a')%3 ? $salt.$raw : $raw.$salt;

        return hash($this->algorithm, $string);
    }

    /**
     * Check if a raw password matches an encoded one
     * @param  string  $encoded The encoded password
     * @param  string  $raw     The raw password
     * @param  string  $salt    The encoding salt
     * @return boolean          TRUE for password match, FALSE otherwise
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $this->encodePassword($raw, $salt) === $encoded;
    }

}
