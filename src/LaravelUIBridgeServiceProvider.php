<?php

declare(strict_types=1);

namespace MoonShine\LaravelUIBridge;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use MoonShine\AssetManager\AssetManager;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\AssetManager\AssetManagerContract;
use MoonShine\Contracts\AssetManager\AssetResolverContract;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\Core\DependencyInjection\OptimizerCollectionContract;
use MoonShine\Contracts\Core\DependencyInjection\RequestContract;
use MoonShine\Contracts\Core\DependencyInjection\RouterContract;
use MoonShine\Contracts\Core\DependencyInjection\TranslatorContract;
use MoonShine\Contracts\Core\DependencyInjection\ViewRendererContract;
use MoonShine\Contracts\MenuManager\MenuManagerContract;
use MoonShine\Core\Collections\OptimizerCollection;
use MoonShine\Core\Core;
use MoonShine\LaravelUIBridge\DependencyInjection\AssetResolver;
use MoonShine\LaravelUIBridge\DependencyInjection\MoonShine;
use MoonShine\LaravelUIBridge\DependencyInjection\MoonShineConfigurator;
use MoonShine\LaravelUIBridge\DependencyInjection\MoonShineRouter;
use MoonShine\LaravelUIBridge\DependencyInjection\Request;
use MoonShine\LaravelUIBridge\DependencyInjection\Translator;
use MoonShine\LaravelUIBridge\DependencyInjection\ViewRenderer;
use MoonShine\MenuManager\MenuManager;
use MoonShine\UI\Collections\Fields;

class LaravelUIBridgeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    public function boot(): void
    {
        $langPath = MoonShine::path('/lang');

        $this->loadTranslationsFrom($langPath, 'moonshine');
        $this->loadViewsFrom(MoonShine::UIPath('/resources/views'), 'moonshine');

        $this->publishes([
            MoonShine::UIPath('/dist') => public_path('vendor/moonshine'),
        ], ['moonshine-assets', 'laravel-assets']);

        $this->publishes([
            $langPath => $this->app->langPath(
                'vendor/moonshine',
            ),
        ]);

        Blade::componentNamespace('MoonShine\UI\Components', 'moonshine');

        $this->registerBladeDirectives();
    }

    protected function registerBindings(): self
    {
        $this->app->singleton(CoreContract::class, MoonShine::class);

        Core::setInstance(static fn () => app(CoreContract::class));

        $this->app->bind(RouterContract::class, MoonShineRouter::class);

        $this->app->singleton(AssetManagerContract::class, AssetManager::class);
        $this->app->singleton(AssetResolverContract::class, AssetResolver::class);

        $this->app->{app()->runningUnitTests() ? 'bind' : 'singleton'}(
            ConfiguratorContract::class,
            MoonShineConfigurator::class,
        );
        $this->app->bind(TranslatorContract::class, Translator::class);
        $this->app->bind(FieldsContract::class, Fields::class);
        $this->app->bind(ViewRendererContract::class, ViewRenderer::class);

        $this->app->bind(RequestContract::class, Request::class);

        $this->app->singleton(MenuManagerContract::class, MenuManager::class);
        $this->app->scoped(ColorManagerContract::class, ColorManager::class);

        $this->app->singleton(OptimizerCollectionContract::class, fn (): OptimizerCollection => new OptimizerCollection(
            cachePath: $this->app->basePath('bootstrap/cache/moonshine.php'),
            config: $this->app->make(ConfiguratorContract::class),
        ));

        return $this;
    }

    protected function registerBladeDirectives(): self
    {
        $this->callAfterResolving('blade.compiler', static function (BladeCompiler $blade): void {
            $blade->directive(
                'defineEvent',
                static fn ($e): string => "<?php echo MoonShine\Support\AlpineJs::eventBlade($e); ?>",
            );

            $blade->directive(
                'defineEventWhen',
                static fn ($e): string => "<?php echo MoonShine\Support\AlpineJs::eventBladeWhen($e); ?>",
            );
        });

        return $this;
    }
}
