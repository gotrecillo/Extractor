<?php
use Gotrecillo\Extractor\Extractor;

class ExtractorTest extends \PHPUnit\Framework\TestCase {

    public function setUp()
    {
        $this->extractor = new Gotrecillo\Extractor\Extractor();
    }

    public function testEmptyArrayProvided()
    {
        $original = [];
        $expected = [];
        $actual = $this->extractor->prepareExtraction($original);

        $this->assertEquals($expected, $actual, "An empty array should be returned when an empty array is provided");

        // We modify the expected array to check if the actual array is changed
        array_push($actual, 'foo');

        $this->assertCount(0, $original, "Reference should point to a new array");
    }

    public function testArrayOnlyHasTheProviedKeyNAmes()
    {
        $expected = ["foo" => "foo", "bar" => "bar"];
        $actual = $this->extractor->prepareExtraction(["foo" => "foo", "bar" => "bar"], "foo", "bar");

        $this->assertEquals($expected, $actual, "A clone of the array should be returned when all the keys provided are in the original array");
    }

    public function testArrayHasMoreThanTheProviedKeyNAmes()
    {
        $expected = ["foo" => "foo", "bar" => "bar"];
        $actual = $this->extractor->prepareExtraction(["foo" => "foo", "bar" => "bar", "baz" => "baz"], "foo", "bar");

        $this->assertEquals($expected, $actual, "An array with only the specified keys should be returned");
    }

    public function testArrayDoesNotHaveAllTheProvidedKeyNames(){
        $this->expectException(\Gotrecillo\Extractor\ArrayKeyNotFoundException::class);

        $this->extractor->prepareExtraction([], 'foo');
    }

}