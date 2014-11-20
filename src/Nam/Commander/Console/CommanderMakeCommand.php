<?php

namespace Nam\Commander\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CommanderMake
 *
 * Type 1: Only specify commandName ~> Guest base path & command,validator,handler paths
 * commander:make RegisterUserCommand
 *
 * Type 2: Specify commandName & base path ~> Guest command,validator,handler paths by conventions
 * commander:make RegisterUserCommand --base="app/Mbear/Core"
 *
 * Type 3: Specify commandName, base path & only one of types command,handler,validator relatively to base path
 *         ~> Guest the rest of paths by conventions relatively to base path and the path that specified.
 * commander:make RegisterUserCommand --base="app/Mbear/Core" --commandPath="Commands"
 * commander:make RegisterUserCommand --base="app/Mbear/Core" --commandPath="Handlers"
 * commander:make RegisterUserCommand --base="app/Mbear/Core" --commandPath="Validators"
 *
 * Type 4: Specify commandName, basePath & two of types command, handler, validator paths
 * commander:make RegisterUserCommand --base="app/Mbear/Core" --commandPath="Commands" --handlerPath="Handlers"
 * ...
 *
 * Type 5: Additional specify namespace
 * commander:make RegisterUserCommand --namespace="Mbear\Core"
 *
 * Type 6: Specify Properties
 * commander:make RegisterUserCommand -p="email:string:required|email|between:6,32 & password:string:required\confirmed"
 *
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
     * Execute the console command.
     */
    public function fire()
    {
        $commandName = $this->argument('commandName');
        $basePath = $this->option('base');
        $group = $this->option('group');
        $commandPath = $this->option('commandPath');
        $rootNamespace = $this->option('rootNamespace');
        $properties = $this->option('properties');

        try {
            \View::addLocation(__DIR__);

            /** @var \Nam\Commander\Console\Generator $generator */
            $generator = \App::make('Nam\Commander\Console\Generator');
            $generator->setBasePath($basePath);
            $generator->setGroup($group);
            $generator->setCommandPath($commandPath);
            $generator->setRootNamespace($rootNamespace);
            $successFiles = $generator->make($commandName, $properties);
        } catch ( \Exception $e ) {
            if (\Config::get('app.debug')) {
                throw $e;
            }

            \Log::error($e->getMessage(), $e->getTrace());
            $this->error("Error occurred! Logged.");
            return;
        }

        $this->info('All done! Your classes have now been generated.');
        array_map(function ($file) {
            $this->info($file);
        }, $successFiles);

        return;
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
                'commandName',
                InputArgument::REQUIRED,
                'Name of command'
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
                'base',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                $config['base']
            ],
            [
                'group',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                null
            ],
            [
                'commandPath',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                $config['commandPath']
            ],
            [
                'handlerPath',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                $config['handlerPath']
            ],
            [
                'validatorPath',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                $config['validatorPath']
            ],
            [
                'rootNamespace',
                null,
                InputOption::VALUE_REQUIRED,
                'The path to where your domain root is located.',
                $config['rootNamespace']
            ],
            [
                'properties',
                null,
                InputOption::VALUE_OPTIONAL,
                'The path to where your domain root is located.',
                null
            ],
        ];
    }
}
