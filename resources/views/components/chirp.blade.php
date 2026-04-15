@props(['chirp'])

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex space-x-3">
            @if ($chirp->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        @php
                            $url = Arr::random([
                                '37d01f64-ac72-4d15-ae33-e104c2289783',
                                '14dfd79e-4387-4ffd-8555-57fbc8016408?vibe=sunset',
                                'b2a68554-98f3-4786-9a49-743516fbd4b5?vibe=ocean',
                                'c3a7d443-bb6d-4476-9aa1-b353ba3a87dc?vibe=daybreak',
                                '29c74e93-0250-4ecc-8651-a03d8071d4ad?vibe=bubble',
                                '3ffd9f2e-13f4-463e-ada7-6903dc1bf2dc?vibe=forest',
                                '57fa26cb-e8ae-4620-b2af-8e9bcecc7740?vibe=fire',
                                'afda6680-8475-4b20-af5f-14a4f35cb2b6?vibe=crystal',
                                'e3514e4c-dc72-479d-8c69-f43149e7e426?vibe=ice',
                            ]);
                        @endphp
                        <img src="https://avatars.laravel.cloud/{{ $url }}"
                            alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/ed3b563d-ae15-4252-bc3e-e53a804b6cb5?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                        {{-- <span class="text-base-content/60">·</span> --}}
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited
                                {{ $chirp->updated_at->diffForHumans() }}</span>
                        @else
                            <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    @can('update', $chirp)
                        <div class="flex gap-1">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs"> Edit </a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}"> @csrf @method('DELETE') <button
                                    type="submit" onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error"> Delete </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <p class="mt-1">
                    {{ $chirp->message }}
                </p>
            </div>
        </div>
    </div>
</div>
