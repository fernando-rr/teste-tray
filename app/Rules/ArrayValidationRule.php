<?php

namespace App\Rules;

use App\Helpers\ArrayHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

abstract class ArrayValidationRule implements ValidationRule
{
    /**
     * Array com regras de validação à serem aplicadas
     *
     * @return string[]
     */
    abstract protected function getRules(): array;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(ArrayHelper::isAssoc($value))
            throw new \InvalidArgumentException('Only arrays accepted');

        // Adiciona os erros de validação
        foreach ($value as $item) {
            $this->validateData($item, $fail);
        }
    }

    /**
     * Efetua a validação dos dados
     *
     * @param $data
     * @param Closure $fail
     */
    private function validateData($data, Closure &$fail)
    {
        $validator = Validator::make($data, $this->getRules());

        if($validator->fails())
            $fail($validator->errors()->all());
    }
}
