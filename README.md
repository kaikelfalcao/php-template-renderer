# PHP Template Renderer

A simple template rendering library for PHP.

## Installation

You can install the library via Composer:

```bash
composer require kaikelfalcao/php-template-renderer
```

## Usage
Here is an example of how to use the PHP Template Renderer:

### Basic
```php
<?php
require 'vendor/autoload.php';

use Renderer\Renderer;

$template = "Hello {name}!";
$data = ["name" => "World!"];

$renderer = new Renderer($template, $data);

echo $renderer->render();
// Output:  Hello World!
```

### Array rendering

```php
<?php
require 'vendor/autoload.php';

use Renderer\Renderer;

$template = <<<EOT
Dear {title} {surname},
we would like to bring to your attention these task due soon:
{tasks}  {id} - {taskname} which is due by {due}{/tasks}
Thank you very much {name}.
EOT;

$data = [
    'title' => 'Mr',
    'surname' => 'Barbini',
    'name' => 'Uberto',
    'tasks' => [
        ['id' => '1', 'taskname' => 'buy the paint', 'due' => 'today'],
        ['id' => '2', 'taskname' => 'paint the wall', 'due' => 'tomorrow']
    ]
];

$renderer = new \Renderer\Renderer($template, $data);

echo $renderer->render();
/* Output: 
Dear Mr Barbini,
we would like to bring to your attention these task due soon:
    1 - buy the paint which is due by today
    2 - paint the wall which is due by tomorrow
Thank you very much Uberto.
*/
```

### Optional Rendering 

```php
<?php
require 'vendor/autoload.php';

use Renderer\Renderer;

$template = <<<EOT
{title} {surname},
thanks for your order.
{?isXmas}Merry Christmas!{/isXmas}
EOT;

$data = [
    'title' => "Mr",
    'surname' => "Falcão",
    'isXmas' => true
];

$renderer = new \Renderer\Renderer($template, $data);

echo $renderer->render();
/* Output: 
Mr Falcão,
thanks for your order.
Merry Christmas!
*/
```

## Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss what you would like to change.

