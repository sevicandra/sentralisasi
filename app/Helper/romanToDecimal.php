<?php

namespace App\Helper;

class romanToDecimal
{
    public static function convert($roman)
    {
        // Mappings of Roman numerals to their respective values
        $romanNumerals = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000
        ];

        $decimal = 0;
        $previousValue = 0;

        // Convert the Roman numeral to uppercase to handle lowercase input
        $roman = strtoupper($roman);

        // Iterate over each character in the Roman numeral from right to left
        for ($i = strlen($roman) - 1; $i >= 0; $i--) {
            $currentValue = $romanNumerals[$roman[$i]];

            // If the current value is less than the previous value, subtract it
            if ($currentValue < $previousValue) {
                $decimal -= $currentValue;
            } else {
                // Otherwise, add it
                $decimal += $currentValue;
            }

            // Update previous value to current value
            $previousValue = $currentValue;
        }

        return $decimal;
    }
}
