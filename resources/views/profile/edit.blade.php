<x-app-layout>
    <x-slot name="header">
        <h2 class="title-gradient text-xl leading-tight" style="margin: 0;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4 mx-auto" style="max-width: 600px;">
        <div class="space-y-6">
            <div class="glass-card" style="padding-bottom: 1.75rem;">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="glass-card" style="padding-bottom: 1.75rem;">
                @include('profile.partials.update-password-form')
            </div>

            <div class="glass-card" style="padding-bottom: 1.75rem;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
