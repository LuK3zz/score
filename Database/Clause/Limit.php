<?php
namespace LuK3zz\score\Database\Clause;

use LuK3zz\score\Database\QueryInterface;

class Limit implements QueryInterface
{
    /** @var int $size */
    protected $size;

    /** @var int|null $offset */
    protected $offset;

    /**
     * @param int      $size
     * @param int|null $offset
     */
    public function __construct(int $size, ?int $offset = null)
    {
        $this->size = $size;
        $this->offset = $offset;
    }

    /**
     * @return int[]
     */
    public function getValues(): array
    {
        if ($this->offset !== null) {
            $values = [$this->offset, $this->size];
        } else {
            $values = [$this->size];
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $sql = 'LIMIT ?';
        if ($this->offset !== null) {
            $sql .= ', ?';
        }

        return $sql;
    }
}
