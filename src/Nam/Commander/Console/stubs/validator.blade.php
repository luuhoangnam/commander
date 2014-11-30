{{ $extra['openTag'] }}

namespace {{ $validatorNamespace }};

use {{ $commandNamespace }}\{{ $commandName }};
use Nam\Commander\BaseCommandValidator;

/**
 * Validator {{ $commandName }}Validator
 *
 * {{ $extra['@'] }}author  {{ $author['name'] }} <{{ $author['email'] }}>
 * {{ $extra['@'] }}package {{ $validatorNamespace }}
 *
 */
class {{ $commandName }}Validator extends BaseCommandValidator
{
    /**
     * {{ $extra['@'] }}return array
     */
    public function rules()
    {
        return [
            @foreach($properties as $property)
            @if($property['rules'])
                '{{ $property['name'] }}' => $command->{{ camel_case("get {$property['name']}") }}(),
            @endif
            @endforeach
        ];
    }
}
