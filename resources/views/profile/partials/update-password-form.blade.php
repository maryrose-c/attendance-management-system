<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-white tracking-wide">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-purple-200/60">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-semibold text-sm text-purple-200 tracking-wide mb-2">
                {{ __('Current Password') }}
            </label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full p-4 rounded-2xl bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition shadow-inner" 
                autocomplete="current-password" 
            />
            <x-input-error class="mt-2 text-rose-400" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <label for="update_password_password" class="block font-semibold text-sm text-purple-200 tracking-wide mb-2">
                {{ __('New Password') }}
            </label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full p-4 rounded-2xl bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition shadow-inner" 
                autocomplete="new-password" 
            />
            <x-input-error class="mt-2 text-rose-400" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-semibold text-sm text-purple-200 tracking-wide mb-2">
                {{ __('Confirm Password') }}
            </label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full p-4 rounded-2xl bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition shadow-inner" 
                autocomplete="new-password" 
            />
            <x-input-error class="mt-2 text-rose-400" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <button 
                type="submit" 
                class="px-6 py-3 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-bold shadow-lg hover:scale-105 transition duration-300 uppercase text-xs tracking-wider"
            >
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-400 font-medium">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>