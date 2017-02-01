<?php
use Lawstands\Hermes\Config;

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
        $this->assertEquals(self::$configData['channels'][$alias], self::$config->getChannel($alias));
    }

    /**
     * @test
     */
    public function it_should_return_null_with_an_incorrect_alias()
    {
        $alias = 'channel_does_not_exist';
        $this->assertNull(self::$config->getChannel($alias));
    }
}
