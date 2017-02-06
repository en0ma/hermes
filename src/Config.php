<?php
namespace Lawstands\Hermes;

use Lawstands\Hermes\Exception\HermesException;
use Lawstands\Hermes\Formatters\JsonFormatter;

class Config
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private static $requiredOptions = [
        'channels',
    ];

    /**
     * @var array
     */
    private static $requiredChannelProperties = [
        'path',
    ];

    /**
     * format: extension => program
     * @var array
     */
    private static $supportedTypes = [
        'rb' => 'ruby',
        'py' => 'python',
    ];

    /**
     * Config constructor.
     *
     * @param array $options
     * @throws HermesException
     */
    public function __construct(array $options)
    {
        if (! self::hasRequiredKeys(self::$requiredOptions, $options)) {
            throw new HermesException('Hermes config is missing one of the required config keys');
        }

        foreach ($options['channels'] as $channel => $props) {
            if (! self::hasRequiredKeys(self::$requiredChannelProperties, $props)) {
                throw new HermesException("Channel: {$channel}, is missing a required prop.");
            }

            $this->normalizeType($props);
            $this->normalizeFormatter($props);
            $this->probe($props);
        }
        $this->options = $options;
    }

    /**
     * Returns an array of channel objects created from the properties of the supplied aliases
     * that exist in the global options['channel'] array.
     *
     * @param string|array|null $aliases
     * @param $data
     * @param bool $async
     * @return array
     */
    public function getChannels($aliases = null, $data, $async = true)
    {
        if (is_null($aliases)) {
            $aliases = array_keys($this->options['channels']);
        }

        if (is_string($aliases)) {
            $aliases = (array) $aliases;
        }
        $aliasProps = array_intersect_key($this->options['channels'], array_flip($aliases));

        return array_map(function($props) use ($data, $async) {
            return new Channel($props, $data, $async);
        }, $aliasProps);
    }

    /**
     * Determines if the supplied keys matches with what
     * id required keys of $requiredOptions or $requiredChannelProperties
     *
     * @param array $requiredKeys
     * @param array $suppliedKeys
     * @return bool
     */
    private static function hasRequiredKeys($requiredKeys, array $suppliedKeys)
    {
        $difference = array_diff($requiredKeys, array_keys($suppliedKeys));
        return count($difference) == 0;
    }

    /**
     * When normalization is complete, check to
     * make sure channel can be executed from hermes.
     *
     * @param array $props
     * @throws HermesException
     */
    private function probe($props)
    {
        if (! file_exists($props['path'])) {
            throw new HermesException("File: {$props['path']}, not found.");
        }

        if (! class_exists($props['formatter'])) {
            throw new HermesException("Formatter: {$props['formatter']} class, not found.");
        }
    }

    /**
     * Determines the channel formatter to be used.
     * if the global formatter option is set we used that,
     * else we use the default JsonFormatter of hermes.
     *
     * @param $props
     * @return mixed
     */
    private function normalizeFormatter(&$props)
    {
        $props['formatter'] = isset($this->options['formatter']) ? $this->options['formatter'] : JsonFormatter::class;
    }

    /**
     * Determines the channel type. If channel type
     * is not specified in the channel properties, use the channel
     * file extension to determine the type from the list of supportedTypes.
     *
     * @param $props
     * @return string
     */
    private static function normalizeType(&$props)
    {
        if (! isset($props['type'])) {
            $extension = pathinfo($props['path'], PATHINFO_EXTENSION);
            $props['type'] = isset(self::$supportedTypes[$extension]) ? self::$supportedTypes[$extension] : $extension;
        }
    }
}