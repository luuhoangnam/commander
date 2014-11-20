<?php

namespace Nam\Commander\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Factory as View;
use Nam\Commander\Inflectors\CommandInflector;

/**
 * Class Generator
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class Generator
{

    private $author = [
        'name'  => 'Nam Hoang Luu',
        'email' => 'nam@mbearvn.com'
    ];

    private $properties = [ ];

    private $extra = [
        'openTag' => '<?php',
        '@'       => '@',
        'null'    => 'null'
    ];

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * @var View
     */
    private $viewFactory;
    private $rootNamespace;
    private $group;
    /**
     * @var CommandInflector
     */
    private $inflector;
    private $basePath;
    private $commandPath;
    private $handlerPath;
    private $validatorPath;

    /**
     * @param Filesystem       $file
     * @param View             $viewFactory
     * @param CommandInflector $inflector
     */
    public function __construct(Filesystem $file, View $viewFactory, CommandInflector $inflector)
    {
        $this->file = $file;
        $this->viewFactory = $viewFactory;
        $this->inflector = $inflector;
    }

    /**
     * @param string $commandName
     * @param string $properties
     */
    public function make($commandName, $properties = null)
    {
        if ($properties) {
            $this->parseProperties($properties);
        }

        $viewData = [
            'author'      => $this->author,
            'group'       => $this->group,
            'commandName' => $commandName,
            'properties'  => $this->properties,
            'extra'       => $this->extra,
        ];

        $viewData['commandNamespace'] = $this->getNamespaceFor('command');
        $viewData['handlerNamespace'] = $this->getNamespaceFor('handler');
        $viewData['validatorNamespace'] = $this->getNamespaceFor('validator');

        $this->makeFiles($viewData);

        return;
    }

    /**
     * @param string $namespace
     *
     * @return $this
     */
    public function setRootNamespace($namespace)
    {
        $this->rootNamespace = $namespace;

        return $this;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @param string $commandPath
     *
     * @return $this
     */
    public function setCommandPath($commandPath)
    {
        $this->commandPath = $commandPath;

        return $this;
    }

    /**
     * @param string $handlerPath
     *
     * @return $this
     */
    public function setHandlerPath($handlerPath)
    {
        $this->handlerPath = $handlerPath;

        return $this;
    }

    /**
     * @param string $validatorPath
     *
     * @return $this
     */
    public function setValidatorPath($validatorPath)
    {
        $this->validatorPath = $validatorPath;

        return $this;
    }

    /**
     * @param string $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @param string $name
     * @param string $type
     * @param string $rules
     *
     * @return $this
     */
    public function addProperty($name, $type = 'string', $rules = '')
    {
        $prop = [
            'name'  => $name,
            'type'  => $type,
            'rules' => $rules,
        ];

        foreach ($this->properties as $index => $property) {
            if ($property['name'] === $name) {
                $this->properties[$index] = $prop;

                return $this;
            }
        }

        $this->properties[] = $prop;

        return $this;
    }

    /**
     * @param string $for
     *
     * @return string
     */
    protected function getNamespaceFor($for = 'command')
    {
        $namespace = $this->rootNamespace;
        $namespace = $namespace . '\\' . ( $this->{"{$for}Path"} ?: ucfirst(\Str::camel(\Str::plural($for))) );

        if ($this->group) {
            $namespace = $namespace . '\\' . $this->group;
        }

        return $namespace;
    }

    /**
     * @param $viewData
     *
     * @return int
     */
    protected function makeFiles($viewData)
    {
        return [
            $this->makeFile('command', $viewData),
            $this->makeFile('handler', $viewData),
            $this->makeFile('validator', $viewData),
        ];
    }

    /**
     * @param string $for
     *
     * @return string
     */
    protected function getDirFor($for = "command")
    {
        $dir = ucfirst(\Str::camel(\Str::plural($for)));
        $commandDir = "{$this->basePath}/" . ( $this->{$for . 'Path'} ?: $dir );

        if ($this->group) {
            $commandDir .= "/$this->group";
        }

        return $commandDir;
    }

    /**
     * @param string $commandName
     *
     * @return mixed
     */
    protected function getCommandFileName($commandName)
    {
        return $commandName . '.php';
    }

    /**
     * @param string $commandName
     *
     * @return mixed
     */
    protected function getHandlerFileName($commandName)
    {
        return $commandName . 'Handler.php';
    }

    /**
     * @param string $commandName
     *
     * @return mixed
     */
    protected function getValidatorFileName($commandName)
    {
        return $commandName . 'Validator.php';
    }

    /**
     * @param string $fileType
     * @param array  $viewData
     *
     * @return string|false
     */
    protected function makeFile($fileType, array $viewData)
    {
        $commandFileContent = $this->viewFactory->make("stubs.{$fileType}", $viewData)->render();

        // Write to file
        $commandDir = $this->getDirFor($fileType);

        if (! $this->file->exists($commandDir)) {
            $this->file->makeDirectory($commandDir);
        }

        $commandFile = $this->{'get' . ucfirst(camel_case($fileType)) . 'FileName'}($viewData['commandName']);
        $commandPath = $commandDir . '/' . $commandFile;

        if ($this->file->put($commandPath, $commandFileContent)) {
            return $commandPath;
        }

        return false;
    }

    /**
     * @param string $properties
     */
    protected function parseProperties($properties)
    {
        $properties = explode('&', $properties);

        foreach ($properties as $property) {
            $segments = explode(':', $property);
            $propertyName = trim(array_shift($segments));
            $propertyType = trim(array_shift($segments));
            $propertyRules = $segments ? trim(implode(':', $segments)) : null;

            $this->addProperty($propertyName, $propertyType, $propertyRules);
        }
    }
}
