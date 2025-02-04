@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Opps!') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ __('Gagal mengirim tautan reset password. Silakan coba lagi atau periksa email Anda.') }}</li>
            @endforeach
        </ul>
    </div>
@endif
