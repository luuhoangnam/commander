<?php


namespace Nam\Commander;

use Nam\Commander\Exceptions\CommandValidationException;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Nam\Commander\Exceptions\ValidationDataInvalidException;


/**
 * Class BaseCommandValidator
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander
 *
 */
abstract class BaseCommandValidator implements CommandValidator
{
    /**
     * @var Factory
     */
    protected $validator;

    /**
     * @var Validator
     */
    protected $validation;

    /**
     * @var array
     */
    protected $data = [ ];

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws ValidationDataInvalidException
     * @return array
     */
    public function getData()
    {
        if (is_array($this->data) && count($this->data) > 0) {
            return $this->data;
        }

        throw new ValidationDataInvalidException($this->data);
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    protected function getErrors()
    {
        return $this->validation->errors();
    }

    /**
     * @return bool
     */
    public function internalValidation()
    {
        $this->validation = $this->validator->make($this->getData(), $this->rules());

        if ($this->validation->fails()) {
            throw new CommandValidationException($this->getErrors());
        }

        return true;
    }

    /**
     * @return array
     */
    abstract public function rules();
}