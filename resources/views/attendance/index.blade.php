<x-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-3xl font-black tracking-widest text-white"><span class="text-fuchsia-300">ATTENDANCE</span> HISTORY</h2>
            <a href="{{ route('attendance.create') }}" class="inline-flex justify-center rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-purple-950/40 hover:scale-[1.02] transition">+ Log Manual Entry</a>
        </div>
    </x-slot>

    <div class="min-h-screen px-6 py-12">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-500/10 p-4 font-bold text-emerald-200">{{ session('success') }}</div>
            @endif

            <form method="GET" class="mb-6 grid gap-3 rounded-2xl border border-violet-500/20 bg-[#150623]/80 p-4 md:grid-cols-[1fr_180px_220px_180px_auto]">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search student or student ID..." class="rounded-xl border border-white/10 bg-black/20 p-3 text-white placeholder-purple-200/50">
                <select name="status" class="rounded-xl border border-white/10 bg-black/20 p-3 text-white">
                    <option value="">All Status</option>
                    <option value="present" @selected($status === 'present')>Present</option>
                    <option value="late" @selected($status === 'late')>Late</option>
                    <option value="absent" @selected($status === 'absent')>Absent</option>
                </select>
                <select name="class_id" class="rounded-xl border border-white/10 bg-black/20 p-3 text-white">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ $date }}" class="rounded-xl border border-white/10 bg-black/20 p-3 text-white">
                <button class="rounded-xl bg-violet-600 px-6 py-3 font-black text-white">Filter</button>
            </form>

            <div class="overflow-hidden rounded-2xl border border-violet-500/30 bg-[#150623]/80 shadow-2xl shadow-purple-950/40">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1060px] text-left">
                        <thead>
                            <tr class="bg-violet-950/70 text-xs font-black uppercase tracking-widest text-purple-100">
                                <th class="px-6 py-5">Logged Date</th>
                                <th class="px-6 py-5">Student Profile</th>
                                <th class="px-6 py-5">Class Section</th>
                                <th class="px-6 py-5">Status Token</th>
                                <th class="px-6 py-5">Source</th>
                                <th class="px-6 py-5">Remarks</th>
                                <th class="px-6 py-5 text-right">Workspace Controls</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-500/10">
                            @forelse($attendanceRecords as $record)
                                <tr class="hover:bg-violet-500/5 transition">
                                    <td class="px-6 py-5 font-bold text-white">{{ $record->date ?? 'N/A' }}</td>
                                    <td class="px-6 py-5">
                                        <a href="{{ $record->student ? route('students.show', $record->student) : '#' }}" class="font-black text-white hover:text-fuchsia-300">{{ $record->student->name ?? 'Deleted Student' }}</a>
                                        <p class="text-xs font-semibold text-purple-200/60">{{ $record->student->student_number ?? 'No student ID' }}</p>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-white">{{ $record->classModel->name ?? 'No Class' }}</td>
                                    <td class="px-6 py-5">
                                        @php
                                            $statusClass = match($record->present) {
                                                'present' => 'bg-emerald-500/20 text-emerald-200',
                                                'late' => 'bg-amber-500/20 text-amber-200',
                                                default => 'bg-rose-500/20 text-rose-200',
                                            };
                                        @endphp
                                        <span class="rounded-lg px-3 py-2 text-xs font-black uppercase {{ $statusClass }}">{{ $record->present }}</span>
                                    </td>
                                    <td class="px-6 py-5"><span class="rounded-lg bg-violet-500/20 px-3 py-2 text-xs font-black uppercase text-purple-100">{{ $record->source ?? 'manual' }}</span></td>
                                    <td class="px-6 py-5 max-w-[240px] text-sm font-semibold text-purple-200/70">{{ $record->remarks ?? 'No remarks' }}</td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('attendance.edit', $record->id) }}" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-black text-white hover:bg-violet-500">Modify</a>
                                            <form action="{{ route('attendance.destroy', $record->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Delete this attendance record?')" class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-black text-white hover:bg-rose-500">Drop</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-10 text-center text-purple-200/60">No attendance records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
