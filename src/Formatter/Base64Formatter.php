<?php
namespace Lawstands\Hermes\Formatter;

use Lawstands\Hermes\Formatter;

class Base64Formatter implements Formatter
{
    /**
     * Format the data to be sent to the channels.
     *
     * @param $data
     * @return string
     */
    public function format($data)
    {
        return base64_encode((string) $data);
    }
}