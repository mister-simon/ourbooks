<?php

namespace App\Console\Commands;

use App\Listeners\LogSpamDetectedEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InspectLoggedSpam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inspect-logged-spam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inspect the spam logged in the cache table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $spamLogger = class_basename(LogSpamDetectedEvent::class);
        $cachePrefix = config('cache.prefix');

        $keys = DB::table('cache')
            ->where('key', 'like', "%{$spamLogger}%")
            ->select(['key'])
            ->cursor()
            ->map(fn ($res) => Str::after($res->key, $cachePrefix))
            ->reject(fn ($key) => Str::endsWith($key, '-count'))
            ->mapWithKeys(fn ($key) => [$key => Cache::getMultiple([$key, "{$key}-count"])])
            ->mapWithKeys(fn ($items, $key) => [
                $key => [
                    ...$items[$key],
                    'count' => $items["{$key}-count"],
                ],
            ]);

        $this->info('Top scoring count:');
        $topSpam = $keys->max(fn ($spam) => $spam['count']);
        dump($keys->where('count', $topSpam)->all());

        $this->info('IPs used more than once:');
        $keys
            ->flatMap(fn ($spam) => $spam[3][0])
            ->countBy()
            ->sortKeys()
            ->reject(fn ($count) => $count === 1)
            ->dump();

        $this->info('User agent statistics:');
        $keys
            ->flatMap(fn ($spam) => $spam[2]['user-agent'])
            ->countBy()
            ->dump();

        $this->info('content-type statistics:');
        $keys
            ->flatMap(fn ($spam) => $spam[2]['content-type'])
            ->countBy()
            ->sortKeys()
            ->dump();
    }
}
