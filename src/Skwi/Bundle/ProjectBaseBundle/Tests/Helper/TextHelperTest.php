<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\Helper;

use Skwi\Bundle\ProjectBaseBundle\Helper\TextHelper;

class TextHelperTest extends \PHPUnit_Framework_TestCase
{
        /**
     * Provider for testCheckMandatoryFiles method
     *
     * @return array Provided data
     */
    public static function slugProvider()
    {
        return array(
            array('hello', 'hello'),
            array('string with space', 'string-with-space'),
            array('&strïng with-som€%stãngé//çhàrctèr$§', '-str-ng-with-som-st-ng-h-rct-r-'),
            );
    }

    /**
     * Test for method slug
     *
     * @param string $string The string to slug
     * @param string $slug   The slugged string
     *
     * @dataProvider slugProvider
     */
    public function testSlug($string, $slug)
    {
        $result = TextHelper::slug($string);
        $this->assertEquals($result, $slug);
    }

}
