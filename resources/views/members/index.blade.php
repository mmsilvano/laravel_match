<x-app-layout>
    <div class="space-y-8">
        <section class="rounded-[2rem] border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-rose-50 p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-pink-600">Browse Members</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Swipe-card energy. Server-rendered.</h1>
                    <p class="mt-3 text-sm leading-6 text-gray-500 sm:text-base">Big photos, soft gradients, fast profile scan. Tap message when match looks right.</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="rounded-2xl bg-white/80 px-4 py-3 shadow-sm ring-1 ring-pink-100">
                        <p class="text-xs font-medium uppercase tracking-[0.2em] text-gray-400">Showing</p>
                        <p class="mt-1 text-xl font-bold text-gray-900">{{ $members->count() }}</p>
                    </div>
                </div>
            </div>
        </section>

        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($members->isEmpty())
            <div class="rounded-[2rem] border border-dashed border-gray-200 bg-white px-6 py-20 text-center shadow-sm">
                <p class="text-lg font-semibold text-gray-900">No members found.</p>
            </div>
        @else
            <div class="mx-auto max-w-md">
                <div class="swiper overflow-visible" data-members-swiper>
                    <div class="swiper-wrapper">
                        @foreach ($members as $member)
                            <div class="swiper-slide">
                                <article class="group overflow-hidden rounded-[2rem] bg-white shadow-[0_20px_60px_-30px_rgba(236,72,153,0.45)] ring-1 ring-gray-200">
                                    <div class="relative aspect-[4/5] overflow-hidden">
                                        <img
                                            src="{{ $member->profilePhotoUrl() }}"
                                            alt="{{ $member->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>

                                        <div class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-pink-600 shadow-sm">
                                            Swipe to match
                                        </div>

                                        <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                                            <div class="flex items-end justify-between gap-3">
                                                <div>
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ $member->name }}</h2>
                                                        <span class="rounded-full bg-white/90 px-3 py-1 text-sm font-semibold text-pink-700">{{ $member->age }}</span>
                                                    </div>
                                                    <p class="mt-3 max-w-sm text-sm leading-6 text-white/85">
                                                        {{ $member->bio ?: 'No bio yet.' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 p-4 sm:p-5">
                                        <button type="button" class="inline-flex items-center justify-center rounded-2xl bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-500">
                                            Swipe
                                        </button>

                                        <form method="POST" action="{{ route('members.conversations.store', $member) }}" data-swipe-form>
                                            @csrf
                                            <x-primary-button class="w-full justify-center rounded-2xl py-3">Message</x-primary-button>
                                        </form>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination !static mt-6"></div>
                </div>
            </div>

            <div class="pt-2">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
