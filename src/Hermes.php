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
     * @param null $aliases
     * @return array
     */
    public function relay($data, $aliases = null)
    {
        return $this->process($data, $aliases, true);
    }

    /**
     * Relay message synchronously.
     *
     * @param $data
     * @param null|string|array $aliases
     * @return array
     */
    public function relaySync($data, $aliases = null)
    {
        $this->process($data, $aliases, false);
    }

    /**
     * @param $data
     * @param $aliases
     * @param $async
     * @return array $responses
     */
    private function process($data, $aliases, $async)
    {
        $channels = $this->config->getChannels($aliases, $data, $async);

        return array_map(function(Channel $channel) {
            return $channel->execute();
        }, $channels);
    }
}
