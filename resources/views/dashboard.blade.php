<x-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black tracking-tight text-white">🔮 Dashboard Workspace</h2>
    </x-slot>

    <div class="min-h-screen px-6 py-10">
        <div class="max-w-7xl mx-auto space-y-10">
            <section class="rounded-[28px] border border-violet-500/30 bg-gradient-to-r from-violet-950/80 to-purple-950/70 p-8 sm:p-10 shadow-2xl shadow-purple-950/40">
                <span class="inline-flex items-center rounded-full border border-violet-300/30 bg-violet-500/20 px-4 py-1 text-xs font-black uppercase tracking-widest text-purple-200">⚡ Active Session</span>
                <h1 class="mt-6 max-w-3xl text-4xl sm:text-5xl font-black leading-tight tracking-tight text-white">
                    Welcome Back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-300 to-pink-300">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="mt-4 max-w-2xl text-lg font-semibold text-purple-200/70">
                    Your smart attendance console is operational. Scan student QR codes, view profiles instantly, and monitor attendance analytics.
                </p>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-purple-300/70">Total Classes</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $totalClasses }}</p>
                </div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-purple-300/70">Students Monitored</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $totalStudents }}</p>
                </div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-purple-300/70">Attendance Logs</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $totalAttendance }}</p>
                </div>
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-purple-300/70">Attendance Rate</p>
                    <p class="mt-3 text-4xl font-black text-emerald-300">{{ $attendanceRate }}%</p>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-emerald-200/80">Present Today</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $presentToday }}</p>
                </div>
                <div class="rounded-2xl border border-amber-400/20 bg-amber-500/10 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-amber-200/80">Late Today</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $lateToday }}</p>
                </div>
                <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-6 shadow-lg">
                    <p class="text-sm font-black uppercase tracking-widest text-rose-200/80">Absent Today</p>
                    <p class="mt-3 text-4xl font-black text-white">{{ $absentToday }}</p>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <h3 class="text-xl font-black text-white mb-4">📊 Overall Status Analytics</h3>
                    <canvas id="statusChart" height="160"></canvas>
                </div>

                <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                    <h3 class="text-xl font-black text-white mb-4">📈 Last 7 Days Attendance</h3>
                    <canvas id="weeklyChart" height="160"></canvas>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h3 class="mb-5 text-xl font-black text-white">📌 Quick Actions</h3>
                    <div class="space-y-4">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-violet-500/20 bg-violet-950/40 p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-violet-400/30 bg-violet-500/20 text-2xl">📱</div>
                                <div>
                                    <h4 class="text-lg font-black text-white">Scan Student QR</h4>
                                    <p class="text-sm font-semibold text-purple-200/60">Open camera scanner and show student profile instantly.</p>
                                </div>
                            </div>
                            <a href="{{ route('attendance.scan') }}" class="rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-600 px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:scale-[1.02] transition">Open Scanner</a>
                        </div>

                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-violet-500/20 bg-violet-950/40 p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-violet-400/30 bg-violet-500/20 text-2xl">🎓</div>
                                <div>
                                    <h4 class="text-lg font-black text-white">Student QR Cards</h4>
                                    <p class="text-sm font-semibold text-purple-200/60">Generate and print QR profile cards for each student.</p>
                                </div>
                            </div>
                            <a href="{{ route('students.index') }}" class="rounded-xl border border-violet-400/40 bg-violet-500/10 px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-violet-500/20 transition">View Students</a>
                        </div>

                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-violet-500/20 bg-violet-950/40 p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-violet-400/30 bg-violet-500/20 text-2xl">🏫</div>
                                <div>
                                    <h4 class="text-lg font-black text-white">Manage Classes</h4>
                                    <p class="text-sm font-semibold text-purple-200/60">Create class sections and assign students.</p>
                                </div>
                            </div>
                            <a href="{{ route('classes.index') }}" class="rounded-xl border border-violet-400/40 bg-violet-500/10 px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-violet-500/20 transition">View Classes</a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-violet-500/20 bg-violet-950/40 p-6 shadow-lg">
                        <h3 class="text-xl font-black text-white mb-4">🏆 Top Students by Present Logs</h3>
                        <div class="space-y-3">
                            @forelse($topStudents as $student)
                                <a href="{{ route('students.show', $student) }}" class="flex items-center justify-between rounded-xl border border-white/10 bg-black/20 p-4 hover:bg-white/10 transition">
                                    <div>
                                        <p class="font-black text-white">{{ $student->name }}</p>
                                        <p class="text-sm font-semibold text-purple-200/60">{{ $student->total_logs_count }} total logs</p>
                                    </div>
                                    <span class="rounded-xl bg-emerald-500/20 px-4 py-2 font-black text-emerald-200">{{ $student->present_count }} present</span>
                                </a>
                            @empty
                                <p class="rounded-xl border border-white/10 bg-black/20 p-4 text-purple-200/60">No analytics yet. Start scanning student QR codes.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-6 shadow-lg">
                        <h3 class="text-xl font-black text-white mb-4">⚠️ Low Attendance Alerts</h3>
                        <div class="space-y-3">
                            @forelse($lowAttendanceStudents as $student)
                                @php $rate = round(($student->present_count / max($student->total_logs_count, 1)) * 100, 2); @endphp
                                <a href="{{ route('students.show', $student) }}" class="flex items-center justify-between rounded-xl border border-rose-400/20 bg-black/20 p-4 hover:bg-white/10 transition">
                                    <div>
                                        <p class="font-black text-white">{{ $student->name }}</p>
                                        <p class="text-sm font-semibold text-purple-200/60">{{ $student->present_count }} / {{ $student->total_logs_count }} present logs</p>
                                    </div>
                                    <span class="rounded-xl bg-rose-500/20 px-4 py-2 font-black text-rose-200">{{ $rate }}%</span>
                                </a>
                            @empty
                                <p class="rounded-xl border border-white/10 bg-black/20 p-4 text-purple-200/60">No low-attendance alerts yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const weekly = @json($lastSevenDays);

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Late', 'Absent'],
                datasets: [{ data: [{{ $presentCount }}, {{ $lateCount }}, {{ $absentCount }}] }]
            },
            options: { plugins: { legend: { labels: { color: '#fff' } } } }
        });

        new Chart(document.getElementById('weeklyChart'), {
            type: 'bar',
            data: {
                labels: weekly.map(day => day.label),
                datasets: [
                    { label: 'Present', data: weekly.map(day => day.present) },
                    { label: 'Late', data: weekly.map(day => day.late) },
                    { label: 'Absent', data: weekly.map(day => day.absent) }
                ]
            },
            options: {
                scales: {
                    x: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,.08)' } },
                    y: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,.08)' } }
                },
                plugins: { legend: { labels: { color: '#fff' } } }
            }
        });
    </script>
</x-layout>
