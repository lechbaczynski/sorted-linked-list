<?php

namespace Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Lechbaczynski\SortedLinkedList\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    public function testAddIntegers(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add(100);
        $sortedList->add(42);
        $sortedList->add(42);
        $sortedList->add(PHP_INT_MAX);
        $sortedList->add(0);
        $sortedList->add(-1);
        $sortedList->add(PHP_INT_MIN);
        $this->assertEquals(7, $sortedList->count());
    }

    public function testAddStrings(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add('foo');
        $sortedList->add('bar');
        $sortedList->add('');
        $sortedList->add('42');
        $sortedList->add(str_repeat('baz', 100));
        $this->assertEquals(5, $sortedList->count());
    }

    public function testAddInvalidType(): void
    {
        $this->expectException(Exception::class);
        $sortedList = new SortedLinkedList();
        $sortedList->add(42);
        $sortedList->add("string");
    }

    public function testContains(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add(3);
        $sortedList->add(1);
        $sortedList->add(2);

        $this->assertTrue($sortedList->contains(2));
        $this->assertTrue($sortedList->contains(1));
        $this->assertFalse($sortedList->contains(4));
        $this->assertFalse($sortedList->contains('string'));
        $this->assertFalse($sortedList->contains(''));
        $this->assertFalse($sortedList->contains(0));
    }

    public function testRemove(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add(3);
        $sortedList->add(2);
        $sortedList->add(1);
        $sortedList->add(4);

        $removedValue = 2;

        $this->assertTrue($sortedList->remove($removedValue));
        $this->assertFalse($sortedList->contains($removedValue));
        $this->assertEquals(3, $sortedList->count());
        $this->assertFalse($sortedList->remove($removedValue));
    }

    public function testCount(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add('foo');
        $sortedList->add('bar');
        $sortedList->add('baz');

        $this->assertEquals(3, $sortedList->count());

        $sortedList->remove('bar');
        $this->assertEquals(2, $sortedList->count());

        $sortedList->add('bar');
        $this->assertEquals(3, $sortedList->count());

        $sortedList->add('bar');
        $this->assertEquals(4, $sortedList->count());
    }

    public function testToArray(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add(3);
        $sortedList->add(1);
        $sortedList->add(2);

        $expectedArray = [1, 2, 3];
        $this->assertEquals($expectedArray, $sortedList->toArray());

        $emptyList = new SortedLinkedList();
        $this->assertEquals([], $emptyList->toArray());

        $sortedListStrings = new SortedLinkedList();
        $sortedListStrings->add('baz');
        $sortedListStrings->add('foo');
        $sortedListStrings->add('bar');
        $this->assertEquals(['bar', 'baz', 'foo'], $sortedListStrings->toArray());
    }

    public function testGetGenerator(): void
    {
        $sortedList = new SortedLinkedList();
        $sortedList->add(3);
        $sortedList->add(2);
        $sortedList->add(1);

        $expectedValues = [1, 2, 3];
        $generator = $sortedList->getGenerator();

        $result = [];
        foreach ($generator as $value) {
            $result[] = $value;
        }

        $this->assertEquals($expectedValues, $result);
    }
}
