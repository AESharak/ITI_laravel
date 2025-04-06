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

        <!-- Back Button -->
        <div class="flex justify-end">
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-600 text-white font-medium rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Back to All Posts
            </a>
        </div>
    </div>
</x-layout>