<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Attendance Reports</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 p-8 text-white">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-200 p-4 rounded-xl mb-6">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 p-5 rounded-2xl border border-white/10"><p class="text-purple-200">Classes</p><p class="text-3xl font-bold">{{ $summary['total_classes'] }}</p></div>
                <div class="bg-white/10 p-5 rounded-2xl border border-white/10"><p class="text-purple-200">Students</p><p class="text-3xl font-bold">{{ $summary['total_students'] }}</p></div>
                <div class="bg-white/10 p-5 rounded-2xl border border-white/10"><p class="text-purple-200">Attendance Records</p><p class="text-3xl font-bold">{{ $summary['total_attendance'] }}</p></div>
                <div class="bg-gradient-to-r from-fuchsia-500 to-purple-600 p-5 rounded-2xl"><p class="text-purple-100">Attendance Rate</p><p class="text-3xl font-bold">{{ $summary['attendance_rate'] }}%</p></div>
            </div>

            <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                <h1 class="text-3xl font-bold">Generated Attendance Report</h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('reports.import') }}" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700">Import Students</a>
                    <a href="{{ route('reports.export', 'pdf') }}" class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700">PDF</a>
                    <a href="{{ route('reports.export', 'xlsx') }}" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700">XLSX</a>
                    <a href="{{ route('reports.export', 'csv') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700">CSV</a>
                    <a href="{{ route('reports.export', 'json') }}" class="px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700">JSON</a>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl overflow-hidden">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-white/10 text-purple-200 uppercase text-xs tracking-wider font-semibold">
                            <th class="p-4 border-b border-white/10">Date</th>
                            <th class="p-4 border-b border-white/10">Class</th>
                            <th class="p-4 border-b border-white/10">Student</th>
                            <th class="p-4 border-b border-white/10">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-white divide-y divide-white/10">
                        @forelse($attendanceRecords as $record)
                            <tr class="hover:bg-white/5">
                                <td class="p-4">{{ $record->date }}</td>
                                <td class="p-4">{{ $record->classModel->name ?? 'N/A' }}</td>
                                <td class="p-4">{{ $record->student->name ?? 'N/A' }}</td>
                                <td class="p-4">{{ ucfirst($record->present) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-purple-300/60">No report records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
