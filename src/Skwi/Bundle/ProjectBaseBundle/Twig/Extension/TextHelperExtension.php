<?php

namespace Skwi\Bundle\ProjectBaseBundle\Twig\Extension;

use Skwi\Bundle\ProjectBaseBundle\Helper\TextHelper;

class TextHelperExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'slug' => new \Twig_Filter_Method($this, 'slug'),
            'striptags' => new \Twig_Filter_Method($this, 'striptags'),
        );
    }

    public function slug($string)
    {
        return TextHelper::slug($string);
    }

    public function striptags($string)
    {
        return strip_tags($string);
    }

    public function getName()
    {
        return 'texthelper_extension';
    }

}