<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Create New Study Task</h2>

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Task Title</label>
                        <input type="text" name="title" class="w-full rounded-lg border-gray-300" placeholder="e.g. ITT626 Revision" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Description</label>
                        <textarea name="description" class="w-full rounded-lg border-gray-300" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deadline</label>
                        <input type="date" name="deadline" class="w-full rounded-lg border-gray-300">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700">
                        Save Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>