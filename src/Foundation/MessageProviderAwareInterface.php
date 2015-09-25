<?php


namespace Inspector\Foundation;


/**
 * @author Kabir Baidhya
 */
interface MessageProviderAwareInterface
{

    /**
     * Sets message provider.
     *
     * @param MessageProvider $messageProvider
     * @return mixed
     */
    public function setMessageProvider(MessageProvider $messageProvider);
}
