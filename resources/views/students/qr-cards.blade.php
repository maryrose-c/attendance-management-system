<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student QR Cards</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white !important; }
            .card { break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-[#070316] p-8 text-white">
    <div class="no-print mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black">Student QR Cards</h1>
            <p class="text-purple-200/70">Print all QR cards and distribute them to students.</p>
        </div>
        <button onclick="window.print()" class="rounded-xl bg-violet-600 px-6 py-3 font-black text-white">Print</button>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($students as $student)
            <div class="card rounded-3xl border border-violet-400/30 bg-white p-6 text-center text-slate-900 shadow-xl">
                <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center overflow-hidden rounded-2xl bg-violet-100 text-3xl">
                    @if($student->photo_path)
                        <img src="{{ asset($student->photo_path) }}" class="h-full w-full object-cover" alt="Student Photo">
                    @else
                        👤
                    @endif
                </div>
                <h2 class="text-xl font-black">{{ $student->name }}</h2>
                <p class="text-sm font-bold text-violet-700">{{ $student->student_number ?? 'No Student ID' }}</p>
                <p class="mb-4 text-sm text-slate-600">{{ $student->classModel->name ?? 'Unassigned Class' }}</p>
                <img src="{{ route('students.qr', $student) }}" class="mx-auto h-48 w-48" alt="QR Code">
                <p class="mt-4 rounded-xl bg-violet-100 px-3 py-2 text-xs font-bold text-violet-800">Scan to open student profile and mark attendance.</p>
            </div>
        @endforeach
    </div>
</body>
</html>
