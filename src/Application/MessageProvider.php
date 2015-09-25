<?php


namespace Inspector\Application;


/**
 * @author Kabir Baidhya
 */
class MessageProvider
{

    /**
     * @var array
     */
    protected $messages;

    public function __construct(array $config)
    {
        $this->messages = $config['messages'];
    }

    /**
     * Gets a message for a key.
     *
     * @param string $key
     * @param array $params
     * @return string
     */
    public function getMessage($key, array $params)
    {
        $rawMessage = $this->messages[$key];

        return vsprintf($rawMessage, $params);
    }
}
