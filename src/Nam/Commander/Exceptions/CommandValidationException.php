<?php


namespace Nam\Commander\Exceptions;

use Illuminate\Support\Contracts\MessageProviderInterface;
use Illuminate\Support\MessageBag;
use RuntimeException;

/**
 * Class CommandValidationException
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander\Exceptions
 *
 */
class CommandValidationException extends RuntimeException implements MessageProviderInterface
{

    /**
     * @var MessageBag
     */
    private $messageBag;

    /**
     * Get the messages for the instance.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }

    /**
     * Get all error messages
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->messageBag->all();
    }

    /**
     * @param MessageBag $messageBag
     */
    public function __construct(MessageBag $messageBag = null)
    {
        $this->messageBag = $messageBag;
    }
}
