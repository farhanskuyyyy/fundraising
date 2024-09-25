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
                        <a href="{{ route('admin.my_withdrawals') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">My
                            Withdrawals</a>
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
                {{ __('Withdrawals Detail') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="pt-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <h3 class="text-indigo-950 text-3xl font-bold mb-5 text-center dark:text-white">My Request</h3>
                <div class="flex flex-row gap-x-16 justify-center">
                    <div class="flex flex-col gap-y-10">
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Total Amount</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Rp
                                {{ number_format($fundraisingWithdrawal->amount_requested, 0, ',', '.') }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white mb-2">Status</p>
                            @if ($fundraisingWithdrawal->has_sent)
                                @if ($fundraisingWithdrawal->has_received)
                                    <span
                                        class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                        DELIVERED
                                    </span>
                                @else
                                    <span
                                        class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-indigo-500 text-white">
                                        PROCESSING
                                    </span>
                                @endif
                            @else
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                    PENDING
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                                {{ date('d M Y', strtotime($fundraisingWithdrawal->created_at)) }}</h3>
                        </div>
                    </div>
                    <div>
                        <img src="{{ Storage::url($fundraisingWithdrawal->fundraising->thumbnail) }}" alt=""
                            class="rounded-2xl object-cover w-[300px] h-[200px] mb-3">
                        <h3 class="text-indigo-950 text-xl font-bold dark:text-white">{{ $fundraisingWithdrawal->fundraising->name }}
                        </h3>
                        <p class="text-slate-500 text-sm dark:text-white">{{ $fundraisingWithdrawal->fundraising->category->name }}</p>
                    </div>
                </div>
                @if ($fundraisingWithdrawal->has_sent)
                    <hr class="my-5">
                    <h3 class="text-indigo-950 text-xl font-bold mb-5 dark:text-white">Sent to:</h3>
                    <div class="flex flex-row gap-x-10">
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Bank</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">{{ $fundraisingWithdrawal->bank_name }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">No Account</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                                {{ $fundraisingWithdrawal->bank_account_number }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm dark:text-white">Account Name</p>
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">
                                {{ $fundraisingWithdrawal->bank_account_name }}</h3>
                        </div>
                        {{-- <div>
                        <p class="text-slate-500 text-sm">SWIFT Code</p>
                        <h3 class="text-indigo-950 text-xl font-bold">ANCAP</h3>
                    </div> --}}
                    </div>
                    <hr class="my-5">
                    <h3 class="text-indigo-950 text-xl font-bold mb-5 dark:text-white">Uang Sudah Dikirim</h3>
                    <img src="{{ Storage::url($fundraisingWithdrawal->proof) }}" alt=""
                        class="rounded-2xl object-cover w-[300px] h-[200px] mb-3">
                    @if (!$fundraisingWithdrawal->has_received)
                        <hr class="my-5">
                        <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Have You Delivered Money?</h3>
                        <form
                            action="{{ route('admin.fundraising_phases.store', $fundraisingWithdrawal->fundraising_id) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="notes" :value="__('notes')" />
                                <textarea name="notes" id="notes" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full"></textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                            <div class="mt-4 w-fit">
                                <x-input-label for="photo" :value="__('photo')" />
                                <x-text-input id="photo" class="mb-7 block mt-1 w-full" type="file"
                                    name="photo" required autofocus autocomplete="photo" />
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Update Donation
                            </button>
                        </form>
                    @else
                        <hr class="my-5">
                        @foreach ($fundraisingWithdrawal->fundraising->phases as $phase)
                            <h3 class="text-indigo-950 text-xl font-bold mb-5 dark:text-white">Uang Sudah Diterima Korban</h3>
                            <img src="{{ Storage::url($phase->photo) }}" alt=""
                                class="rounded-2xl object-cover w-[300px] h-[200px] mb-3">
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
