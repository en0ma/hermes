<?php

namespace Hermes\Hermes;

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
     * Get valid channels.
     *
     * @param array $channels
     * @return array
     */
    public static function get(array $channels)
    {
        // create an array of valid channels.
        // the array filter removes the null elements which are
        // the invalid channels.
        return array_filter(array_map(function ($channel) {
            $channel['type'] = self::getType($channel);

            return self::isValid($channel) ? $channel : null;
        }, $channels));
    }

    /**
     * Validate channels.
     *
     * @param $channel
     * @return bool
     */
    private static function isValid($channel)
    {
        return file_exists($channel['path']);
    }

    /**
     * Get a channel's type.
     *
     * @param $channel
     * @return string
     */
    private static function getType($channel)
    {
        if (isset($channel['type']) && $channel['type']) {
            return $channel['type'];
        }

        $extension = pathinfo($channel['path'], PATHINFO_EXTENSION);
        // choose type if it was found in the types map
        // or use extension as the type.
        return array_key_exists($extension, self::$types) ? self::$types[$extension] : $extension;
    }
}
