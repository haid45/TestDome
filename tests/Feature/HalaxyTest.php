<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HalaxyTest extends TestCase
{

    /**
     * @param array $array
     * @return array
     */
    function prependSum(array $array) : array
    {
        $sum = array_sum($array);
        array_unshift($array, $sum);

        return $array;
    }

    /**
     * @param array $array
     * @param $value
     * @return false|int|string
     */
    function findLastKey(array $array, $value)
    {
        $reversed = array_reverse($array, true);

        return array_search($value,$reversed);
    }

    /**
     * @param $number
     * @return string
     */
    function getLetter($number) : string
    {
        $alphas = range('A', 'Z');
        $array = [];
        foreach ($alphas as $alpha)
        {
            $array[] = $alpha;
        }
        $array = array_combine(range(1, count($array)), array_values($array));
        if (array_key_exists($number, $array))
            return $array[$number];
        return '';
    }

    /**
     * @param string $string
     * @return string
     */
    function numbersToLetters(string $string) : string
    {
        $sentence = [];
        $words = explode("+", $string);

        foreach ($words as $key => $word){
            $numbers = explode(" ", $word);
            foreach ($numbers as $number){
                $sentence[] = $this->getLetter($number);
            }
            if ($key !== array_key_last($words)) {
                $sentence[] = " ";
            }
        }

        return implode($sentence);
    }

    public function test_prepend_sum()
    {
        $prependSum = $this->prependSum([1,2,3]);
        $this->assertTrue($prependSum == [6,1,2,3]);
        $this->assertFalse($prependSum == [1,2,3]);
        $this->assertFalse($prependSum == [6]);
    }

    public function test_find_last_key()
    {
        $findLastKey = $this->findLastKey(['world'=>'blue','new'=>'blue'],'blue');
        $this->assertTrue($findLastKey == 'new');
        $this->assertFalse($findLastKey == 'world');
    }

    public function test_numbers_to_letters()
    {
        $numbersToLetters = $this->numbersToLetters('20 5 19 20+4 15 13 5');
        $this->assertTrue($numbersToLetters == 'TEST DOME');
        $this->assertFalse($numbersToLetters == 'TESTDOME');
        $this->assertFalse($numbersToLetters == 'TEST DOME ');
    }
}
