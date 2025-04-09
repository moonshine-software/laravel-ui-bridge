<?php

declare(strict_types=1);

namespace MoonShine\LaravelUIBridge\DependencyInjection;

use MoonShine\Core\AbstractRouter;
use MoonShine\LaravelUIBridge\MoonShineEndpoints;

final class MoonShineRouter extends AbstractRouter
{
    public function getEndpoints(): MoonShineEndpoints
    {
        return new MoonShineEndpoints();
    }

    public function to(string $name = '', array $params = []): string
    {
        return route(
            $this->getName($name),
            $this->getParams($params)
        );
    }
}
