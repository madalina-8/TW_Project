<?php
include_once "Filter.php";

class SexFilter extends Filter
{
    private $values;
    private $compare;

    public function __construct($values = [], $compare = false) {
            $this->values = $values;
            $this->compare = $compare;
    }

    /**
     * @return array|mixed
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public static function from($data): SexFilter {
        $class = new SexFilter();
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
        return "sex";
    }


    public function shouldCompare(): bool
    {
        return $this->compare;
    }

    public function setValues($new)
    {
        $this->values = $new;
    }
}