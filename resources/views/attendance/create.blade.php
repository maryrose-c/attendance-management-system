<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Record Attendance</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-xl mx-auto bg-white/10 backdrop-blur-lg border border-white/20 rounded-[30px] shadow-2xl p-8">
            @if ($errors->any())
                <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6">
                    <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('attendance.store') }}">
    @csrf

            

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Class</label>
                    <select name="class_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Student</label>
                    <select name="student_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Date</label>
                    <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Status</label>
                    <select name="present" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-purple-100 font-medium mb-1">Remarks / Excuse Notes</label>
                    <textarea name="remarks" rows="3" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" placeholder="Optional notes, reason, or excuse...">{{ old('remarks', $attendance->remarks ?? '') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-3 rounded-lg">Save Attendance</button>
            </form>
        </div>
    </div>
</x-layout>
