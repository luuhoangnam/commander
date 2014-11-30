{{ $extra['openTag'] }}

namespace {{ $handlerNamespace }};

use {{ $commandNamespace }}\{{ $commandName }};

/**
 * Handler {{ $commandName }}
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $handlerNamespace }}
 *
 */
class {{ $commandName }}Handler
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
