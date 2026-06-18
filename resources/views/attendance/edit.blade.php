<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Attendance') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 p-6 rounded-2xl shadow-2xl 
                bg-purple-800/30 backdrop-blur-lg border border-white/20">
        
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-purple-100 font-medium mb-1">Class</label>
                <select name="class_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg focus:ring-2 focus:ring-purple-400 outline-none">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $attendance->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-purple-100 font-medium mb-1">Student</label>
                <select name="student_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg focus:ring-2 focus:ring-purple-400 outline-none">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-4">
                <label class="block text-purple-100 font-medium mb-1">Date</label>
                <input type="date" name="date" value="{{ old('date', $attendance->date) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg focus:ring-2 focus:ring-purple-400 outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-purple-100 font-medium mb-1">Status</label>
                <select name="present" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg focus:ring-2 focus:ring-purple-400 outline-none" required>
                    <option value="present" {{ $attendance->present == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ $attendance->present == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="late" {{ $attendance->present == 'late' ? 'selected' : '' }}>Late</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg">
                Update Attendance
            </button>
        </form>
    </div>
</x-layout>