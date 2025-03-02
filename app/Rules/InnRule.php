<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use InvalidArgumentException;
use Closure;
class InnRule implements ValidationRule
{
    public const CODE_INVALID_LENGTH   = 1;
    public const CODE_NOT_ONLY_DIGITS  = 2;
    public const CODE_INVALID_CHECKSUM = 3;

    public static string $messageInvalidLength   = 'ИНН должен иметь длину 10 (юрлицо) или 12 (физлицо) символов';
    public static string $messageOnlyDigits      = 'ИНН должен состоять только из цифр';
    public static string $messageInvalidChecksum = 'ИНН недействителен (неверная контрольная сумма)';
    public static string $messageInvalidDigitSum = 'Контрольная сумма не может ровняться 0';


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (!self::check($value)) {
                $fail('Поле :attribute содержит некорректный ИНН.');
            }
        } catch (\Exception $e) {
            $fail($e->getMessage());
        }
    }

    /**
     * Проверяет ИНН на валидность по последней (для Физлиц) или двум последним (для Юрлиц) символам
     *
     * @param string $inn
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    private static function check(string $inn): bool
    {
        $innSymbols = str_split($inn);
        $innLength  = mb_strlen($inn);
        if ($innLength === 10) {
            self::checkInnSymbols($inn, $innLength);
            self::checkChecksum($innSymbols, 9);
        } else if ($innLength === 12) {
            self::checkInnSymbols($inn, $innLength);
            self::checkChecksum($innSymbols, 10);
            self::checkChecksum($innSymbols, 11);
        } else {
            throw new InvalidArgumentException(self::$messageInvalidLength, self::CODE_INVALID_LENGTH);
        }

        if(array_sum(str_split($inn)) == 0) {
            throw new  InvalidArgumentException(self::$messageInvalidDigitSum, self::CODE_INVALID_LENGTH);
        }


        return true;
    }

    /**
     * @param array $innSymbols
     * @param int   $checkInnIndex
     *
     * @return void
     */
    private static function checkChecksum(array $innSymbols, int $checkInnIndex): void
    {
        $checksum = 0;
        $offset = 11 - $checkInnIndex;
        $coefficients = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
        for ($innIndex = 0; isset($coefficients[$innIndex + $offset]); $innIndex++) {
            $checksum += (int)$innSymbols[$innIndex] * $coefficients[$innIndex + $offset];
        }
        if ((int)$innSymbols[$checkInnIndex] !== $checksum % 11 % 10) {
            throw new InvalidArgumentException(self::$messageInvalidChecksum, self::CODE_INVALID_CHECKSUM);
        }
    }

    /**
     * @param string $inn
     * @param int    $innLength
     *
     * @return void
     */
    private static function checkInnSymbols(string $inn, int $innLength): void
    {
        for ($innIndex = 0; $innIndex < $innLength; $innIndex++) {
            if (!is_numeric($inn[$innIndex])) {
                throw new InvalidArgumentException(self::$messageOnlyDigits, self::CODE_NOT_ONLY_DIGITS);
            }
        }
    }
}
