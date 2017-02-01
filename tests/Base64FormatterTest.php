<?php
use Lawstands\Hermes\Formatter\Base64Formatter;

/**
 * Created by Ezinwa Okpoechi.
 * iROKO Partners Ltd
 * Date: 01/02/2017
 * Time: 5:19 PM
 */
class Base64FormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_format_data_as_base64_string()
    {
        $data = 'messenger of the gods';
        $formatter = new Base64Formatter;
        $this->assertEquals($formatter->format($data), base64_encode($data));
    }
}
