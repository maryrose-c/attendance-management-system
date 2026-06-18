<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Add Student</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-lg rounded-3xl p-6 border border-white/10">
            @if ($errors->any())
                <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6">
                    <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-purple-100">Student ID / LRN</label>
                        <input type="text" name="student_number" value="{{ old('student_number') }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3" placeholder="2026-IT-0042">
                    </div>

                    <div>
                        <label class="block mb-2 text-purple-100">Class</label>
                        <select name="class_id" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                            <option value="">No class selected</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-purple-100">Student Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3" required>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-purple-100">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-purple-100">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3" placeholder="09123456789">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-purple-100">Student Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                    <p class="mt-1 text-xs text-purple-200/60">Optional. JPG, PNG, or WEBP only.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-fuchsia-500 to-purple-600 text-white font-bold">Add Student</button>
                    <a href="{{ route('students.index') }}" class="px-6 py-3 rounded-xl bg-white/10 text-purple-100">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
