{{ $extra['openTag'] }}

namespace {{ $validatorNamespace }};

use {{ $commandNamespace }}\{{ $commandName }};
use Nam\Commander\BaseCommand;
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

    protected $rules = [
@foreach($properties as $property)
@if($property['rules'])
        '{{ $property['name'] }}' => '{{ $property['rules'] }}',
@endif
@endforeach
    ];

    /**
     * {{ $extra['@'] }}param {{ $commandName }}|BaseCommand $command
     *
     * {{ $extra['@'] }}return mixed
     */
    public function validate(BaseCommand $command)
    {
        $this->setData([
@foreach($properties as $property)
@if($property['rules'])
            '{{ $property['name'] }}' => $command->{{ camel_case("get {$property['name']}") }}(),
@endif
@endforeach
        ]);

        return $this->internalValidation();
    }
}
