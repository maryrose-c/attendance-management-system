<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-100 leading-tight tracking-wide">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-950 via-violet-900 to-fuchsia-800 py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-10 bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl rounded-[30px]">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl rounded-[30px]">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white/5 backdrop-blur-lg border border-rose-500/20 shadow-2xl rounded-[30px]">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>