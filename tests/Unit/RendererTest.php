<?php 
use Renderer\MissingDataException;

it('should render the template with the data', function () {
    $template = "Hello {name}!";
    $data = ['name' => 'World'];

    $renderer = new \Renderer\Renderer($template, $data);

    expect($renderer->render())->toBe("Hello World!");
});

it("Should render complex 1 line template with data" , function () {
    $template = "Dear {title} {surname}, your task is {task}.";
    $data = [
        'title' => 'Dr',
        'surname' => 'Smith',
        'task' => 'complete the report'
    ];

    $renderer = new \Renderer\Renderer($template, $data);
    $expected = "Dear Dr Smith, your task is complete the report.";

    expect($renderer->render())->toBe($expected);
});

it("Should render complex template with data", function () {
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
    $expected = <<<EOT
    Dear Mr Barbini,
    we would like to bring to your attention these task due soon:
      1 - buy the paint which is due by today
      2 - paint the wall which is due by tomorrow
    Thank you very much Uberto.
    EOT;

    expect($renderer->render())->toBe($expected);
});

it("Should render template with extra data", function () {
    $template = "Hello {name}!";
    $data = [
        'name' => 'Alice',
        'age' => 30
    ];

    $renderer = new \Renderer\Renderer($template, $data);
    $expected = "Hello Alice!";

    expect($renderer->render())->toBe($expected);
});

describe('Renderer::Tag::Optional', function () {

    it("Should render with true optional", function () {
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

        $expected = <<<EOT
        Mr Falcão,
        thanks for your order.
        Merry Christmas!
        EOT;

        expect($renderer->render())->toBe($expected);
    });

    it("Should render with false optional", function () {
        $template = <<<EOT
        {title} {surname},
        thanks for your order.
        {?isXmas}Merry Christmas!{/isXmas}
        EOT;

        $data = [
            'title' => "Mr",
            'surname' => "Falcão",
            'isXmas' => false
        ];

        $renderer = new \Renderer\Renderer($template, $data);

        $expected = <<<EOT
        Mr Falcão,
        thanks for your order.
        EOT;

        expect($renderer->render())->toBe($expected);
    });
});

it('Should render evrything', function () {
    $template = <<<EOT
    Dear {title} {surname},
    we would like to bring to your attention these task due soon:
    {tasks}  {id} - {taskname} which is due by {due}{/tasks}
    Thank you very much {name}.
    {?isXmas}Merry Christmas!{/isXmas}
    EOT;

    $data = [
        'title' => 'Mr',
        'surname' => 'Barbini',
        'name' => 'Uberto',
        'tasks' => [
            ['id' => '1', 'taskname' => 'buy the paint', 'due' => 'today'],
            ['id' => '2', 'taskname' => 'paint the wall', 'due' => 'tomorrow']
        ],
        'isXmas' => true
    ];

    $renderer = new \Renderer\Renderer($template, $data);
    $expected = <<<EOT
    Dear Mr Barbini,
    we would like to bring to your attention these task due soon:
      1 - buy the paint which is due by today
      2 - paint the wall which is due by tomorrow
    Thank you very much Uberto.
    Merry Christmas!
    EOT;

    expect($renderer->render())->toBe($expected);
});
