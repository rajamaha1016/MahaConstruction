<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YouTubeSyncService;

class SyncYouTubeVideosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:sync {--url= : Optional YouTube channel handle or URL} {--force : Bypass cache and force sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync live YouTube channel videos into the Maha Construction platform';

    /**
     * Execute the console command.
     */
    public function handle(YouTubeSyncService $syncService): int
    {
        $url = $this->option('url') ?: YouTubeSyncService::getActiveChannelUrl();
        $force = $this->option('force');
        $this->info("Fetching live YouTube videos from: {$url}...");

        $result = $syncService->getVideos($url, $force);

        if ($result['count'] > 0) {
            $this->info(" Successfully synced {$result['count']} videos from {$result['channel_name']}!");
            $this->table(
                ['Video ID', 'Title', 'Views', 'Published'],
                array_map(function ($v) {
                    return [
                        $v['youtubeId'],
                        mb_strimwidth($v['title'], 0, 50, '...'),
                        $v['views'] ?? 'N/A',
                        $v['published'] ?? 'N/A'
                    ];
                }, $result['videos'])
            );
            return Command::SUCCESS;
        }

        $this->warn("No videos could be retrieved from {$url}.");
        return Command::FAILURE;
    }
}
