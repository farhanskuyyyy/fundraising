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
                        <a href="{{ route('admin.roles.index') }}"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Roles</a>
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
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Edit</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>
    <x-slot name="header">
        <div class="sm:flex">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                {{ __('Edit Role') }}</h1>
        </div>
        <hr class="my-2">
    </x-slot>

    <div class="pt-6">
        <div class="max-w-3xl px-3">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <form method="POST" action="{{ route('admin.roles.update', ['role' => $role]) }}">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="$role->name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- <div class="mt-4 grid grid-cols-3 gap-4">
                    @forelse ($permissions as $permission)
                        <div class="flex items-center mb-4">
                            <input {{ $permission->roles->count() > 0 ? 'checked' : '' }} id="permission-checkbox"
                                type="checkbox" value="{{ $permission->name }}" name="permissions[]"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="permission-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                        </div>
                    @empty
                        <p>Permission Not Found</p>
                    @endforelse
                </div> --}}

                <table class="permissionTable rounded-m overflow-hidden my-4 p-4 text-center">
                    <th class="px-4 py-4 text-slate-700 dark:text-white">
                        {{ __('Section') }}
                    </th>

                    <th class="px-4 py-4">
                        <input id="permission-checkbox" type="checkbox" value="" name="permissions[]"
                            class="grand_selectall w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="permission-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Select All') }}</label>
                    </th>

                    <th class="px-4 py-4 text-slate-700 dark:text-white">
                        {{ __('Available permissions') }}
                    </th>
                    <tbody>
                        @foreach ($permissions as $key => $group)
                            <tr class="py-8">
                                <td class="p-6">
                                    <b
                                        class="text-slate-700 dark:text-white">{{ ucfirst(str_replace('_', ' ', $key)) }}</b>
                                </td>
                                <td class="p-6" width="30%">
                                    <input id="permission-checkbox" type="checkbox" value="" name="permissions[]"
                                        class="selectall w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="permission-checkbox"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ __('Select All') }}</label>
                                </td>
                                <td class="p-6">
                                    <ul>
                                        @forelse($group as $permission)
                                            <li>
                                                <div class="mb-4">
                                                    <input id="permission-checkbox" type="checkbox"
                                                        {{ $permission->roles->count() > 0 ? 'checked' : '' }}
                                                        value="{{ $permission->name }}" name="permissions[]"
                                                        class="permissioncheckbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="permission-checkbox"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                                                </div>
                                            </li>
                                        @empty
                                            {{ __('No permission in this group !') }}
                                        @endforelse
                                    </ul>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex items-center justify-end mt-4">

                    <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="after">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $(function() {
                calcu_allchkbox();
                selectall();
            });
            $(".permissionTable").on('click', '.selectall', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').find('[type=checkbox]').prop('checked', true);
                } else {
                    $(this).closest('tr').find('[type=checkbox]').prop('checked', false);
                }
                calcu_allchkbox();
            });
            $(".permissionTable").on('click', '.grand_selectall', function() {
                console.log('asds');
                if ($(this).is(':checked')) {
                    $('.selectall').prop('checked', true);
                    $('.permissioncheckbox').prop('checked', true);
                } else {
                    $('.selectall').prop('checked', false);
                    $('.permissioncheckbox').prop('checked', false);
                }
            });

            function selectall() {
                $('.selectall').each(function(i) {
                    var allchecked = new Array();
                    $(this).closest('tr').find('.permissioncheckbox').each(function(index) {
                        if ($(this).is(":checked")) {
                            allchecked.push(1);
                        } else {
                            allchecked.push(0);
                        }
                    });
                    if ($.inArray(0, allchecked) != -1) {
                        $(this).prop('checked', false);
                    } else {
                        $(this).prop('checked', true);
                    }
                });
            }

            function calcu_allchkbox() {
                var allchecked = new Array();
                $('.selectall').each(function(i) {
                    $(this).closest('tr').find('.permissioncheckbox').each(function(index) {
                        if ($(this).is(":checked")) {
                            allchecked.push(1);
                        } else {
                            allchecked.push(0);
                        }
                    });
                });
                if ($.inArray(0, allchecked) != -1) {
                    $('.grand_selectall').prop('checked', false);
                } else {
                    $('.grand_selectall').prop('checked', true);
                }
            }
            $('.permissionTable').on('click', '.permissioncheckbox', function() {
                var allchecked = new Array;
                $(this).closest('tr').find('.permissioncheckbox').each(function(index) {
                    if ($(this).is(":checked")) {
                        allchecked.push(1);
                    } else {
                        allchecked.push(0);
                    }
                });
                if ($.inArray(0, allchecked) != -1) {
                    $(this).closest('tr').find('.selectall').prop('checked', false);
                } else {
                    $(this).closest('tr').find('.selectall').prop('checked', true);
                }
                calcu_allchkbox();
            });
        </script>
    </x-slot>
</x-app-layout>
