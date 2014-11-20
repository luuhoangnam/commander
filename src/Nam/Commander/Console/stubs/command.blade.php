{{ $extra['openTag'] }}

namespace {{ $commandNamespace }};

use Nam\Commander\BaseCommand;

/**
 * Command {{ $commandName }}
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $commandNamespace }}
 *
 */
class {{ $commandName }} extends BaseCommand
{{ '{' }}
@foreach($properties as $property)

    private ${{ $property['name'] }};

    /**
     * {{ $extra['@'] }}return {{ $property['type'] }}
     */
    public function {{ camel_case("get {$property['name']}") }}()
    {{ '{' }}
        return $this->{{ $property['name'] }};
    {{ '}' }}
@endforeach

    /**
@foreach($properties as $property)
     * {{ $extra['@'] }}param {{ $property['type'] }} ${{ $property['name'] }}
@endforeach
     */
    public function __construct(@foreach($properties as $index => $property)@if($index),@endif @if($property['type'] === 'array')array @endif${{ $property['name'] }} @endforeach{{ ')' }}
    {{ '{' }}
@foreach($properties as $property)
        $this->{{ $property['name'] }} = ${{ $property['name'] }};
@endforeach
    {{ '}' }}
{{ '}' }}
