{{ $extra['openTag'] }}

namespace {{ $validatorNamespace }};

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
                '{{ $property['name'] }}' => '{{ $property['rules'] }}',
            @endif
            @endforeach
        ];
    }
}
