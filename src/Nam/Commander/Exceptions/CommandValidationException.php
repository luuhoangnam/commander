<?php


namespace Nam\Commander\Exceptions;

use Illuminate\Support\MessageBag;
use RuntimeException;


/**
 * Class CommandValidationException
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander\Exceptions
 *
 */
class CommandValidationException extends RuntimeException
{

    /**
     * @var MessageBag
     */
    private $errors;

    /**
     * @param MessageBag $errors
     */
    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }
}