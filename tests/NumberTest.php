<?php
/**
 * File NumberTest.php DESCRIPTION
 *
 * @version $Id:$
 * @author Charlie McClung <cmcclung@imm.com>
 */

require_once 'PHPUnit/Framework.php';
require_once '../Number.inc';

class NumberTest extends PHPUnit_Framework_TestCase {
    public function getNumber($strNum = 'deadbeef', $intBase = 16) {
        return new Number($strNum, $intBase);
    }

    public function testBase2isBinary() {
        $objNum = $this->getNumber();
        $this->assertEquals($objNum->convertToBase(2), $objNum->convertToBinary());
    }

    public function testBase8isOctal() {
        $objNum = $this->getNumber();
        $this->assertEquals($objNum->convertToBase(8), $objNum->convertToOctal());
    }

    public function testBase10isDecimal() {
        $objNum = $this->getNumber();
        $this->assertEquals($objNum->convertToBase(10), $objNum->convertToDecimal());
    }

    public function testBase16isHex() {
        $objNum = $this->getNumber();
        $this->assertEquals($objNum->convertToBase(16), $objNum->convertToHex());
    }

    public function testMultipleConversionsReturnToOriginal() {
        $strNum  = 'deadbeef';

        $objNum1 = $this->getNumber($strNum, 16);
        $intNum  = $objNum1->convertToDecimal();

        $objNum2 = $this->getNumber((string)$intNum, 10);
        $octNum  = $objNum2->convertToOctal();

        $objNum3 = $this->getNumber((string)$octNum, 8);
        $binNum  = $objNum3->convertToBinary();

        $objNum4 = $this->getNumber((string)$binNum, 2);
        $origNum = $objNum4->convertToHex();

        $this->assertEquals($strNum, strtolower($origNum));
    }

    /**
     * @expectedException Exception
     */
    public function testBadConstructorArgs() {
        $objNum = $this->getNumber(123, 'test');
    }

    /**
     * @expectedException Exception
     */
    public function testBadConstructorBaseLow() {
        $objNum = $this->getNumber('12345', 0);
    }

    /**
     * @expectedException Exception
     */
    public function testBadConstructorBaseHigh() {
        $objNum = $this->getNumber('12345', 37);
    }

    /**
     * @expectedException Exception
     */
    public function testBadConvertBaseLow() {
        $objNum = $this->getNumber();
        $objNum->convertToBase(0);
    }

    /**
     * @expectedException Exception
     */
    public function testBadConvertBaseHigh() {
        $objNum = $this->getNumber();
        $objNum->convertToBase(37);
    }

    /**
     * @expectedException Exception
     */
    public function testBadCharacter() {
        $objNum = $this->getNumber('12345', 4);
    }

    /**
     * @expectedException Exception
     */
    public function testNegativeNotAllowedYet() {
        $objNum = $this->getNumber('-12');
    }
}
