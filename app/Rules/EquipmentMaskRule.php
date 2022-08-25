<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;

class EquipmentMaskRule implements InvokableRule, ValidatorAwareRule
{

    protected array $rules = [
        'X' => '/^([a-z0-9])$/',
        'A' => '/^([A-Z])$/',
        'a' => '/^([a-z])$/',
        'N' => '/^([0-9])$/',
        'Z' => '/^([-_@])$/',
    ];
    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Set the current validator.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Create a new rule instance.
     *
     * @param $attribute
     * @param $value
     * @param $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        $type_id = $this->validator->getData()[0]['type_id'];
        $et = EquipmentType::findOrFail($type_id)->first();

        if (!$this->validateCustom($value, $et->mask_sn)) {
            $fail('Mask validation error.');
        }
    }


    public function validateCustom(string $value, string $mask): bool
    {
        //if not equal length
        if (strlen($value) !== strlen($mask)) {
            return false;
        }

        return $this->parse($value, $mask);
    }

    protected function parse(string $value, string $mask): bool
    {
        for ($i = 0; $i < strlen($mask); $i++) {
            if (! $this->has($mask[$i], $value[$i])) {
                return false;
            }
        }

        return true;
    }

    protected function has(string $mask, string $char): bool
    {
        if ($pattern = $this->rules[$mask] ?? false) {
            preg_match_all($pattern, $char, $matches);

            return count($matches[0] ?? []) === 1;
        }

        return false;
    }

//    /**
//     * Determine if the validation rule passes.
//     *
//     * @param  string  $attribute
//     * @param  mixed  $value
//     * @return bool
//     */
//    public function passes($attribute, $value)
//    {
//        $index = explode('.', $attribute)[1];
//        $et = EquipmentType::findOrFail($index)->first();
//
//        return $this->validateCustom($value, $et->mask_sn);
//    }
//
//    /**
//     * Get the validation error message.
//     *
//     * @return string
//     */
//    public function message()
//    {
//        return 'Mask validation error.';
//    }
}
