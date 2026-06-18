<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Create Class</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-[30px] shadow-2xl p-8">
                <h1 class="text-3xl font-bold text-white mb-6">Add New Class</h1>

                @if ($errors->any())
                    <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6 shadow-lg">
                        <ul class="space-y-1">@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('classes.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-purple-200 mb-2 font-semibold tracking-wide">Class Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-4 rounded-2xl bg-black/20 border border-white/20 text-white placeholder-purple-300/40 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" placeholder="BSIT 3A" required>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-purple-200 mb-2 font-semibold tracking-wide">Room</label>
                            <input type="text" name="room" value="{{ old('room') }}" class="w-full p-4 rounded-2xl bg-black/20 border border-white/20 text-white" placeholder="NET LAB">
                        </div>
                        <div>
                            <label class="block text-purple-200 mb-2 font-semibold tracking-wide">Schedule Day</label>
                            <select name="schedule_day" class="w-full p-4 rounded-2xl bg-black/20 border border-white/20 text-white">
                                <option value="">No day selected</option>
                                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                    <option value="{{ $day }}" @selected(old('schedule_day') === $day)>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-purple-200 mb-2 font-semibold tracking-wide">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full p-4 rounded-2xl bg-black/20 border border-white/20 text-white">
                        </div>
                        <div>
                            <label class="block text-purple-200 mb-2 font-semibold tracking-wide">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full p-4 rounded-2xl bg-black/20 border border-white/20 text-white">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-purple-600 text-white font-semibold shadow-lg hover:scale-105 transition duration-300">Save Class</button>
                        <a href="{{ route('classes.index') }}" class="px-6 py-3 rounded-2xl bg-white/10 border border-white/10 text-purple-200 font-semibold hover:bg-white/20">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
