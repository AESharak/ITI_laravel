<x-layout>
       <div class="text-center">
           <a href="{{ route('posts.create') }}" class="mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
               Create Post
           </a>
       </div>


       <!-- Table Component -->
       <div class="mt-6 rounded-lg border border-gray-200">
           <div class="overflow-x-auto rounded-t-lg">
               <table class="min-w-full divide-y divide-gray-200">
                   <thead class="bg-gray-50">
                       <tr>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                       </tr>
                   </thead>
                   <tbody class="bg-white divide-y divide-gray-200">
                       @foreach($posts as $post)
                       <tr>
                           <td class="px-6 py-4 whitespace-nowrap">
                               <div class="text-sm text-gray-900">{{ $post->id }}</div>
                           </td>
                           <td class="px-6 py-4 whitespace-nowrap">
                               @if($post->image)
                                   <img src="/storage/{{ $post->image }}" alt="{{ $post->title }}" class="h-12 w-16 object-cover rounded">
                               @else
                                   <span class="text-xs text-gray-500">No image</span>
                               @endif
                           </td>
                           <td class="px-6 py-4">
                               <div class="text-sm text-gray-900">{{ $post->title }}</div>
                           </td>
                           <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$post->user ? $post->user->name : 'Not Available'}}</td>
                           <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$post->created_at->format('Y-m-d')}}</td>
                           <td class="px-6 py-4 whitespace-nowrap text-gray-700 space-x-2">
                               <a href="{{ route('posts.show', $post->id) }}" class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-400 rounded hover:bg-blue-500">View</a>
                               <a href="{{ route('posts.edit', $post->id) }}" class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Edit</a>
                               <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class="px-4 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 cursor-pointer">Delete</button>
                               </form>
                           </td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>


           <!-- Pagination -->
           <div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
               {{ $posts->links() }}
           </div>
       </div>
</x-layout>