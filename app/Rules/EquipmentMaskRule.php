<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

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
     * @var Validator
     */
    protected Validator $validator;

    /**
     * @param $validator
     * @return $this|EquipmentMaskRule
     */
    public function setValidator($validator): EquipmentMaskRule|static
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

    /**
     * @param string $value
     * @param string $mask
     * @return bool
     */
    public function validateCustom(string $value, string $mask): bool
    {
        //if not equal length
        if (strlen($value) !== strlen($mask)) {
            return false;
        }

        return $this->parse($value, $mask);
    }

    /**
     * @param string $value
     * @param string $mask
     * @return bool
     */
    protected function parse(string $value, string $mask): bool
    {
        for ($i = 0; $i < strlen($mask); $i++) {
            if (!$this->has($mask[$i], $value[$i])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $mask
     * @param string $char
     * @return bool
     */
    protected function has(string $mask, string $char): bool
    {
        if ($pattern = $this->rules[$mask] ?? false) {
            preg_match_all($pattern, $char, $matches);

            return count($matches[0] ?? []) === 1;
        }

        return false;
    }
}
