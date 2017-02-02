<?php 

namespace Hermes\Hermes;

class Command
{
    /**
     * The channel used to create the command to be executed.
     *
     * @var Channel $channel
     */
    private $channel;

    /**
     * The $async flag is used to generate
     * the command redirection. If true it redirects
     * to the null device, giving the ability of
     * of asynchronous.
     *
     * @var boolean $async
     */
    private $async;

    /**
     * Command constructor.
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Coordinate the the execution of the command.
     *
     * @param string $data
     * @param bool $async
     * @return string
     */
    public function execute($data, $async = true)
    {
        $this->async = $async;
        $command = $this->make($data);
        return $this->run($command);
    }

    /**
     * Determine the output direction.
     *
     * @return null|string
     */
    private function redirection()
    {
        return ($this->async) ? '&>/dev/null' : null;
    }

    /**
     * Prepare the command from the properties
     * of the channel, the $data and the redirect
     * output.
     *
     * @param string $data
     * @return string
     */
    private function make($data)
    {
        return "{$this->channel->type} {$this->channel->path} {$data} {$this->redirection()}";
    }

    /**
     * Execute command by calling exec().
     * The output from the executed command is returned in $output.
     *
     * @param string $command
     * @return string
     */
    private function run($command)
    {
        return exec($command, $commandOutput);
    }
}


