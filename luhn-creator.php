<?php

function createLuhnCheckedRandomString($length)
{
    $rand_id = "";
    if ($length > 0) {
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double) microtime() * 1000000);
            $num = mt_rand(1, 36);

            switch ($num) {
                case "1":
                    $rand_value = "a";
                    break;
                case "2":
                    $rand_value = "b";
                    break;
                case "3":
                    $rand_value = "c";
                    break;
                case "4":
                    $rand_value = "d";
                    break;
                case "5":
                    $rand_value = "e";
                    break;
                case "6":
                    $rand_value = "f";
                    break;
                case "7":
                    $rand_value = "g";
                    break;
                case "8":
                    $rand_value = "h";
                    break;
                case "9":
                    $rand_value = "i";
                    break;
                case "10":
                    $rand_value = "j";
                    break;
                case "11":
                    $rand_value = "k";
                    break;
                case "12":
                    $rand_value = "l";
                    break;
                case "13":
                    $rand_value = "m";
                    break;
                case "14":
                    $rand_value = "n";
                    break;
                case "15":
                    $rand_value = "o";
                    break;
                case "16":
                    $rand_value = "p";
                    break;
                case "17":
                    $rand_value = "q";
                    break;
                case "18":
                    $rand_value = "r";
                    break;
                case "19":
                    $rand_value = "s";
                    break;
                case "20":
                    $rand_value = "t";
                    break;
                case "21":
                    $rand_value = "u";
                    break;
                case "22":
                    $rand_value = "v";
                    break;
                case "23":
                    $rand_value = "w";
                    break;
                case "24":
                    $rand_value = "x";
                    break;
                case "25":
                    $rand_value = "y";
                    break;
                case "26":
                    $rand_value = "z";
                    break;
                case "27":
                    $rand_value = "0";
                    break;
                case "28":
                    $rand_value = "1";
                    break;
                case "29":
                    $rand_value = "2";
                    break;
                case "30":
                    $rand_value = "3";
                    break;
                case "31":
                    $rand_value = "4";
                    break;
                case "32":
                    $rand_value = "5";
                    break;
                case "33":
                    $rand_value = "6";
                    break;
                case "34":
                    $rand_value = "7";
                    break;
                case "35":
                    $rand_value = "8";
                    break;
                case "36":
                    $rand_value = "9";
                    break;
            }

            $rand_id .= $rand_value;
        }
        $sum = 0;
        $minuscheck = strtoupper($rand_id);
        $string = strrev($minuscheck); //Turn the string around so that $x has meaning.
        for ($x = 0; $x < strlen($string); $x++) {
            $char = str_replace(range('A', 'Z'), range('10', '35'), $string[$x]);
            $sum += array_sum(str_split(($char * pow(2, (($x + 1) % 2)))));
        }
        $cddec = ($sum * 35) % 36;
        $cd = strtoupper(str_replace(range('10', '35'), range('A', 'Z'), ($sum * 35) % 36));
        return $minuscheck . $cd;
    }
}


// usage
// createLuhnCheckedRandomString($length);
