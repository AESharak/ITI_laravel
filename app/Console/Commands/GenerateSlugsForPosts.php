<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class GenerateSlugsForPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for all posts that do not have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to generate slugs for posts without them...');
        
        // Get all posts that have null slugs
        $posts = Post::whereNull('slug')->get();
        
        $count = $posts->count();
        $this->info("Found {$count} posts without slugs.");
        
        if ($count === 0) {
            $this->info('No posts need slug generation. Exiting.');
            return;
        }
        
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        
        foreach ($posts as $post) {
            // The sluggable trait will automatically generate the slug
            // We need to trigger an update to make it work
            $post->save();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('All posts have been updated with slugs successfully!');
    }
}
