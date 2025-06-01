    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Task Details: ') . $task->title }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold">Title:</h3>
                            <p>{{ $task->title }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold">Description:</h3>
                            <p>{{ $task->description ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold">Due Date:</h3>
                            <p>{{ $task->due_date ? $task->due_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold">Status:</h3>
                            <p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $task->completed ? 'Completed' : 'Pending' }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold">Owner:</h3>
                            <p>{{ $task->user->name }}</p>
                        </div>
                        <div class="mt-6 flex items-center">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Back to List
                            </a>
                            @auth
                                @if (Auth::id() === $task->user_id)
                                    <a href="{{ route('tasks.edit', $task) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Edit Task
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Delete Task
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>