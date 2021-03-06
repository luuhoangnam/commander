{{ $extra['openTag'] }}

namespace {{ $commandNamespace }};

/**
 * Command {{ $commandName }}
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $commandNamespace }}
 *
 */
class {{ $commandName }}
{{ '{' }}
@foreach($properties as $property)

    /**
     * {{ $extra['@'] }}var {{ $property['type'] ?: '' }}
     */
    public ${{ $property['name'] }};
@endforeach

    /**
@foreach($properties as $property)
     * {{ $extra['@'] }}param {{ $property['type'] ?: '' }} ${{ $property['name'] }}
@endforeach
     */
    public function __construct(@foreach($properties as $index => $property)@if($index),@endif @if($property['type'] === 'array')array @endif${{ $property['name'] }} @endforeach{{ ')' }}
    {{ '{' }}
@foreach($properties as $property)
        $this->{{ $property['name'] }} = ${{ $property['name'] }};
@endforeach
    {{ '}' }}
{{ '}' }}
