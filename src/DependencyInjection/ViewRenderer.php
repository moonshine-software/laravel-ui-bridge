<?php

declare(strict_types=1);

namespace MoonShine\LaravelUIBridge\DependencyInjection;

use Illuminate\Contracts\Support\Renderable;
use MoonShine\Contracts\Core\DependencyInjection\ViewRendererContract;

final class ViewRenderer implements ViewRendererContract
{
    public function render(string $view, array $data = []): Renderable
    {
        return view($view, $data);
    }
}
