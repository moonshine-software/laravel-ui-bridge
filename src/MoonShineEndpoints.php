<?php

declare(strict_types=1);

namespace MoonShine\LaravelUIBridge;

use MoonShine\Contracts\Core\DependencyInjection\EndpointsContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Core\Exceptions\EndpointException;
use Symfony\Component\HttpFoundation\RedirectResponse;

final readonly class MoonShineEndpoints implements EndpointsContract
{
    private function throwException(): never
    {
        throw new EndpointException('Routes undefined in UI');
    }

    public function method(
        string $method,
        ?string $message = null,
        array $params = [],
        ?PageContract $page = null,
        ?ResourceContract $resource = null,
    ): string {
        $this->throwException();
    }

    public function reactive(
        ?PageContract $page = null,
        ?ResourceContract $resource = null,
        array $extra = [],
    ): string {
        $this->throwException();
    }

    public function component(
        string $name,
        array $additionally = [],
    ): string {
        $this->throwException();
    }

    public function updateField(
        ?ResourceContract $resource = null,
        ?PageContract $page = null,
        array $extra = [],
    ): string {
        $this->throwException();
    }

    public function toPage(
        string|PageContract|null $page = null,
        string|ResourceContract|null $resource = null,
        array $params = [],
        array $extra = [],
    ): string|RedirectResponse {
        $this->throwException();
    }

    public function home(): string
    {
        return '/';
    }
}
