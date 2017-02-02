<?php
use Lawstands\Hermes\Config;
use Lawstands\Hermes\Exception\HermesException;

/**
 * Created by BrainMaestro
 * Date: 1/2/2017
 * Time: 7:42 PM
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{
    private static $config;
    private static $configData;

    public static function setUpBeforeClass()
    {
        self::$configData = [
            'channels' => [
                'test1' => ['path' => 'test.py'],
                'test2' => ['path' => 'test.php'],
                'test3' => ['path' => 'test.rb'],
            ]
        ];
        self::$config = new Config(self::$configData);
    }

    /**
     * @test
     */
    public function it_should_return_the_correct_channel_using_an_alias()
    {
        $alias = 'test1';
        $this->assertEquals([self::$configData['channels'][$alias]], self::$config->getChannels($alias));
    }

    /**
     * @test
     */
    public function it_should_return_the_correct_channels_using_several_aliases()
    {
        $aliases = ['test1', 'test3'];
        $expectedChannels = [self::$configData['channels'][$aliases[0]], self::$configData['channels'][$aliases[1]]];
        $this->assertEquals($expectedChannels, self::$config->getChannels($aliases));
    }

    /**
     * @test
     */
    public function it_should_return_an_empty_array_with_an_incorrect_alias()
    {
        $alias = 'channel_does_not_exist';
        $this->assertEmpty(self::$config->getChannels($alias));
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_a_required_key_is_not_present()
    {
        $this->expectException(HermesException::class);
        new Config([]); // empty array
    }
}
