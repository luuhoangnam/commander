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

    /**
     * @var Factory
     */
    protected $validator;

    /**
     * @var Validator
     */
    protected $validation;

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
     * @return \Illuminate\Support\MessageBag
     */
    protected function getErrors()
    {
        return $this->validation->errors();
    }

    /**
     * @return bool
     */
    public function validate($command)
    {
        if (! is_object($command)) {
            throw new CommandValidationException();
        }

        $data = get_object_vars($command);

        $this->validation = $this->validator->make($data, $this->rules());

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
