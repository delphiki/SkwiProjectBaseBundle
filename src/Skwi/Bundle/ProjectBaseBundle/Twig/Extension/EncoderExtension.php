<?php

namespace Skwi\Bundle\ProjectBaseBundle\Twig\Extension;

class EncoderExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'sha1' => new \Twig_SimpleFilter('sha1',function($string) {
                return sha1($string);
            })
            );
    }

    public function getName()
    {
        return 'encoder_extension';
    }

}
