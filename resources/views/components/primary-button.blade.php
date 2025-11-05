<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex items-center
            px-4 py-2
            bg-[#3F8EFC] hover:bg-[#287CE9] active:bg-[#1A6AD6]
            border border-transparent rounded-md
            font-semibold text-sm text-white
            uppercase tracking-widest
            shadow-sm hover:shadow-md
            focus:outline-none focus:ring-2 focus:ring-[#3F8EFC] focus:ring-offset-2
            transition ease-in-out duration-150
        ',
    ]) }}>
    {{ $slot }}
</button>
