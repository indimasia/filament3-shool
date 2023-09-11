<x-filament::breadcrumbs :breadcrumbs="[
    '/admin/students' => 'Students',
    '' => 'List',
]" />
<div class="flex justify-between mt-1">
    <div class="font-bold text-3xl">
        Students
    </div>
    <div class="">
        {{$data}}
    </div>
</div>
<div class="">
    <form wire:submit="save" class="w-full max-w-sm flex mt-2">
        <div class="mb-4">
            <label for="fileInput" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
                Pilih Berkas
            </label>
            <input 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                wire:model="file"
                id="fileInput"
                type="file" />
        </div>
        <div class="flex items-center justify-between mt-3">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline fi-btn-color-primary" type="submit">
                Upload
            </button>
        </div>
    </form>
</div>