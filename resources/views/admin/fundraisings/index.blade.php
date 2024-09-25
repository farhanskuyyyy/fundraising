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
            </ol>
        </nav>
    </x-slot>
    <x-slot name="header">
        <div class="sm:flex">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                {{ __('Manage Fundraisings') }}</h1>
            @can('create fundraisings')
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('admin.fundraisings.create') }}"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white bg-green-500 hover:bg-green-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Add Fundraising
                    </a>
                </div>
            @endcan
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl">
            <table id="categories-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Thumbnail
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Name
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Target
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Donaturs
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Fundraiser
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Action
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fundraisings as $fundraising)
                        <tr>
                            <td><img src="{{ Storage::url($fundraising->thumbnail) }}" alt=""
                                    class="rounded-2xl object-cover w-[120px] h-[90px]"></td>
                            <td>{{ $fundraising->name }} <br> ( {{ $fundraising->category->name }} )</td>
                            <td>Rp. {{ number_format($fundraising->target_amount, 0, ',', '.') }}</td>
                            <td>{{ $fundraising->donaturs->count() }}</td>
                            <td>{{ $fundraising->fundraiser->user->name }}</td>
                            <td class="md:flex flex-row items-center gap-x-3">
                                <a href="{{ route('admin.fundraisings.edit', ['fundraising' => $fundraising]) }}"
                                    class="inline-flex items-center justify-center mt-5  px-3 py-2 text-sm font-medium text-center text-white bg-indigo-500 hover:bg-indigo-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                                    Edit
                                </a>
                                <a href="{{ route('admin.fundraisings.show', ['fundraising' => $fundraising]) }}"
                                    class="inline-flex items-center justify-center mt-5  px-3 py-2 text-sm font-medium text-center text-white bg-sky-500 hover:bg-sky-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
