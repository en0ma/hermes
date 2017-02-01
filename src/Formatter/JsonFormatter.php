<?php
/**
 * Created by BrainMaestro.
 * Date: 01/02/2017
 * Time: 4:43 PM
 */

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
        // return the data if it is a primitive type
        // that does not require json encoding
        if (is_scalar($data)) {
            return (string) $data;
        }

        return json_encode($data);
    }
}