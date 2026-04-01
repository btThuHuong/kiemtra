<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
    </header>

    <form method="post" action="{{ route('saveinfo') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="id" value="{{ $user->id }}">

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Số điện thoại')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
        </div>

        <div>
            <x-input-label for="photo" :value="__('Ảnh đại diện')" />
            @if($user->photo)
                <div class="mt-2 mb-2">
                    <img src="{{ asset('storage/profile/'.$user->photo) }}" width="80px" class="rounded border shadow-sm">
                </div>
            @endif
            <input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-lg cursor-pointer bg-gray-50" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>