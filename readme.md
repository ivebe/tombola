# Ivebe/Tombola [![Build Status](https://travis-ci.org/ivebe/tombola.svg?branch=master)](https://travis-ci.org/ivebe/tombola)
Tombola is popular gambling game which consist of tables with 6 tickets. In each table there is 90 numbers, and each ticket contains 15 numbers. This package is PHP implementation with help of `harrysethi/Tambola-Ticket-Generator` explanation and java implementation.

#### Rules
- One table consist of 6 tickets.
- It must have all numbers from 1 to 90, and they must be used only once
  + 1st column, numbers from 1 to 9
  + 2nd-8th column, numbers from 20-29, 30-39 ... 80-89
  + 9th column numbers from 80 to 90
- each row has exactly 5 numbers
- each column must have at least one number

#### Installation

Install using composer.

```sh
composer require ivebe/tombola
```

#### Usage
Just require composer autoloader if it's not already in your project, and following example will print simple table with 6 tickets.

```php
require_once __DIR__ . '/vendor/autoload.php';

use Ivebe\Tombola\Table;

$table = new Table();
$table->generate();
$table->prettyPrint();

```

If you wish to get array of tickets and their numbers in order to further customize tickets, you can get it like this:

```php
require_once __DIR__ . '/vendor/autoload.php';

use Ivebe\Tombola\Table;

$table = new Table();
$table->generate();

foreach( $table->getTickets() as $ticket ){
    $numbers = $ticket->getNumbers();
    //do something with it
}
```

There is also `Test` class which will verify table and return boolean `true/false`. You can use this and check is table valid. If it's not generate new table. It accepts array of tickets, and expect exactly 6 tickets of a single table. Why not pass `Table` object instead? It's done so that you can modify tickets, and verify that integrity of table is still intact.

```php
require_once __DIR__ . '/vendor/autoload.php';

use Ivebe\Tombola\Table;
use Ivebe\Tombola\Test;

$table = new Table();
$table->generate();

$tickets = $table->getTickets();

var_dump(Test::verify($tickets));
```


#### License
MIT

