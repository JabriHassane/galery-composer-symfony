<?php


namespace App\Service;


class PasswordGenerator
{
    public function generateRandomStrongPassword(int $nbrChar): String
    {
        $uppercaseLetters = $this->generateCharactersWithCharCodeRange([65, 90]);
        $lowercaseLetters = $this->generateCharactersWithCharCodeRange([97, 122]);
        $numbers = $this->generateCharactersWithCharCodeRange([48, 57]);
        $symbols = $this->generateCharactersWithCharCodeRange([33, 47, 58, 64, 91, 96, 123, 126]);

        $allCharacters = array_merge($symbols, $numbers,$lowercaseLetters, $uppercaseLetters);

        $isArrayShuffled = shuffle($allCharacters);
        $passwordArray = array_slice($allCharacters, 0, $nbrChar);
        return implode('', $passwordArray);
    }

    private  function generateCharactersWithCharCodeRange(array $range):array
    {
        if (count($range) == 2){
            return range(chr($range[0]), chr($range[1]));
        }else{
            return array_merge(...array_map(fn($range)=>range(chr($range[0]), chr($range[1])), array_chunk($range, 2)));
        }
    }
}