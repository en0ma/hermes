<?php
use Lawstands\Hermes\Channel;
use Lawstands\Hermes\Config;
use Lawstands\Hermes\Exception\HermesException;
use Lawstands\Hermes\Formatters\Base64Formatter;
use Lawstands\Hermes\Formatters\JsonFormatter;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    private static $config;
    private static $configData;
    private static $data;

    public static function setUpBeforeClass()
    {
        self::$configData = [
            'channels' => [
                'test1' => ['path' => 'test.py', 'formatter' => Base64Formatter::class],
                'test2' => ['path' => 'test.php'],
                'test3' => ['path' => 'test.rb', 'formatter' => Base64Formatter::class],
            ],
            'default_formatter' => JsonFormatter::class
        ];
        self::$config = new Config(self::$configData);
        self::$data = 'relay_this_string';
        foreach (self::$configData['channels'] as $channel) {
            fclose(fopen($channel['path'], 'w'));
        }
    }

    /**
     * @test
     */
    public function it_should_return_the_correct_channel_using_an_alias()
    {
        $alias = 'test1';
        $channel = new Channel(self::$configData['channels'][$alias], self::$data);
        $this->assertEquals([$channel], self::$config->getChannels($alias, self::$data));
    }

    /**
     * @test
     */
    public function it_should_return_the_correct_channels_using_several_aliases()
    {
        $aliases = ['test1', 'test3'];
        $channel1 = new Channel(self::$configData['channels'][$aliases[0]], self::$data);
        $channel2 = new Channel(self::$configData['channels'][$aliases[1]], self::$data);

        $expectedChannels = [$channel1, $channel2];
        $this->assertEquals($expectedChannels, self::$config->getChannels($aliases, self::$data));
    }

    /**
     * @test
     */
    public function it_should_return_an_empty_array_with_an_incorrect_alias()
    {
        $alias = 'channel_does_not_exist';
        $this->assertEmpty(self::$config->getChannels($alias, self::$data));
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_a_required_key_is_not_present()
    {
        $this->expectException(HermesException::class);
        new Config([]); // empty array
    }

    public static function tearDownAfterClass()
    {
        foreach (self::$configData['channels'] as $channel) {
            unlink($channel['path']);
        }
    }
}
