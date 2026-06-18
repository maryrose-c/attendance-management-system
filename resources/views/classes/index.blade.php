<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Classes</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 p-8 text-white">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-md text-emerald-200 p-4 rounded-xl mb-6 shadow-lg">{{ session('success') }}</div>
            @endif

            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white">Classes</h1>
                    <p class="mt-1 text-purple-200/70 font-semibold">Manage class sections, rooms, schedules, and assigned students.</p>
                </div>
                <a href="{{ route('classes.create') }}" class="px-5 py-3 rounded-xl bg-gradient-to-r from-fuchsia-500 to-purple-600 text-white font-semibold shadow-lg hover:scale-105 transition duration-300">+ Add Class</a>
            </div>

            <form method="GET" class="mb-6 flex gap-3 rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-lg">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search class, room, or day..." class="flex-1 rounded-xl border border-white/20 bg-black/20 p-3 text-white placeholder-purple-200/50">
                <button class="rounded-xl bg-violet-600 px-6 py-3 font-black text-white">Search</button>
            </form>

            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[980px] border-collapse">
                        <thead>
                            <tr class="bg-white/10 text-purple-200 uppercase text-xs tracking-wider font-semibold">
                                <th class="p-4 text-center border-b border-white/10">ID</th>
                                <th class="p-4 text-left border-b border-white/10">Class Name</th>
                                <th class="p-4 text-left border-b border-white/10">Room</th>
                                <th class="p-4 text-left border-b border-white/10">Schedule</th>
                                <th class="p-4 text-left border-b border-white/10">Teacher</th>
                                <th class="p-4 text-center border-b border-white/10">Students</th>
                                <th class="p-4 text-center border-b border-white/10">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-white divide-y divide-white/10">
                            @forelse($classes as $classModel)
                                <tr class="hover:bg-white/5 transition duration-200">
                                    <td class="p-4 text-center font-medium">{{ $classModel->id }}</td>
                                    <td class="p-4 font-black">{{ $classModel->name }}</td>
                                    <td class="p-4 text-purple-200">{{ $classModel->room ?? 'No room' }}</td>
                                    <td class="p-4 text-purple-200">
                                        {{ $classModel->schedule_day ?? 'No day' }}
                                        @if($classModel->start_time && $classModel->end_time)
                                            <span class="block text-sm text-purple-200/60">{{ substr($classModel->start_time, 0, 5) }} - {{ substr($classModel->end_time, 0, 5) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-purple-200">{{ $classModel->teacher->name ?? 'N/A' }}</td>
                                    <td class="p-4 text-center"><span class="rounded-xl bg-emerald-500/20 px-3 py-1 font-black text-emerald-200">{{ $classModel->students->count() }}</span></td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('classes.edit', $classModel) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-4 py-2 rounded-lg transition shadow-md">Edit</a>
                                            <form action="{{ route('classes.destroy', $classModel) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this class?')" class="bg-rose-600 hover:bg-rose-700 text-white font-medium px-4 py-2 rounded-lg transition shadow-md">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="p-8 text-center text-purple-300/60">No classes found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
