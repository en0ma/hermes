<?php
/**
 * Created by BrainMaestro
 * Date: 1/2/2017
 * Time: 7:37 PM
 */

namespace Lawstands\Hermes;

class Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get channel by their aliases
     * 
     * @param string|array|null $aliases
     * @return array
     */
    public function getChannels($aliases)
    {
        if (is_null($aliases)) {
            return $this->config['channels'];
        }

        if (is_string($aliases)) {
            $aliases = [$aliases];
        }

        return array_filter(array_map(function ($alias) {
            if (! array_key_exists($alias, $this->config['channels'])) {
                return null;
            }

            return $this->config['channels'][$alias];
        }, $aliases));
    }

//    private function validate
}