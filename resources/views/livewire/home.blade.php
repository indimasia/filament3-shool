<div>
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6 text-center">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit="save">
        {{ $this->form }}
        <button 
            class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
            type="submit">
            Save
        </button>
    </form>
</div>
