<?php
use Lawstands\Hermes\Channel;
use Lawstands\Hermes\Formatter;

/**
 * Created by BrainMaestro
 * Date: 28/1/2017
 * Time: 11:40 PM
 */
class FormatterTest extends PHPUnit_Framework_TestCase
{
    private $channel;
    private static $data;

    public static function setUpBeforeClass()
    {
        self::$data = json_encode([
            'name' => 'John Doe',
            'age'  => '30',
            'family' => ['Jane Doe'],
        ]);
    }

    public function setUp()
    {
        $this->channel = $this->createMock(Channel::class);
    }

    /**
     * @test
     */
    public function it_formats_valid_receivers_correctly()
    {
        $this->channel->method('getReceivers')
            ->willReturn(['test.php', 'test.py', 'test.fake']);

        $this->assertEquals([
            'php test.php '   . self::$data,
            'python test.py ' . self::$data,
            'fake test.fake ' . self::$data,
        ], Formatter::format($this->channel, json_decode(self::$data)));
    }
}
