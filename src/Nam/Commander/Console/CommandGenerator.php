<?php


namespace Nam\Commander\Console;

use Illuminate\Filesystem\Filesystem;
use Mustache_Engine;


/**
 * Class CommandGenerator
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Console
 *
 */
class CommandGenerator
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mustache_Engine
     */
    private $mustache;

    /**
     * @param Filesystem      $filesystem
     * @param Mustache_Engine $mustache
     */
    public function __construct(Filesystem $filesystem, Mustache_Engine $mustache)
    {
        $this->filesystem = $filesystem;
        $this->mustache = $mustache;
    }

    /**
     * @param CommandInput $input
     * @param string       $template
     * @param string       $destination
     */
    public function make(CommandInput $input, $template, $destination)
    {
        $template = $this->filesystem->get($template);

        $stub = $this->mustache->render($template, $input);

        $this->filesystem->put($destination, $stub);
    }
}