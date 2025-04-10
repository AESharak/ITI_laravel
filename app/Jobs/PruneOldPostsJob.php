<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PruneOldPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * Delete posts that were created 2 years ago or more
     */
    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subYears(2);
        
        // Using whereDate instead of where as it's more specific for date comparisons
        $oldPosts = Post::whereDate('created_at', '<=', $cutoffDate)->get();
        
        $count = $oldPosts->count();
        
        foreach ($oldPosts as $post) {
            // Delete associated comments first
            $post->comments()->delete();
            
            // Then delete the post
            $post->delete();
        }
        
        // Log the operation
        Log::info("PruneOldPostsJob completed: $count old posts were deleted");
    }
}
