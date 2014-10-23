<?php


namespace Nam\Commander\Console;


/**
 * Class CommandInputParser
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Console
 *
 */
class CommandInputParser
{
    /**
     * @param string $path
     * @param string $properties
     *
     * @return CommandInput
     */
    public function parse($path, $properties)
    {
        $segments = explode('\\', str_replace('/', '\\', $path)); // todo check invalid path

        $name = array_pop($segments);

        // Handle for "Handlers" namespace
        if (strpos($name, 'Handler') === strlen($name) - 7) {
            $segments[] = 'Handlers';
        }

        $namespace = implode('\\', $segments);

        $properties = $this->parseProperties($properties);

        return new CommandInput($name, $namespace, $properties);
    }

    /**
     * Parse the properties for a command.
     *
     * @param $properties
     *
     * @return array
     */
    private function parseProperties($properties)
    {
        return preg_split('/ ?, ?/', $properties, null, PREG_SPLIT_NO_EMPTY);
    }
}