<?php

use Hermes\Hermes\Channel;

/**
 * Created by BrainMaestro.
 * Date: 01/02/2017
 * Time: 1:32 PM
 */
class ChannelTest extends PHPUnit_Framework_TestCase
{
    private $channels = [];

    public function setUp()
    {
        $this->channels = $this->getChannels();

        foreach ($this->channels as $channel) {
            fclose(fopen($channel['path'], 'w'));
        }
    }

    /**
     * @test
     */
    public function it_returns_all_valid_channels()
    {
        $validChannels = Channel::get(array_merge($this->channels, [['path' => 'file_that_does_not_exist']]));
        // no file was created for 'file_that_does_not_exist', so it should
        // fail the validation check and not be included in the channels array.
        $this->assertEquals($this->channels, $validChannels);
    }

    /**
     * @test
     */
    public function it_correctly_sets_missing_type_on_a_channel()
    {
        $type = $this->channels[0]['type'];
        unset($this->channels[0]['type']);
        $channels = Channel::get([$this->channels[0]]);

        $this->assertEquals($type, $channels[0]['type']);
    }

    private function getChannels()
    {
        return [
            ['path' => 'test.php', 'type' => 'php'],
            ['path' => 'test.py', 'type' => 'python'],
        ];
    }

    public function tearDown()
    {
        foreach ($this->channels as $channel) {
            unlink($channel['path']);
        }
    }
}
