<?php
use Lawstands\Hermes\Formatter\JsonFormatter;

/**
 * Created by Ezinwa Okpoechi.
 * iROKO Partners Ltd
 * Date: 01/02/2017
 * Time: 5:06 PM
 */
class JsonFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_format_data_as_json()
    {
        $data = ['messenger', 'of', 'the', 'gods'];
        $formatter = new JsonFormatter;
        $this->assertEquals($formatter->format($data), json_encode($data));

        $data = 123;
        $this->assertEquals($formatter->format($data), (string) $data);
    }
}
