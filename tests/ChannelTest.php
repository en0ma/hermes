<?php
use Lawstands\Hermes\Channel;
use Lawstands\Hermes\Exception\HermesException;
use Lawstands\Hermes\Formatter\JsonFormatter;

/**
 * Created by BrainMaestro.
 * Date: 01/02/2017
 * Time: 1:32 PM
 */
class ChannelTest extends PHPUnit_Framework_TestCase
{
    private $channel;
    private $channelConfig;

    public function setUp()
    {
        $data = 'testing';
        $this->channelConfig = ['path' => 'test.php', 'type' => 'php', 'formatter' => JsonFormatter::class];
        fclose(fopen($this->channelConfig['path'], 'w'));
        $this->channel = new Channel($this->channelConfig, $data);
    }

    /**
     * @test
     */
    public function it_fails_if_the_path_does_not_exist()
    {
        $this->channelConfig['path'] = 'file_that_does_not_exist';
        $this->expectException(HermesException::class);
        new Channel($this->channelConfig, 'testing');
    }

    public function tearDown()
    {
        try {
            unlink($this->channelConfig['path']);
        } catch (Exception $e) {}
    }
}
