<?php
/**
 * File calc.php DESCRIPTION
 *
 * @version $Id:$
 * @author Charlie McClung <cmcclung@imm.com>
 */

require_once 'Number.inc';

/*
$test = new Number('111');

echo "Binary: ";
echo $test->convertToBinary();

echo "\nOctal: ";
echo $test->convertToOctal();

echo "\nHex: ";
echo $test->convertToHex();

echo "\nDecimal: ";
echo $test->convertToDecimal();


*/

echo 'Please enter a number base (default=10): ';

$strBase   = trim(fgets(STDIN));

if (empty($strBase)) {
    echo "Using 10 as default number system base (decimal)\n";
    $strBase = 10;
}

echo "Please enter a number represented in base-{$strBase}: ";

$strInput  = trim(fgets(STDIN));

echo "Please enter the base or base range (#-#) to convert {$strInput} to (default=2-36 [all bases]): ";

$strTarget = trim(fgets(STDIN));

if (empty($strTarget)) {
    $strTarget = '2-36';
}

if (strpos($strTarget, '-') !== false) {
    $arrRange = explode('-', $strTarget);

    if (count($arrRange) != 2) {
        die ("Target base range must be format: int-int!\n");
    } else {
        $intStart = $arrRange[0];
        $intEnd   = $arrRange[1];

        $strRange = $intStart . ' - ' . $intEnd;
    }
} elseif (is_numeric($strTarget)) {
    $strRange = $intStart = $intEnd = $strTarget;
} else {
    die ("Invalid base range! [Valid Max => (2-36)]\n");
}

echo "\nProcessing base-{$strBase} number: {$strInput}\n";
echo "Converting to base range: {$strRange}\n\n";

try {
    for ($i=$intStart; $i<=$intEnd; $i++) {
        $objNum = new Number($strInput, $strBase);
        $strNum = $objNum->convertToBase($i);

        echo "Base-{$i} ==> {$strNum}\n";
        unset($objNum);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "\n";

/*
$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

//echo 'Please enter a binary number: ';
//
//$binary = trim(fgets(STDIN));
//
////$binary = '1001011'; //75
//$value  = 0;
//$base   = 11;
//$range  = strlen($binary) - 1;
//
//for ($i=$range; $i>=0; $i--) {
//    if ($binary[$i] > '0' || $binary[$i] < $base) {
//        $place  = $range - $i;
//        $bitSet = $binary[$i];
//        $posVal = pow($base, $place) * $bitSet;
//        $value += $posVal;
//        echo "{$binary[$i]} ==> {$posVal}  ({$base}^{$place})\n";
//    } else {
//        die("Invalid binary number provided\n");
//    }
//}
//
//echo "\n\nBinary: {$binary} == {$value}\n\n\n";

echo 'Enter a decimal number: ';

$decimal = trim(fgets(STDIN));

if (is_numeric($decimal)) {
    echo "Processing: $decimal...\n\n";

    for ($base=1; $base<=36; $base++) {
        $num = $decimal;

        $ret = '';

        if ($base > 1) {
            $max = floor(log($decimal, $base));
        } else {
            $max = $num-1;
        }


        for($i=$max; $i>=0; $i--) {
            if ($base > 1) {
                $pow = pow($base, $i);
            } else {
                $pow = $num;
            }

            $div = $num / $pow;

            if ($div >= 1) {
                if ($base > 1)
                    $num -= $pow * floor($div);
                else
                    $num -= floor($div);
            }

            $val = (int) floor($div);

            if ($val > 9) {
                $val = $alphabet[$val-10];
            }

            $ret .= $val;
        }

        echo "Base-{$base} = {$ret}\n";

//        echo "\n{$decimal} (decimal) == {$ret} (base-{$base})\n";
    }
}
*/