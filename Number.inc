<?php
/**
 * File Number.inc DESCRIPTION
 *
 * @version $Id:$
 * @author Charlie McClung <cmcclung@imm.com>
 */

class Number {
    private $strAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private $strValue;
    private $intBase;

    public function __construct($mixValue, $intBase = 10) {
        if (is_string($mixValue) && is_numeric($intBase)) {
            $this->intBase  = $intBase;
            $this->strValue = $mixValue;
            $this->validate();
        } else {
            throw new Exception("Expecting a string-numeric value pair for new number-base.");
        }
    }

    private function validate() {
        if ($this->intBase < 2 || $this->intBase > 36) {
            throw new Exception("Base '{$this->intBase}' in an invalid number base system!");
        }

        if ($this->strValue < 0) {
            throw new Exception("Only supporting positive numbers ATM...");
        }

        for ($i=0; $i<strlen($this->strValue); $i++) {
            if ($this->getAlphaNumeric($this->strValue[$i]) >= $this->intBase) {
                throw new Exception("Character '{$this->strValue[$i]}' is invalid within a base-{$this->intBase} number system!");
            }
        }
    }

    private function isDecimal() {
        return $this->intBase == 10;
    }

    private function getAlphaNumeric($strChar) {
        if (is_numeric($strChar)) {
            return (int) $strChar;
        } else {
            $strChar = strtoupper($strChar);

            for ($i=0; $i<strlen($this->strAlphabet); $i++) {
                if ($strChar == $this->strAlphabet[$i]) {
                    return $i + 10;
                }
            }

            return 0;
        }
    }

    public function convertToDecimal() {
        $intValue  = 0;
        $intRange  = strlen($this->strValue) - 1;

        for ($i=$intRange; $i>=0; $i--) {
            $intPlace  = $intRange - $i;
            $strChar   = $this->strValue[$i];

            $intChar = $this->getAlphaNumeric($strChar);

            $intPosVal = pow($this->intBase, $intPlace) * $intChar;
            $intValue += $intPosVal;
        }

        return $intValue;
    }

    public function convertToBinary() {
        return $this->convertToBase(2);
    }

    public function convertToOctal() {
        return $this->convertToBase(8);
    }
    
    public function convertToHex() {
        return $this->convertToBase(16);
    }
    
    public function convertToBase($intBase) {
        if ($intBase < 2 || $intBase > 36) {
            throw new Exception("Base '{$intBase}' in an invalid number base system!");
        }
        if ($this->isDecimal()) {
            $intNum = (int) $this->strValue;
        } else {
            $intNum = $this->convertToDecimal();
        }

        $strRet = '';

        $intMax = floor(log($intNum, $intBase));

        for($i=$intMax; $i>=0; $i--) {
            $intPow = pow($intBase, $i);

            $fltDiv = $intNum / $intPow;

            if ($fltDiv >= 1) {
                $intNum -= $intPow * floor($fltDiv);
            }

            $intVal = (int) floor($fltDiv);

            if ($intVal > 9) {
                $intVal = $this->strAlphabet[$intVal-10];
            }

            $strRet .= $intVal;
        }

        return $strRet;
    }
}