<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Edit Class</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-lg rounded-3xl p-6 border border-white/10">
            @if ($errors->any())
                <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6">
                    <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('classes.update', $classModel) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-purple-100">Class Name</label>
                    <input type="text" name="name" value="{{ old('name', $classModel->name) }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3" required>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-purple-100">Room</label>
                        <input type="text" name="room" value="{{ old('room', $classModel->room) }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-purple-100">Schedule Day</label>
                        <select name="schedule_day" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                            <option value="">No day selected</option>
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                <option value="{{ $day }}" @selected(old('schedule_day', $classModel->schedule_day) === $day)>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-purple-100">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time', optional($classModel->start_time)->format('H:i') ?? $classModel->start_time) }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-purple-100">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time', optional($classModel->end_time)->format('H:i') ?? $classModel->end_time) }}" class="w-full rounded-xl bg-black/20 border border-white/20 text-white p-3">
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold hover:shadow-lg transition-all">Update Class</button>
            </form>
        </div>
    </div>
</x-layout>
