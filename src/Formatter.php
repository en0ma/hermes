<?php
/**
 * Created by BrainMaestro
 * Date: 01/02/2017
 * Time: 4:40 PM
 */

namespace Hermes\Hermes;

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