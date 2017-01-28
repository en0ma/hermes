<?php
/**
 * Created by BrainMaestro
 * Date: 28/1/2017
 * Time: 10:32 PM
 */

namespace Lawstands\Hermes;

class Formatter
{
    /**
     * Format each receiver to: {program} {file-path} {encoded-data}
     *
     * @param Channel $channel
     * @param $data
     * @return array
     */
    public static function format(Channel $channel, $data)
    {
        return array_map(function ($receiver) use ($data) {
            return self::formatReceiver($receiver) . json_encode($data);
        }, $channel->getReceivers());
    }

    /**
     * Format receiver based on its extension.
     *
     * @param $receiver
     * @return string
     */
    private static function formatReceiver($receiver)
    {
        $extension = pathinfo($receiver, PATHINFO_EXTENSION);
        $program = self::getProgram($extension);

        return "{$program} {$receiver} ";
    }

    /**
     * Retrieve receiver extension and get the correct program to
     * run the receiver with
     *
     * @param $extension
     * @return string
     */
    private static function getProgram($extension)
    {
        // should contain only special cases where extension
        // does not map program unlike go, java, php.
        $map = [
            'rb' => 'ruby',
            'py' => 'python',
        ];

        // choose program extension if it was found in the map
        // or use extension as program.
        return array_key_exists($extension, $map) ? $map[$extension] : $extension;
    }
}