<?php


namespace Nam\Commander;

use Illuminate\Foundation\Application;
use Illuminate\Validation\Factory;
use Nam\Commander\Exceptions\CommandValidationException;
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
    protected $rules = [ ];

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
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->validator = $this->app->make('Illuminate\Validation\Factory');
    }

    /**
     * @throws ValidationDataInvalidException
     * @return array
     */
    public function getData()
    {
        if (count($this->rules) > count($this->data)) {
            throw new ValidationDataInvalidException($this->data);
        }

        return $this->data;
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
    protected function internalValidation()
    {
        $this->validation = $this->validator->make($this->getData(), $this->getRules());

        if ($this->validation->fails()) {
            throw new CommandValidationException($this->getErrors());
        }

        return true;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $field
     * @param string $rules
     */
    public function addRule($field, $rules)
    {
        $existRules = '';
        if (isset( $this->rules[$field] )) {
            $existRules = $this->rules[$field];
        }

        $newRuleSegments = explode('|', $existRules);
        foreach (explode('|', $rules) as $segment) {
            $newRuleSegments[] = $segment;
        }

        $this->rules[$field] = implode('|', $newRuleSegments);
    }
}
