A library providing SortedLinkedList (linked list that keeps values sorted). 

It is able to hold string or int values, but not both in the same list.

Usage:

```
$list = new SortedLinkedList();
$list->add('foo');
$list->add('bar');
$list->add('baz');
$list->remove('bar');
$list->contains('foo'); // true
$list->count(); // 2
$list->toArray(); // ['baz', 'foo']
$list->getGenerator(); // returns Generator that yields values
```
