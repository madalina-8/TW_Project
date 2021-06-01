<?php
include_once "Filter.php";

class CountryFilter extends Filter
{
    private $values;
    private $compare;

    public function __construct($values = [], $compare = false) {
            $this->values = $values;
            $this->compare = $compare;
    }

    public static function from($data): CountryFilter {
        $class = new CountryFilter();
        foreach ($data as $key => $value)
            $class->{$key} = $value;
        return $class;
    }


    public function jsonSerialize(): array
    {
        return [
            "values" => $this->values,
            "compare" => $this->compare
        ];
    }

    public static function getCookieName(): string
    {
        return "country";
    }
}