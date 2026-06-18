<x-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">Students Management</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 p-8 text-white">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-md text-emerald-200 p-4 rounded-xl mb-6 shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6">
                <div>
                    <h1 class="text-4xl font-black text-white">Students</h1>
                    <p class="mt-2 text-purple-200/70 font-semibold">Search students, print QR cards, and open profiles by scanning QR codes.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('students.qr.cards') }}" target="_blank"
                       class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold shadow-lg hover:scale-105 transition duration-300">
                        🖨️ Print All QR
                    </a>
                    <a href="{{ route('students.create') }}"
                       class="px-6 py-3 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-purple-600 text-white font-semibold shadow-lg hover:scale-105 transition duration-300">
                        + Add Student
                    </a>
                </div>
            </div>

            <form method="GET" class="mb-6 grid gap-3 md:grid-cols-[1fr_240px_auto] rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-lg">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name, ID number, email, or contact..."
                       class="rounded-xl border border-white/20 bg-black/20 p-3 text-white placeholder-purple-200/50">
                <select name="class_id" class="rounded-xl border border-white/20 bg-black/20 p-3 text-white">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
                <button class="rounded-xl bg-violet-600 px-6 py-3 font-black text-white">Filter</button>
            </form>

            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1050px] border-collapse">
                        <thead>
                            <tr class="bg-white/10 text-purple-200 uppercase text-xs tracking-wider font-semibold">
                                <th class="p-4 text-left border-b border-white/10">Profile</th>
                                <th class="p-4 text-left border-b border-white/10">Student Info</th>
                                <th class="p-4 text-left border-b border-white/10">Contact</th>
                                <th class="p-4 text-left border-b border-white/10">Class</th>
                                <th class="p-4 text-left border-b border-white/10">QR Preview</th>
                                <th class="p-4 text-center border-b border-white/10">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-white divide-y divide-white/10">
                        @forelse($students as $student)
                            <tr class="hover:bg-white/5 transition duration-200">
                                <td class="p-4">
                                    @if($student->photo_path)
                                        <img src="{{ asset($student->photo_path) }}" class="h-14 w-14 rounded-2xl object-cover border border-white/20" alt="Student Photo">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-500/20 text-2xl">👤</div>
                                    @endif
                                </td>

                                <td class="p-4">
                                    <a href="{{ route('students.show', $student) }}" class="font-black hover:text-fuchsia-300 transition">
                                        {{ $student->name }}
                                    </a>
                                    <p class="text-sm text-purple-200/70">{{ $student->student_number ?? 'No student ID' }}</p>
                                </td>

                                <td class="p-4 text-purple-200">
                                    <p>{{ $student->email }}</p>
                                    <p class="text-sm text-purple-200/60">{{ $student->contact_number ?? 'No contact' }}</p>
                                </td>

                                <td class="p-4 text-purple-200">{{ $student->classModel->name ?? 'Unassigned' }}</td>

                                <td class="p-4">
                                    <div class="inline-flex items-center gap-3 rounded-xl bg-black/20 px-3 py-2 border border-white/10">
                                        <img src="{{ route('students.qr', $student) }}" alt="{{ $student->name }} QR" class="h-14 w-14 rounded-md bg-white p-1">
                                        <span class="text-xs text-purple-200/70 font-semibold">Profile QR</span>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="flex flex-wrap justify-center items-center gap-2">
                                        <a href="{{ route('students.show', $student) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-3 py-2 rounded-lg transition shadow-md">Profile</a>
                                        <a href="{{ route('students.qr.card', $student) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-3 py-2 rounded-lg transition shadow-md">QR Card</a>
                                        <a href="{{ route('students.edit', $student) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-3 py-2 rounded-lg transition shadow-md">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this student?')" class="bg-rose-600 hover:bg-rose-700 text-white font-medium px-3 py-2 rounded-lg transition shadow-md">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-purple-300/60">No students found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
