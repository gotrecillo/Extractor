<?php


namespace Gotrecillo\Extractor;


class Extractor {

    /**
     * @param array $arr Array to prepare for extract() php method
     * @param \string[] ...$names Keys that we want to extract
     *
     * @throws \Exception
     * @return array Prepared array for extract
     */
    public function prepareExtraction(array $arr, string ...$names) :array
    {
        $filtered = array_filter(
            $arr,
            function ($key) use ($names) {
                return in_array($key, $names);
            },
            ARRAY_FILTER_USE_KEY
        );

        if (count($names) > count($filtered)) {
            throw new ArrayKeyNotFoundException;
        }

        return $filtered;
    }

    public function isValidVariableName($name)
    {
        return (boolean) preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name);
    }
}