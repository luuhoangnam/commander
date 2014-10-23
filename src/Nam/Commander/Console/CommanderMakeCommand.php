<?php

namespace Nam\Commander\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CommanderMake
 * @package Mbibi\Core\Console
 */
class CommanderMakeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'commander:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new command and its handler class.';
    /**
     * @var CommandInputParser
     */
    private $parser;
    /**
     * @var CommandGenerator
     */
    private $generator;

    /**
     * Create a new command instance.
     *
     * @param CommandInputParser $parser
     * @param CommandGenerator   $generator
     *
     * @return CommanderMakeCommand
     */
    public function __construct(CommandInputParser $parser, CommandGenerator $generator)
    {
        $this->parser = $parser;
        $this->generator = $generator;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $path = $this->argument('path');
        $properties = $this->option('properties');
        $base = $this->option('base');

        // Parse the command input.
        $commandInput = $this->parser->parse($path, $properties);
        $handlerInput = $this->parser->parse("{$path}Handler", $properties);

        // Actually create the files with the correct boilerplate.
        $this->generator->make(
            $commandInput,
            __DIR__ . '/stubs/command.stub',
            "{$base}/{$path}.php"
        );

        $handlerPath = str_replace('\\', '/', $handlerInput->namespace) . '/' . $handlerInput->name;

        $this->generator->make(
            $handlerInput,
            __DIR__ . '/stubs/handler.stub',
            "{$base}/{$handlerPath}.php"
        );

        $this->info('All done! Your two classes have now been generated.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'path',
                InputArgument::REQUIRED,
                'The class path to Commands namespace: the Commands will be placed in this namespace, the Handlers will be placed in Commands\Handlers namespace'
            ],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $config = \App::make('config')->get('commander::artisan');

        return [
            [
                'properties',
                null,
                InputOption::VALUE_OPTIONAL,
                'A comma-separated list of properties for the command.',
                null
            ],
            [
                'base',
                null,
                InputOption::VALUE_OPTIONAL,
                'The path to where your domain root is located.',
                $config['base']
            ]
        ];
    }

}
