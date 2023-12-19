<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(App::isLocal());

        Str::macro('attributeMarkdown', function ($string, array $options = []) {
            $converter = new GithubFlavoredMarkdownConverter($options);
            $converter->getEnvironment()->addExtension(new AttributesExtension());

            return (string) $converter->convert($string);
        });

        Stringable::macro('attributeMarkdown', function (array $options = []) {
            /** @var \Illuminate\Support\Stringable $this */
            return new Stringable(Str::attributeMarkdown($this->value, $options));
        });
    }
}
