<?php
/**
 * Created by BrainMaestro.
 * Date: 01/02/2017
 * Time: 5:04 PM
 */

namespace Hermes\Hermes\Formatter;

use Hermes\Hermes\Formatter;

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