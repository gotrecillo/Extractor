<?php
use Gotrecillo\Extractor\ArrayKeyNotFoundException;
use Gotrecillo\Extractor\Extractor;

class ExtractorTest extends \PHPUnit\Framework\TestCase {

    public function setUp()
    {
        $this->extractor = new Extractor();
    }

    /** @test */
    public function it_should_return_an_empty_array_when_an_empty_array_is_provided()
    {
        $original = [];
        $expected = [];
        $actual = $this->extractor->prepareExtraction($original);

        $this->assertEquals($expected, $actual, "An empty array should be returned when an empty array is provided");

        // We modify the expected array to check if the actual array is changed
        array_push($actual, "foo");

        $this->assertCount(0, $original, "Reference should point to a new array");
    }

    /** @test */
    public function it_should_return_a_copy_of_the_array_when_provided_array_has_all_the_names_provided_as_keys_but_no_more()
    {
        $expected = ["foo" => "foo", "bar" => "bar"];
        $actual = $this->extractor->prepareExtraction(["foo" => "foo", "bar" => "bar"], "foo", "bar");

        $this->assertEquals($expected, $actual, "A clone of the array should be returned when all the keys provided are in the original array");
    }

    /** @test */
    public function it_should_return_an_array_with_only_the_specified_names_if_provided_array_have_more_keys()
    {
        $expected = ["foo" => "foo", "bar" => "bar"];
        $actual = $this->extractor->prepareExtraction(["foo" => "foo", "bar" => "bar", "baz" => "baz"], "foo", "bar");

        $this->assertEquals($expected, $actual, "An array with only the specified keys should be returned");
    }

    /** @test */
    public function it_should_throw_an_exception_when_a_provided_name_is_not_found_in_the_provided_array_keys()
    {
        $this->expectException(ArrayKeyNotFoundException::class);

        $this->extractor->prepareExtraction([], "foo");
    }


    /** @test */
    public function it_should_be_able_to_detect_invalid_variable_names()
    {
        $spacedVariable            = $this->extractor->isValidVariableName("foo bar");
        $numberStartingVariable    = $this->extractor->isValidVariableName("1foo");
        $underScoredVariable       = $this->extractor->isValidVariableName("_foo");
        $numberInMiddleVariable    = $this->extractor->isValidVariableName("foo2foo");

        $this->assertEquals(false, $spacedVariable, "Variable should no have spaces in its name");
        $this->assertEquals(false, $numberStartingVariable, "Variable should not start with a number");
        $this->assertEquals(true, $underScoredVariable, "Underscore is a valid character in a variable name");
        $this->assertEquals(true, $numberInMiddleVariable, "Number are valid characters after the first when not in the first position");

    }

}