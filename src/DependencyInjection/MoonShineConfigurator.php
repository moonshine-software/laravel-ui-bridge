<?php

declare(strict_types=1);

namespace MoonShine\LaravelUIBridge\DependencyInjection;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\AbstractLayout;

final class MoonShineConfigurator implements ConfiguratorContract
{
    private array $items;

    public function __construct(Repository $repository)
    {
        $this->items = $repository->get('moonshine', []);
    }

    public function getTitle(): string
    {
        return $this->get('title', '');
    }

    public function title(string|Closure $title): self
    {
        return $this->set('title', $title);
    }

    /**
     * @return string[]
     */
    public function getLocales(): array
    {
        return Collection::make($this->get('locales', []))
            ->mapWithKeys(fn ($value, $key) => [is_numeric($key) ? $value : $key => $value])
            ->toArray();
    }

    /**
     * @param  string[]|Closure  $locales
     */
    public function locales(array|Closure $locales): self
    {
        return $this->set('locales', $locales);
    }

    public function addLocales(array|string $locales): self
    {
        if (\is_string($locales)) {
            $locales = [$locales];
        }

        return $this->set('locales', [
            ...$this->getLocales(),
            ...$locales,
        ]);
    }

    public function locale(string $locale): self
    {
        return $this->set('locale', $locale);
    }

    public function getLocale(): string
    {
        return $this->get('locale', 'en');
    }

    public function localeKey(string $name): self
    {
        return $this->set('locale_key', $name);
    }

    public function getLocaleKey(): string
    {
        return $this->get('locale_key');
    }

    public function getDisk(): string
    {
        return $this->get('disk', 'public');
    }

    /**
     * @param  string[]|Closure  $options
     */
    public function disk(string|Closure $disk, array|Closure $options = []): self
    {
        return $this
            ->set('disk', $disk)
            ->set('disk_options', $options);
    }

    /**
     * @return string[]
     */
    public function getDiskOptions(): array
    {
        return $this->get('disk_options', []);
    }

    /**
     * @return class-string<AbstractLayout>
     */
    public function getLayout(): string
    {
        return $this->get('layout');
    }

    /**
     * @param  class-string<AbstractLayout>|Closure  $layout
     */
    public function layout(string|Closure $layout): self
    {
        return $this->set('layout', $layout);
    }

    public function getPage(string $name, string $default, mixed ...$parameters): PageContract
    {
        $class = $this->get("pages.$name", $default);

        return app($class, $parameters);
    }

    /**
     * @return list<class-string<PageContract>>
     */
    public function getPages(): array
    {
        return $this->get('pages', []);
    }

    public function getForm(string $name, string $default, mixed ...$parameters): FormBuilderContract
    {
        $class = $this->get("forms.$name", $default);

        return \call_user_func(
            new $class(...$parameters)
        );
    }

    public function has(string $key): bool
    {
        return Arr::has($this->items, $key);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return value(
            Arr::get($this->items, $key, $default)
        );
    }

    public function set(string $key, mixed $value): self
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->set($offset, null);
    }
}
