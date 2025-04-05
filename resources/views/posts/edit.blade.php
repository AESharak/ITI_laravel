<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Edit Post</h2>
            </div>
            
            <div class="px-6 py-4">
                <!-- post to trick the broswer -->
                <form method="POST" action="{{ route('posts.update', $post['id']) }}">
                    @csrf
                    @method('PUT')
                    <!-- Title Input -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            name="title"
                            type="text"
                            id="title"
                            value="{{ $post['title'] }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border"
                        >
                    </div>
                    
                    <!-- Description Textarea -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="5"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border"
                        >{{ $post['description'] }}</textarea>
                    </div>
                    
                    <!-- Post Creator Select -->
                    <div class="mb-6">
                        <label for="creator" class="block text-sm font-medium text-gray-700 mb-1">Post Creator</label>
                        <select
                            name="post_creator"
                            id="creator"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border bg-white"
                        >
                            <option value="1" {{ $post['posted_by'] == 'Ahmed' ? 'selected' : '' }}>Ahmed</option>
                            <option value="2" {{ $post['posted_by'] == 'Mohamed' ? 'selected' : '' }}>Mohamed</option>
                            <option value="3" {{ $post['posted_by'] == 'Ibrahem' ? 'selected' : '' }}>Ibrahem</option>
                        </select>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-2">
                        <a 
                            href="{{ route('posts.index') }}" 
                            class="px-4 py-2 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer"
                        >
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>