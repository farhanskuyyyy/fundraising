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
                        <a href="{{ route('admin.fundraisers.index') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Fundraisers</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>
    <x-slot name="header">
        <div class="sm:flex">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                {{ __('Manage Fundraisers') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>
    @can('approve fundraisers')
        <div class="pt-12">
            <div class="w-full">
                <table id="categories-table">
                    <thead>
                        <tr>
                            <th>
                                <span class="flex items-center">
                                    Avatar
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Name
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Created Date
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Status
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
                        @forelse ($fundraisers as $fundraiser)
                            <tr>
                                <td><img src="{{ Storage::url($fundraiser->user->avatar) }}" alt=""
                                        class="rounded-2xl object-cover w-[120px] h-[90px]"></td>
                                <td>{{ $fundraiser->user->name }}</td>
                                <td>{{ date('d M Y', strtotime($fundraiser->created_at)) }}</td>
                                <td class="">
                                    @if ($fundraiser->is_active)
                                        <span
                                            class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                            ACTIVE
                                        </span>
                                    @else
                                        <span
                                            class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="">
                                    @if ($fundraiser->is_active)
                                        <div class="md:flex flex-row items-center gap-x-3">
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center  px-3 py-2 text-sm font-medium text-center text-white bg-red-500 hover:bg-red-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="md:flex flex-row items-center gap-x-3">
                                            <form
                                                action="{{ route('admin.fundraisers.update', ['fundraiser' => $fundraiser]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center  px-3 py-2 text-sm font-medium text-center text-white bg-indigo-500 hover:bg-indigo-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                                                    Approve
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="list-fundraisers py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col ">
                    <div class="item-card flex flex-col justify-between items-center gap-y-5">
                        <div class="flex flex-col text-center">
                            <h3 class="text-indigo-950 text-xl font-bold dark:text-white">Tebarkan Kebaikan</h3>
                            <p class="text-slate-500 text-base dark:text-white">Jadilah bagian dari kami untuk membantu <br>mereka yang
                                membutuhkan dana tambahan</p>
                        </div>
                        @if ($fundraiserStatus == 'Pending')
                            <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                PENDING
                            </span>
                        @elseif($fundraiserStatus == 'Active')
                            <a href="{{ route('admin.fundraisings.create') }}"
                                class="inline-flex items-center justify-center mt-6 px-3 py-2 text-sm font-medium text-center text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">Create a
                                Fundraising</a>
                        @else
                            <form action="{{ route('admin.fundraiser.apply') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center mt-6 px-3 py-2 text-sm font-medium text-center text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg bg-primary-700 hover:bg-primary-800 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700">
                                    Become Fundraiser
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>
