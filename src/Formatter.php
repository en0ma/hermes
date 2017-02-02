<?php
namespace Lawstands\Hermes;

interface Formatter
{
    /**
     * Format the data to be sent to the channels.
     *
     * @param $data
     * @return string
     */
    public function format($data);
}