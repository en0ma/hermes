<?php namespace Lawstands\Hermes;

class Hermes
{
    /**
     * Instance of the config class.
     *
     * @var Config
     */
    private $config;

    /**
     * Hermes constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Relay message synchronously.
     *
     * @param $data
     * @param null $alias
     */
    public function relay($data, $alias = null)
    {
        $this->process($data, $alias, false);
    }

    /**
     * Relay message asynchronously.
     *
     * @param $data
     * @param null $alias
     * @return array
     */
    public function relaySync($data, $alias = null)
    {
        return $this->process($data, $alias, true);
    }

    /**
     * @param $data
     * @param $alias
     * @param $async
     * @return array
     */
    private function process($data, $alias, $async)
    {
        $channels = $this->channels($alias);
        $responses = [];

        foreach($channels as $channel) {
            $formatter = $channel->formatter;
            $command = $channel->command;
            $responses[$channel->alias] = $command->execute($formatter->transform($data), $async);
        }
        return $responses;
    }

    private function channels($alias)
    {
        $channel = new Channel();
        return $channel->Channels($this->config->getWith($alias));
    }
}
