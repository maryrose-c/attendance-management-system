<x-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black tracking-tight text-white">Student Profile</h2>
    </x-slot>

    <div class="min-h-screen px-6 py-10 text-white">
        <div class="max-w-7xl mx-auto space-y-8">
            @if(session('success'))
                <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/20 p-4 text-emerald-200 font-semibold">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="rounded-xl border border-rose-400/30 bg-rose-500/20 p-4 text-rose-200 font-semibold">{{ session('error') }}</div>
            @endif

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 rounded-[28px] border border-violet-500/30 bg-gradient-to-r from-violet-950/80 to-purple-950/70 p-8 shadow-2xl shadow-purple-950/40">
                    <span class="inline-flex items-center rounded-full border border-violet-300/30 bg-violet-500/20 px-4 py-1 text-xs font-black uppercase tracking-widest text-purple-200">Scanned Student Profile</span>
                    <div class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-center">
                        @if($student->photo_path)
                            <img src="{{ asset($student->photo_path) }}" class="h-24 w-24 rounded-3xl object-cover border border-white/20 shadow-xl" alt="Student Photo">
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-violet-500/20 text-5xl">👤</div>
                        @endif
                        <div>
                            <h1 class="text-4xl sm:text-5xl font-black leading-tight text-white">{{ $student->name }}</h1>
                            <p class="mt-2 font-black text-fuchsia-200">{{ $student->student_number ?? 'No Student ID / LRN' }}</p>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 text-purple-100/80 font-semibold">
                        <p><span class="text-purple-300">Email:</span> {{ $student->email }}</p>
                        <p><span class="text-purple-300">Contact:</span> {{ $student->contact_number ?? 'No contact number' }}</p>
                        <p><span class="text-purple-300">Class:</span> {{ $student->classModel->name ?? 'Unassigned' }}</p>
                        <p><span class="text-purple-300">Room:</span> {{ $student->classModel->room ?? 'No room' }}</p>
                        <p><span class="text-purple-300">Schedule:</span> {{ $student->classModel->schedule_day ?? 'No schedule' }} @if($student->classModel?->start_time && $student->classModel?->end_time) · {{ substr($student->classModel->start_time, 0, 5) }} - {{ substr($student->classModel->end_time, 0, 5) }} @endif</p>
                        <p><span class="text-purple-300">QR Token:</span> <span class="font-mono text-xs break-all">{{ $student->qr_code }}</span></p>
                    </div>

                    <form method="POST" action="{{ route('attendance.storeScan') }}" class="mt-7">
                        @csrf
                        <input type="hidden" name="qr_code" value="{{ $student->qr_code }}">
                        <button class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:scale-[1.02] transition">
                            Mark Present Today
                        </button>
                        <a href="{{ route('students.qr.card', $student) }}" target="_blank" class="ml-2 inline-block rounded-xl border border-violet-400/40 bg-violet-500/10 px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-violet-500/20 transition">
                            Print QR Card
                        </a>
                    </form>
                </div>

                <div class="rounded-[28px] border border-violet-500/30 bg-violet-950/40 p-8 shadow-xl text-center">
                    <img src="{{ route('students.qr', $student) }}" alt="{{ $student->name }} QR" class="mx-auto h-64 w-64 rounded-2xl bg-white p-4 shadow-2xl">
                    <p class="mt-4 text-sm font-bold text-purple-200/70">Scan this QR to open this profile and record attendance.</p>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6"><p class="text-xs font-black uppercase tracking-widest text-purple-300/70">Attendance Rate</p><p class="mt-3 text-4xl font-black text-emerald-300">{{ $rate }}%</p></div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6"><p class="text-xs font-black uppercase tracking-widest text-purple-300/70">Present</p><p class="mt-3 text-4xl font-black text-white">{{ $present }}</p></div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6"><p class="text-xs font-black uppercase tracking-widest text-purple-300/70">Late</p><p class="mt-3 text-4xl font-black text-white">{{ $late }}</p></div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6"><p class="text-xs font-black uppercase tracking-widest text-purple-300/70">Absent</p><p class="mt-3 text-4xl font-black text-white">{{ $absent }}</p></div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6">
                    <h3 class="text-xl font-black text-white mb-4">Student Analytics</h3>
                    <canvas id="studentStatusChart" height="160"></canvas>
                </div>

                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6">
                    <h3 class="text-xl font-black text-white mb-4">Recent Attendance Logs</h3>
                    <div class="overflow-hidden rounded-xl border border-white/10">
                        <table class="w-full text-sm">
                            <thead class="bg-white/10 text-purple-200 uppercase text-xs tracking-wider">
                                <tr><th class="p-3 text-left">Date</th><th class="p-3 text-left">Class</th><th class="p-3 text-left">Status</th><th class="p-3 text-left">Remarks</th></tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse($recentAttendance as $log)
                                    <tr>
                                        <td class="p-3">{{ $log->date ?? 'N/A' }}</td>
                                        <td class="p-3">{{ $log->classModel->name ?? 'N/A' }}</td>
                                        <td class="p-3"><span class="rounded-lg bg-black/20 px-3 py-1 font-bold uppercase">{{ $log->present }}</span></td>
                                        <td class="p-3 text-purple-200/70">{{ $log->remarks ?? 'No remarks' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-4 text-center text-purple-200/60">No attendance records yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('studentStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Late', 'Absent'],
                datasets: [{ data: [{{ $present }}, {{ $late }}, {{ $absent }}] }]
            },
            options: { plugins: { legend: { labels: { color: '#fff' } } } }
        });
    </script>
</x-layout>
