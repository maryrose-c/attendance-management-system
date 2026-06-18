<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->name }} QR Card</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 p-8 text-white">
    <div class="mx-auto max-w-md rounded-[32px] border border-violet-400/30 bg-violet-950/70 p-8 text-center shadow-2xl">
        <p class="text-sm font-black uppercase tracking-[0.3em] text-fuchsia-300">Attendance QR Card</p>
        <h1 class="mt-4 text-4xl font-black">{{ $student->name }}</h1>
        <p class="mt-2 text-purple-200/80 font-semibold">{{ $student->classModel->name ?? 'Unassigned Class' }}</p>

        <img src="{{ route('students.qr', $student) }}" alt="QR Code" class="mx-auto mt-8 h-72 w-72 rounded-3xl bg-white p-5 shadow-2xl">

        <p class="mt-5 break-all rounded-xl bg-black/20 p-3 text-xs font-mono text-purple-100/80">{{ $profileUrl }}</p>

        <div class="mt-8 flex justify-center gap-3 print:hidden">
            <button onclick="window.print()" class="rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-600 px-6 py-3 text-sm font-black uppercase tracking-wide text-white">Print</button>
            <a href="{{ route('students.index') }}" class="rounded-xl border border-violet-400/40 bg-violet-500/10 px-6 py-3 text-sm font-black uppercase tracking-wide text-white">Back</a>
        </div>
    </div>
</body>
</html>
