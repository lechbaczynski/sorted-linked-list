<?php

declare(strict_types=1);

namespace Lechbaczynski\SortedLinkedList;

class Node
{
    public function __construct(public int|string $value, public ?Node $next = null)
    {
    }
}
