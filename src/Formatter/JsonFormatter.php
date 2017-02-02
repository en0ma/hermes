<?php
namespace Lawstands\Hermes\Formatter;

use Lawstands\Hermes\Formatter;

class JsonFormatter implements Formatter
{
    /**
     * Format the data to be sent to the channels.
     *
     * @param $data
     * @return string
     */
    public function format($data)
    {
        if (is_scalar($data)) {
            return (string) $data;
        }
        return json_encode($data);
    }
}
