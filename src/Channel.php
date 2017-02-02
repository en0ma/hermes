<?php

namespace Lawstands\Hermes;

use Lawstands\Hermes\Exception\HermesException;

/**
 * Created by BrainMaestro
 * Date: 28/1/2017
 * Time: 2:20 PM
 */
class Channel
{
    /**
     * format: extension => program
     * @var array
     */
    private static $types = [
            'rb' => 'ruby',
            'py' => 'python',
        ];

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * @var bool
     */
    private $async;

    /**
     * Channel constructor.
     *
     * @param array $config
     * @param $data
     * @param bool $async
     * @throws HermesException
     */
    public function __construct(array $config, $data, $async = true)
    {
        if (! self::isValid($config['path'])) {
            throw new HermesException('Channel path is invalid');
        }

        $this->data = $data;
        $this->path = $config['path'];
        $this->type = isset($config['type']) ? $config['type'] : self::getType($config['path']);
        $this->formatter = self::getFormatter($config['formatter']);
        $this->async = $async;
        $this->command = $this->buildCommand();
    }

    /**
     * Execute channel command.
     *
     * @return string
     */
    public function execute()
    {
        return shell_exec($this->command);
    }

    /**
     * Build command.
     *
     * @return string
     */
    private function buildCommand()
    {
        $data = $this->formatter->format($this->data);
        $redirect = $this->async ? '&>/dev/null' : '';

        return "{$this->type} {$this->path} {$data} {$redirect}";
    }

    /**
     * Validate channel path.
     *
     * @param $path
     * @return bool
     */
    private static function isValid($path)
    {
        return file_exists($path);
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
        return isset(self::$types[$extension]) ? self::$types[$extension] : $extension;
    }

    private static function getFormatter($formatter)
    {
        return new $formatter;
    }
}
