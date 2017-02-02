<?php
use Lawstands\Hermes\Formatters\Base64Formatter;

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
