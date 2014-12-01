{{ $extra['openTag'] }}

namespace {{ $handlerNamespace }};

use {{ $commandNamespace }}\{{ $commandName }};
use Nam\Commander\CommandHandler;

/**
 * Handler {{ $commandName }}
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $handlerNamespace }}
 *
 */
class {{ $commandName }}Handler implements CommandHandler
{

    /**
     * {{ $extra['@'] }}param {{ $commandName }} $command
     *
     * {{ $extra['@'] }}return mixed
     */
    public function handle($command)
    {
        //
    }
}
