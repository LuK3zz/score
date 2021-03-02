<?php
namespace LuK3zz\score\Database;

interface QueryInterface
{
    /**
     * @return mixed[]
     */
    public function getValues(): array;

    /**
     * @return string
     */
    public function __toString(): string;
}
