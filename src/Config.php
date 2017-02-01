<?php
/**
 * Created by BrainMaestro
 * Date: 1/2/2017
 * Time: 7:37 PM
 */

namespace Hermes\Hermes;

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
     * Get a channel by its alias
     * 
     * @param string $alias
     * @return null|array
     */
    public function getChannel($alias)
    {
        if (! array_key_exists($alias, $this->config['channels'])) {
            return null;
        }
        
        return $this->config['channels'][$alias];
    }
}