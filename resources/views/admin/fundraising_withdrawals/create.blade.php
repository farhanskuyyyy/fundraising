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
                        <a href="{{ route('admin.fundraising_withdrawals.index') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Withdrawals</a>
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
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Create</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>
    <x-slot name="header">
        <div class="sm:flex">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                {{ __('New Withdrawals') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="pt-6">
        <div class="max-w-3xl mx-3">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <form method="POST" action="{{ route('admin.fundraising_withdrawals.store') }}">
                @csrf
                <div class="my-4">
                    <x-input-label for="fundraising" :value="__('Fundraising')" />

                    <select name="fundraising_id" id="fundraising_id"
                        class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                        <option value="">Choose Fundraising</option>
                        @foreach ($fundraisings as $fundraising)
                            @if ($fundraising->totalReachedAmount() >= $fundraising->target_amount && !$fundraising->withdrawals()->exists())
                                <option value="{{ $fundraising->id }}">{{ $fundraising->name }}</option>
                            @endif
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('fundraising')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="bank_name" :value="__('Bank Name')" />
                    <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name"
                        :value="old('bank_name')" required autofocus autocomplete="bank_name" />
                    <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bank_account_name" :value="__('Bank Account Name')" />
                    <x-text-input id="bank_account_name" class="block mt-1 w-full" type="text"
                        name="bank_account_name" :value="old('bank_account_name')" required autofocus
                        autocomplete="bank_account_name" />
                    <x-input-error :messages="$errors->get('bank_account_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
                    <x-text-input id="bank_account_number" class="block mt-1 w-full" type="text"
                        name="bank_account_number" :value="old('bank_account_number')" required autofocus
                        autocomplete="bank_account_number" />
                    <x-input-error :messages="$errors->get('bank_account_number')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Create Withdrawal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
