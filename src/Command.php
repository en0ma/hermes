<?php namespace Lawstands\Hermes;

class Command
{
    /**
     * The channel that will be used to create
     * the command to be executed.
     *
     * @var array $channel
     * channel['type'] => channel type
     * channel['path'] => channel file location
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
     * Cordinate the
     *
     * @param array $channel
     * @param string $data
     * @param bool $async
     * @return string
     */
    public function execute($channel, $data, $async = true)
    {
        $this->channel = $channel;
        $this->async = $async;

        $command = $this->make($data);
        return $this->run($command);
    }

    /**
     * Retrieve the channel type.
     *
     * @return mixed
     */
    private function channelType()
    {
        return $this->channel['type'];
    }

    /**
     * Retrieve the channel file
     * location.
     *
     * @return mixed
     */
    private function channelPath()
    {
        return $this->channel['path'];
    }

    /**
     * Determine the output direction.
     *
     * @return null|string
     */
    private function redirect()
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
        return "{$this->channelType()} {$this->channelPath()} {$data} {$this->redirect()}";
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
        return exec($command, $output);
    }
}


