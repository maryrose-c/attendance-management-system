<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Edit Student</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-2xl mx-auto p-6 rounded-2xl shadow-2xl bg-purple-800/30 backdrop-blur-lg border border-white/20">
            @if ($errors->any())
                <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6">
                    <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-purple-100 font-medium mb-1">Student ID / LRN</label>
                        <input type="text" name="student_number" value="{{ old('student_number', $student->student_number) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-purple-100 font-medium mb-1">Class</label>
                        <select name="class_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg">
                            <option value="">No class selected</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id) == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-purple-100 font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-purple-100 font-medium mb-1">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg">
                    </div>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">Student Photo</label>
                    @if($student->photo_path)
                        <img src="{{ asset($student->photo_path) }}" class="mb-3 h-20 w-20 rounded-2xl object-cover border border-white/20" alt="Student Photo">
                    @endif
                    <input type="file" name="photo" accept="image/*" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg">
                </div>

                <button class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-3 rounded-lg">Update Student</button>
            </form>
        </div>
    </div>
</x-layout>
