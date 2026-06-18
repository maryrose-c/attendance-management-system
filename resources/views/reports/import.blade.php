<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Import Students</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-10 text-white">
        <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-lg border border-white/20 rounded-[30px] shadow-2xl p-8">
            <h1 class="text-2xl font-bold mb-4">Import Students using CSV</h1>
            <p class="text-purple-200 mb-6">CSV headers must be: <code class="bg-black/30 px-2 py-1 rounded">name,email</code>. Optional headers: <code class="bg-black/30 px-2 py-1 rounded">qr_code,class_id</code>.</p>

            @if ($errors->any())
                <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 p-4 rounded-xl mb-6">
                    <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('reports.import.students') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-purple-100 font-medium mb-1">Assign imported students to class</label>
                    <select name="class_id" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg">
                        <option value="">Use CSV class_id / no class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-purple-100 font-medium mb-1">CSV File</label>
                    <input type="file" name="file" accept=".csv,text/csv" class="w-full bg-purple-900/50 border border-purple-500/30 text-white p-3 rounded-lg" required>
                </div>

                <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-fuchsia-500 to-purple-600 text-white font-bold">Import CSV</button>
                <a href="{{ route('reports.index') }}" class="inline-block px-6 py-3 rounded-xl bg-white/10 text-purple-100">Back</a>
            </form>
        </div>
    </div>
</x-layout>
