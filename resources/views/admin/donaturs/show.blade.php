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
                        <a href="{{ route('admin.donaturs.index') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Donaturs</a>
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
                {{ __('View Donatur') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="pt-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="flex flex-row gap-x-16 justify-center">
                    <div class="flex flex-col gap-y-10">
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Total Amount</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Rp
                                {{ number_format($donatur->total_amount, 0, ',', '.') }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white mb-3">Status</p>
                            @if ($donatur->is_paid)
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                    PAID
                                </span>
                            @else
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                    PENDING
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                                {{ date('d M Y', strtotime($donatur->created_at)) }}</h3>
                        </div>
                        <div class="">
                            <p class="text-slate-500 text-sm dark:text-white">Donatur</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">{{ $donatur->name }}</h3>
                        </div>
                    </div>
                    <div>
                        <img src="{{ Storage::url($donatur->fundraising->thumbnail) }}" alt=""
                            class="rounded-2xl object-cover w-[300px] h-[200px] mb-3">
                        <h3 class="text-indigo-950 text-xl font-bold dark:text-white">{{ $donatur->fundraising->name }}
                        </h3>
                        <p class="text-slate-500 text-sm dark:text-white">Target Rp
                            {{ number_format($donatur->fundraising->target_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <hr class="my-5">
                <h3 class="text-indigo-950 text-xl font-bold mb-5 dark:text-white">Proof of Payment</h3>
                <img src="{{ Storage::url($donatur->proof) }}" alt=""
                    class="rounded-2xl object-cover w-[300px] h-[200px] mb-3">
                @if (!$donatur->is_paid)
                    @can('edit donaturs')
                        <hr class="my-5">
                        <form action="{{ route('admin.donaturs.update', ['donatur' => $donatur]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full ">
                                Confirm Donation
                            </button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
