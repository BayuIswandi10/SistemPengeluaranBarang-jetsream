@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Opps!') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ __('Gagal mendapatkan akun yang sesuai, harap coba lagi.') }}</li>
            @endforeach
        </ul>
    </div>
@endif
