<?php


namespace Nam\Commander\Exceptions;

use RuntimeException;

/**
 * Class ValidationDataInvalid
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander\Exceptions
 *
 */
class ValidationDataInvalidException extends RuntimeException
{
    /**
     * @var array
     */
    private $invalidData = [];

    /**
     * @param array $invalidData
     */
    public function __construct($invalidData)
    {
        $this->invalidData = $invalidData;
    }

    /**
     * @return array
     */
    public function getInvalidData()
    {
        return $this->invalidData;
    }
}