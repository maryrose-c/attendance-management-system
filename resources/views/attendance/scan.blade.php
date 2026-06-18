<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">QR Attendance Scanner</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 p-8 text-white">
        <div class="max-w-5xl mx-auto mt-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-md text-emerald-200 p-4 rounded-xl shadow-lg">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-rose-500/20 border border-rose-500/30 backdrop-blur-md text-rose-200 p-4 rounded-xl shadow-lg">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-3xl shadow-2xl">
                    <h1 class="text-3xl font-black mb-3">Camera QR Scanner</h1>
                    <p class="text-purple-200/70 font-semibold mb-5">Scan a student QR card. The student profile will open automatically, and you can mark attendance.</p>

                    <div id="reader" class="overflow-hidden rounded-2xl border border-white/20 bg-black/30"></div>

                    <div class="mt-5 flex gap-3">
                        <button id="startScanner" type="button" class="flex-1 rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-600 px-5 py-3 text-sm font-black uppercase tracking-wide text-white">Start Camera</button>
                        <button id="stopScanner" type="button" class="flex-1 rounded-xl border border-violet-400/40 bg-violet-500/10 px-5 py-3 text-sm font-black uppercase tracking-wide text-white">Stop</button>
                    </div>

                    <p id="scanStatus" class="mt-4 text-center text-sm font-semibold text-purple-200/70">Camera is ready.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-3xl shadow-2xl">
                    <h1 class="text-3xl font-black mb-3">Manual / Barcode Scanner Input</h1>
                    <p class="text-purple-200/70 font-semibold mb-5">You can also paste the QR token or use a USB scanner here.</p>

                    <form method="POST" action="{{ route('attendance.storeScan') }}" id="scanForm">
                        @csrf

                        <label for="qr_code" class="block mb-3 text-lg font-medium text-purple-200 tracking-wide">QR Code Value or Profile URL</label>

                        <input
                            type="text"
                            name="qr_code"
                            id="qr_code"
                            class="w-full bg-black/30 border border-white/20 rounded-xl p-4 text-white placeholder-purple-300/50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition text-center font-mono tracking-widest text-xl"
                            placeholder="[ Scan or paste QR here ]"
                            autofocus
                            required
                        >

                        <button
                            type="submit"
                            class="w-full mt-6 bg-gradient-to-r from-fuchsia-500 to-purple-600 hover:from-fuchsia-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:scale-[1.02] transition duration-300 text-center tracking-wider uppercase text-sm">
                            Open Profile / Mark Attendance
                        </button>
                    </form>

                    <div class="mt-6 rounded-2xl border border-violet-400/20 bg-black/20 p-4">
                        <h3 class="font-black text-white">How it works</h3>
                        <p class="mt-2 text-sm text-purple-200/70 font-semibold">Each student has a generated QR card. When scanned, the QR opens that student's profile and can record today's attendance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let scanner = null;
        let isScanning = false;
        const statusText = document.getElementById('scanStatus');
        const input = document.getElementById('qr_code');
        const form = document.getElementById('scanForm');

        function handleQr(decodedText) {
            statusText.textContent = 'QR detected. Loading student profile...';

            if (decodedText.startsWith('http://') || decodedText.startsWith('https://') || decodedText.startsWith('/scan/student/')) {
                window.location.href = decodedText;
                return;
            }

            input.value = decodedText;
            form.submit();
        }

        document.getElementById('startScanner').addEventListener('click', async () => {
            if (isScanning) return;

            scanner = new Html5Qrcode('reader');
            try {
                await scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 260, height: 260 } },
                    handleQr
                );
                isScanning = true;
                statusText.textContent = 'Scanning... point the camera at a student QR card.';
            } catch (error) {
                statusText.textContent = 'Camera could not start. Use manual input or allow camera permission.';
            }
        });

        document.getElementById('stopScanner').addEventListener('click', async () => {
            if (scanner && isScanning) {
                await scanner.stop();
                scanner.clear();
                isScanning = false;
                statusText.textContent = 'Scanner stopped.';
            }
        });
    </script>
</x-layout>
