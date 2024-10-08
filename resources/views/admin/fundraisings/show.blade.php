<x-app-layout>
    <x-slot name="breadcrumb">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.fundraisings.index') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Fundraisings</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="#"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Show</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>
    <x-slot name="header">
        <div class="sm:flex">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                {{ __('Show Fundraising') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="w-full">
        <div class="overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">

            @if ($fundraising->is_active)
                <span class="text-white font-bold bg-green-500 rounded-2xl  p-5">
                    Fundraising sudah disetujui oleh super admin.
                </span>
            @else
                <div class="flex flex-row justify-between">
                    <span class="text-white font-bold bg-red-500 rounded-2xl  p-5">
                        Fundraising belum disetujui oleh super admin.
                    </span>
                </div>
            @endif

            <hr>


            <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                <div class="flex flex-row items-center gap-x-3">
                    <img src="{{ Storage::url($fundraising->thumbnail) }}" alt=""
                        class="rounded-2xl object-cover w-[200px] h-[150px]">
                    <div class="flex flex-col">
                        <h3 class="text-indigo-950 text-xl font-bold dark:text-white">{{ $fundraising->name }}</h3>
                        <p class="text-slate-500 text-sm dark:text-white">{{ $fundraising->category->name }}</p>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="text-slate-500 text-sm dark:text-white">Donaturs</p>
                    <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                        {{ $fundraising->donaturs->count() }}</h3>
                </div>
                <div class="flex flex-col">
                    <p class="text-slate-500 text-sm dark:text-white">Fundraiser</p>
                    <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                        {{ $fundraising->fundraiser->user->name }}</h3>
                </div>
            </div>
            <div class="">
                <p class="text-slate-500 text-sm dark:text-white">About</p>
                <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                    {{ $fundraising->about }}
                </h3>
            </div>

            <hr class="my-5">
            <div class="flex flex-row justify-between items-center">
                <div>
                    <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Rp
                        {{ number_format($totalDonations, 0, ',', '.') }}</h3>
                    <p class="text-slate-500 text-sm dark:text-white">Funded</p>
                </div>
                <div class="w-[400px] rounded-full h-2.5 bg-slate-300">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
                <div>
                    <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Rp
                        {{ number_format($fundraising->target_amount, 0, ',', '.') }}</h3>
                    <p class="text-slate-500 text-sm dark:text-white">Goal</p>
                </div>
            </div>
            <hr class="my-5">

            <div class="flex flex-row justify-between items-center">
                <div class="flex flex-col">
                    <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Donaturs</h3>
                </div>
            </div>

            @forelse ($fundraising->donaturs as $donatur)
                <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Rp
                                {{ number_format($donatur->total_amount, 0, ',', '.') }}</h3>
                            <p class="text-slate-500 text-sm dark:text-white">{{ $donatur->name }}</p>
                        </div>
                    </div>

                    <p class="text-slate-500 text-sm dark:text-white">"{{ $donatur->notes }}"</p>

                </div>
            @empty
                <p class="dark:text-white">No Data Found</p>
            @endforelse

        </div>
    </div>
</x-app-layout>
