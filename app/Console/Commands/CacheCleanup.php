<?php

namespace App\Console\Commands;

use App\Listeners\LogSpamDetectedEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CacheCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans out the cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cachePrefix = config('cache.prefix');

        // Clears expired items
        DB::table('cache')
            ->select(['key'])
            ->cursor()
            ->map(fn ($res) => Str::after($res->key, $cachePrefix))
            ->each(fn ($key) => Cache::get($key));

        // Rm spam logs
        if (config('spam-prevension.log-spam-events') === true) {
            return;
        }

        $spamLogger = class_basename(LogSpamDetectedEvent::class);

        DB::table('cache')
            ->select(['key'])
            ->where('key', 'like', "%{$spamLogger}%")
            ->cursor()
            ->map(fn ($res) => Str::after($res->key, $cachePrefix))
            ->each(fn ($key) => Cache::forget($key));
    }
}
