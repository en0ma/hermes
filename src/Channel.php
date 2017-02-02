<?php
namespace Lawstands\Hermes;

class Channel
{
    /**
     * Channel command.
     *
     * @var $command
     */
    private $command;


    /**
     * Channel constructor.
     * @param array $config
     * @param $data
     * @param bool $async
     */
    public function __construct(array $config, $data, $async = true)
    {
        $data = self::formatData($data, $config['formatter']);
        $this->buildCommand($config, $data, $async);
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
     * Build channel command.
     *
     * @param $config
     * @param $data
     * @param $async
     * @return string
     */
    private function buildCommand($config, $data, $async)
    {
        $redirect = $async ? '&>/dev/null' : '';
        $this->command = "{$config['type']} {$config['path']} {$data} {$redirect}";
    }

    /**
     * Format channel data.
     *
     * @param $data
     * @param $formatter
     * @return mixed
     */
    private static function formatData($data, $formatter)
    {
        $formatter = new $formatter;
        return $formatter->format($data);
    }
}
