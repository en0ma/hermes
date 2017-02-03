<?php
namespace Lawstands\Hermes;

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
     * Relay message asynchronously.
     *
     * @param $data
     * @param null|string|array $aliases
     */
    public function relay($data, $aliases = null)
    {
        $this->process($data, $aliases, true);
    }

    /**
     * Relay message synchronously.
     *
     * @param $data
     * @param null|string|array $aliases
     */
    public function relaySync($data, $aliases = null)
    {
        $this->process($data, $aliases, false);
    }

    /**
     * @param $data
     * @param $aliases
     * @param $async
     */
    private function process($data, $aliases, $async)
    {
        $channels = $this->config->getChannels($aliases, $data, $async);
        foreach($channels as $channel) {
            $channel->execute();
        }
    }
}
