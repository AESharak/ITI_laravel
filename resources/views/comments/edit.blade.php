<x-layout>
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Edit Comment</h1>
        
        <div class="bg-white rounded border p-6">
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="4" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    >{{ $comment->content }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>