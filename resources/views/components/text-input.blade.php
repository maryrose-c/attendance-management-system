@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/20 bg-black/30 text-white placeholder-purple-300/40 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-2xl shadow-inner [&:-webkit-autofill]:!text-white [&:-webkit-autofill]:[box-shadow:0_0_0px_1000px_rgba(0,0,0,0.3)_inset]']) }}>