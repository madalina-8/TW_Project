<?php


abstract class Filter implements JsonSerializable
{

    public abstract static function getCookieName(): string;
    public abstract function jsonSerialize(): array;

    public function getEncoded() {
        return json_encode($this);
    }

    public abstract function getValues(): array;
    public abstract function setValues($new);
    public abstract function shouldCompare(): bool;
}

