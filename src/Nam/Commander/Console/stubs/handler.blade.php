{{ $extra['openTag'] }}

namespace {{ $handlerNamespace }};

use {{ $commandNamespace }}\{{ $commandName }};
use Nam\Commander\BaseCommandHandler;

/**
 * Handler {{ $commandName }}
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $handlerNamespace }}
 *
 */
class {{ $commandName }}Handler extends BaseCommandHandler
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
