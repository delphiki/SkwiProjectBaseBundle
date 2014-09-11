<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\Units\Helper;

use atoum\AtoumBundle\Test\Units;
use Skwi\Bundle\ProjectBaseBundle\Helper\TextHelper as TestedTextHelper;

class TextHelper extends Units\Test
{
    /**
     * Test for method slug
     *
     * @param string $string The string to slug
     * @param string $slug   The slugged string
     *
     * @dataProvider testSlugProvider
     */
    public function testSlug($string, $slug)
    {
        $this
            ->if($result = TestedTextHelper::slug($string))
            ->then
            ->string($result)
            ->isEqualTo($slug)
        ;
    }

    /**
     * Provider for testSlug method
     *
     * @return array Provided data
     */
    public function testSlugProvider()
    {
        return array(
            array('hello', 'hello'),
            array('string with space', 'string-with-space'),
            array('&strïng with-som€%stãngé//çhàrctèr$§', '-str-ng-with-som-st-ng-h-rct-r-'),
        );
    }
}