<?php


abstract class Filter implements JsonSerializable
{

    public abstract static function getCookieName(): string;
    public abstract function jsonSerialize(): array;

    public function getEncoded() {
        return json_encode($this);
    }

}

