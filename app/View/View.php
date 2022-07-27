<?php

declare(strict_types=1);

namespace App\View;

use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class View
{
    protected Environment $engine;

    public function __construct(protected string $view, protected array $params = [])
    {
        $loader = new FilesystemLoader(config('view.path'));

        $this->engine = new Environment($loader, config('view.options'));

        $this->engine->addExtension(new Functions());
        $this->engine->addExtension(new IntlExtension());
    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function __toString(): string
    {
        return $this->engine->render($this->view, $this->params);
    }
}
