<?php
/**
 * Created by BrainMaestro
 * Date: 1/2/2017
 * Time: 7:37 PM
 */

namespace Lawstands\Hermes;

use Lawstands\Hermes\Exception\HermesException;

class Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private static $requiredKeys = [
        'channels',
    ];

    /**
     * Config constructor.
     *
     * @param array $config
     * @throws HermesException
     */
    public function __construct(array $config)
    {
        if (! self::isValid($config)) {
            throw new HermesException('Hermes config is missing one of the required config keys');
        }

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
        // get all aliases
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

    /**
     * @param array $config
     * @return bool
     */
    private static function isValid(array $config)
    {
        $difference = array_diff(self::$requiredKeys, array_keys($config));

        return count($difference) == 0;
    }
}