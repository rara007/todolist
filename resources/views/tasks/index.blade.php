<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Tombol "Add New Task" (Hanya muncul jika pengguna sudah login) --}}
                    @auth
                        <div class="mb-4">
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add New Task
                            </a>
                        </div>
                    @else
                        {{-- Pesan untuk tamu (guest) yang melihat daftar tugas. Ini tidak akan muncul jika TaskController mengarahkan ke tasks.promo --}}
                        {{-- Namun, tetap dipertahankan untuk jaga-jaga atau jika logika diubah --}}
                        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
                            Anda sedang melihat daftar tugas publik. Untuk menambah, mengedit, atau menghapus tugas, silakan <a href="{{ route('login') }}" class="font-semibold underline">Login</a> atau <a href="{{ route('register') }}" class="font-semibold underline">Register</a> terlebih dahulu.
                        </div>
                    @endauth

                    @if ($tasks->isEmpty())
                        {{-- Pesan ini muncul jika tidak ada tugas sama sekali di database,
                             atau jika user login belum punya tugas. --}}
                        <p>No tasks found. Why not create one?</p>
                    @else
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Title</th>
                                        <th scope="col" class="px-6 py-3">Description</th>
                                        <th scope="col" class="px-6 py-3">Due Date</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Owner</th>
                                        @auth {{-- Kolom Aksi hanya muncul jika pengguna sudah login --}}
                                            <th scope="col" class="px-6 py-3">Actions</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{-- Link ke halaman detail tugas --}}
                                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">{{ $task->title }}</a>
                                            </th>
                                            <td class="px-6 py-4">{{ Str::limit($task->description, 50) }}</td>
                                            <td class="px-6 py-4">{{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $task->completed ? 'Completed' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ $task->user->name }}</td>
                                            @auth
                                                <td class="px-6 py-4">
                                                    @if (Auth::id() === $task->user_id)
                                                        <a href="{{ route('tasks.edit', $task) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</a>
                                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                                        </form>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>