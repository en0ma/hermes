<?php
use Lawstands\Hermes\Channel;

/**
 * Created by BrainMaestro
 * Date: 29/1/2017
 * Time: 12:18 AM
 */
class ChannelTest extends PHPUnit_Framework_TestCase
{
    private $files = ['test.php', 'test.py'];

    public function setUp()
    {
        foreach ($this->files as $file) {
            fclose(fopen($file, 'w'));
        }
    }

    /**
     * @test
     */
    public function it_returns_all_receivers_that_are_valid()
    {
        $channel = new Channel(array_merge($this->files, ['file_that_does_not_exist']));
        // no file was created for 'file_that_does_not_exist', so it should
        // fail the validation check and not be included in the receivers array.
        $this->assertEquals($this->files, $channel->getReceivers());
    }
    
    public function tearDown()
    {
        foreach ($this->files as $file) {
            unlink($file);
        }
    }
}
