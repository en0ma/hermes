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
     * format: extension => program
     * @var array
     */
    private static $channelTypes = [
        'rb' => 'ruby',
        'py' => 'python',
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

        foreach ($config['channels'] as $channel) {
            $this->normalizeChannelConfig($channel);
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

            return new Channel($this->config['channels'][$alias], $data, $async);
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
     * Get a channel's type.
     *
     * @param $path
     * @return string
     */
    private static function getType($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        // choose type if it was found in the types map
        // or use extension as the type.
        return isset(self::$channelTypes[$extension]) ? self::$channelTypes[$extension] : $extension;
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

    /**
     * Normalize the channel config.
     *
     * @param array $channelConfig
     * @throws HermesException
     */
    private function normalizeChannelConfig(array &$channelConfig)
    {
        if (! isset($channelConfig['path']) || ! file_exists($channelConfig['path'])) {
            throw new HermesException('Path either was not specified or the file does not exist');
        }

        if (! isset($channelConfig['formatter'])) {
            $channelConfig['formatter'] = $this->getDefaultFormatter();
        }

        if (! class_exists($channelConfig['formatter'])) {
            throw new HermesException('Formatter does not exist');
        }

        if (! isset($channelConfig['type'])) {
            $channelConfig['type'] = $this->getType();
        }
    }
}