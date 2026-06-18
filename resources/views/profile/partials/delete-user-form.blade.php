<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-white tracking-wide">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-purple-200/60">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 to-red-600 text-white font-bold shadow-lg hover:scale-105 transition duration-300 uppercase text-xs tracking-wider"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-purple-950 text-white border border-white/10 rounded-3xl shadow-2xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-purple-200/70">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm account deletion.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-3/4 p-4 rounded-2xl bg-black/30 border border-white/20 text-white placeholder-purple-300/40 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition shadow-inner" 
                    placeholder="{{ __('Password') }}" 
                />
                <x-input-error class="mt-2 text-rose-400" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 rounded-2xl bg-white/10 border border-white/10 text-purple-200 font-semibold hover:bg-white/20 hover:text-white transition duration-300 mr-3 text-sm">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-6 py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition duration-300 shadow-lg text-sm uppercase tracking-wider">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>