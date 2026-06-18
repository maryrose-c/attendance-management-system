<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-white tracking-wide">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-purple-200/60">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-semibold text-sm text-purple-200 tracking-wide mb-2">
                {{ __('Name') }}
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full p-4 rounded-2xl bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition shadow-inner" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-rose-400" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block font-semibold text-sm text-purple-200 tracking-wide mb-2">
                {{ __('Email') }}
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full p-4 rounded-2xl bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition shadow-inner" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-rose-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-white">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-purple-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button 
                type="submit" 
                class="px-6 py-3 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-bold transition duration-300 shadow-lg text-xs uppercase tracking-wider"
            >
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-400 font-medium">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>