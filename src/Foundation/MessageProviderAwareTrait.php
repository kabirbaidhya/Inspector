<?php


namespace Inspector\Foundation;


/**
 * @author Kabir Baidhya
 */
trait MessageProviderAwareTrait
{

    /**
     * @var MessageProvider
     */
    protected $messageProvider;

    /**
     * Sets message provider.
     *
     * @param MessageProvider $messageProvider
     * @return $this
     */
    public function setMessageProvider(MessageProvider $messageProvider)
    {
        $this->messageProvider = $messageProvider;

        return $this;
    }
}
