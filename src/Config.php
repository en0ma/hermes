<?php
/**
 * Created by BrainMaestro
 * Date: 1/2/2017
 * Time: 7:37 PM
 */

namespace Lawstands\Hermes;

use Lawstands\Hermes\Exception\HermesException;
use Lawstands\Hermes\Formatter\JsonFormatter;

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
        if (! self::hasRequiredKeys($config)) {
            throw new HermesException('Hermes config is missing one of the required config keys');
        }

        $this->config = $config;
    }

    /**
     * Get channels by their aliases.
     *
     * @param string|array|null $aliases
     * @param $data
     * @param bool $async
     * @return array
     */
    public function getChannels($aliases = null, $data, $async = true)
    {
        if (is_null($aliases)) {
            // get all aliases
            $aliases = array_keys($this->config['channels']);
        }

        if (is_string($aliases)) {
            $aliases = [$aliases];
        }

        // create an array of valid channels.
        // the array filter removes the null elements which are
        // the invalid channels.
        return array_filter(array_map(function ($alias) use ($data, $async) {
            if (! isset($this->config['channels'][$alias])) {
                return null;
            }

            $channelConfig = array_merge(['formatter' => $this->getDefaultFormatter()], $this->config['channels'][$alias]);

            try {
                return new Channel($channelConfig, $data, $async);
            } catch (HermesException $e) {
                $silent = isset($channelConfig['silent']) ? $channelConfig['silent'] : false;
                if ($silent) {
                    return null;
                }

                throw $e;
            }
        }, $aliases));
    }

    /**
     * Get the default formatter.
     *
     * @return mixed
     */
    private function getDefaultFormatter()
    {
        return isset($this->config['default_formatter']) ? $this->config['default_formatter'] : JsonFormatter::class;
    }

    /**
     * Check that the config contains the required keys.
     *
     * @param array $config
     * @return bool
     */
    private static function hasRequiredKeys(array $config)
    {
        $difference = array_diff(self::$requiredKeys, array_keys($config));

        return count($difference) == 0;
    }
}