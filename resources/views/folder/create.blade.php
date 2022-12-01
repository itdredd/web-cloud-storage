<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Folder create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Folder name</label>
                            <input type="name" class="form-control" id="name" name="name" placeholder="Folder name">
                        </div>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </form>
                   {{-- <form method="post">
                        @csrf
                        <label for="name">Name of folder:</label>
                        <input type="name" id="name" name="name"><br><br>
                        <input type="submit" value="Submit">
                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
