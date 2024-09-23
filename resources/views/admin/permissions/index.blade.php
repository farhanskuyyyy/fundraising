<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Permissions') }}
            </h2>
            <a href="{{ route('admin.permissions.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse ($permissions as $permission)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Name</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $permission->name }}</h3>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ date('d M Y',strtotime($permission->created_at)) }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.permissions.edit',['permission' => $permission]) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Edit
                            </a>
                            <form action="{{ route('admin.permissions.destroy',['permission' => $permission]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-danger">Data Not Found</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
