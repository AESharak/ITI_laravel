<x-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-center mb-6">Post Details</h1>

        <div class="bg-white rounded border border-gray-200 mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Post #{{ $post['id'] }}</h2>
            </div>
            <div class="px-4 py-4">
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Title: <span class="font-normal">{{ $post['title'] }}</span></h3>
                </div>
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Description: <span class="font-normal">{{ $post['description'] }}</span></h3>
                </div>
               
            </div>
        </div>
        
        <!-- Post Info Card -->
        <div class="bg-white rounded border border-gray-200 mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Author Information</h2>
            </div>

            <div class="px-4 py-4">
        
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Email: <span class="font-normal">{{ $post->user->email }}</span></h3>
                </div>
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Posted By: <span class="font-normal">{{ $post->user->name }}</span></h3>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Created At: <span class="font-normal">{{ $post->created_at }}</span></h3>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded border border-gray-200 mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Comments</h2>
            </div>
            
            <div class="px-4 py-4">
                <!-- Comments List -->
                @if ($post->comments->count() > 0)
                    <div class="space-y-4 mb-6">
                        @foreach ($post->comments as $comment)
                            <div class="border rounded p-4 bg-gray-50 relative" id="comment-{{ $comment->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-medium">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Edit Button - No auth check, anyone can edit -->
                                        <button onclick="toggleEditForm({{ $comment->id }})" 
                                            class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Edit
                                        </button>
                                        
                                        <!-- Delete Form - No auth check, anyone can delete -->
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Comment Content -->
                                <div id="comment-content-{{ $comment->id }}">
                                    <p class="text-gray-800">{{ $comment->content }}</p>
                                </div>
                                
                                <!-- Edit Comment Form (Hidden by default) -->
                                <div id="edit-form-{{ $comment->id }}" class="hidden mt-2">
                                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-2">
                                            <textarea name="content" class="w-full border rounded p-2 text-sm" rows="3" required>{{ $comment->content }}</textarea>
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" onclick="toggleEditForm({{ $comment->id }})" 
                                                class="text-xs bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                Cancel
                                            </button>
                                            <button type="submit" 
                                                class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No comments yet. Be the first to comment!</p>
                @endif
                
                <!-- Add Comment Form - Available for anyone -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-medium mb-2">Add a Comment</h3>
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        
                        <!-- User Selection Dropdown -->
                        <div class="mb-3">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Comment as:</label>
                            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <textarea name="content" rows="3" class="w-full border rounded p-2" 
                                placeholder="Write your comment here..." required></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-end">
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-600 text-white font-medium rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Back to All Posts
            </a>
        </div>
    </div>
    
    <!-- JavaScript for Edit Comment Toggle -->
    <script>
        function toggleEditForm(commentId) {
            const contentElement = document.getElementById(`comment-content-${commentId}`);
            const formElement = document.getElementById(`edit-form-${commentId}`);
            
            if (contentElement.classList.contains('hidden')) {
                // Show content, hide form
                contentElement.classList.remove('hidden');
                formElement.classList.add('hidden');
            } else {
                // Hide content, show form
                contentElement.classList.add('hidden');
                formElement.classList.remove('hidden');
            }
        }
    </script>
</x-layout>