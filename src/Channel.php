<?php

namespace Lawstands\Hermes;

/**
 * Created by BrainMaestro
 * Date: 28/1/2017
 * Time: 2:20 PM
 */
class Channel
{
    /**
     * @var array
     */
    private $receivers = [];

    /**
     * Channel constructor.
     * 
     * @param array $receivers
     */
    public function __construct(array $receivers)
    {
        foreach ($receivers as $receiver) {
            if ($this->isValid($receiver)) {
                $this->receivers[] = $receiver;
            }
        }
    }

    /**
     * Get all receivers.
     *
     * @return array
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * Validate receivers.
     *
     * @param $receiver
     * @return bool
     */
    private function isValid($receiver)
    {
        return file_exists($receiver);
    }
}
