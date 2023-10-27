<?php

declare(strict_types=1);

namespace Lechbaczynski\SortedLinkedList;

use Countable;
use Generator;
use InvalidArgumentException;

/**
 * SortedLinkedList (linked list that keeps values sorted).
 * It is able to hold string or int values, but not both in the same list.
 */
class SortedLinkedList implements Countable
{
    public function __construct(private ?Node $head = null)
    {
    }

    /**
     * Adds a value to list
     *
     * You can add integer or string.
     * But cannot add integer to list already containing strings and vice versa.
     *
     * @param int|string $value The value to add.
     *
     * @throws InvalidArgumentException If the value's type is invalid.
     *
     * @return void
     */
    public function add(int|string $value): void
    {
        $newNode = new Node($value);

        if ($this->head === null) {
            $this->head = $newNode;
            return;
        }

        if (gettype($value) != gettype($this->head->value)) {
            throw new InvalidArgumentException('Invalid data type. Cannot mix integer and string types');
        }

        if ($value <= $this->head->value) {
            $newNode->next = $this->head;
            $this->head = $newNode;
            return;
        }

        $current = $this->head;
        while ($current->next !== null && $current->next->value < $value) {
            $current = $current->next;
        }
        $newNode->next = $current->next;
        $current->next = $newNode;
    }

    /**
     * Removes a value from list
     *
     * Returns true if element was removed, false if element was not found.
     * If multiple elements with the same value exist, removes just one of them
     *
     * @param int|string $value Value to remove form the list (once)
     *
     * @return bool
     */
    public function remove(int|string $value): bool
    {
        $current = $this->head;
        $previous = null;
        while ($current !== null) {
            if ($current->value == $value) {
                if ($previous !== null) {
                    $previous->next = $current->next;
                } else {
                    $this->head = $current->next;
                }
                return true;
            }
            $previous = $current;
            $current = $current->next;
        }
        return false;
    }

    public function contains(int|string $value): bool
    {
        $current = $this->head;
        while ($current !== null) {
            if ($current->value === $value) {
                return true;
            }
            $current = $current->next;
        }
        return false;
    }


    /**
     * Returns a generator that yields all values in the sorted linked list.
     *
     * @return Generator<int|string>
     */
    public function getGenerator(): Generator
    {
        $current = $this->head;
        while ($current !== null) {
            yield $current->value;
            $current = $current->next;
        }
    }

    /**
     * @return array<int|string>
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->getGenerator() as $value) {
            $result[] = $value;
        }
        return $result;
    }

    final public function count(): int
    {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            $count++;
            $current = $current->next;
        }
        return $count;
    }
}
