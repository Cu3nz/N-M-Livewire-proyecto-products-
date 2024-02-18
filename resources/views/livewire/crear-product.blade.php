<div>
    {{-- todo Seteamos la variable abrirModalCreate a true gracias al metodo magico --}}
    <x-button wire:click="$set('abrirModalCreate' , true)" ><i class="fas fa-add mr-2"></i>Crear un nuevo producto</x-button>

    <x-dialog-modal wire:model="abrirModalCreate"> {{-- ? Para que no se abra cada vez que se recarga la pagina --}}

        <x-slot name="title">
            Titulo
        </x-slot>

        <x-slot name="content">
            <div class="mt-4 text-sm text-gray-600">
                <label class="block font-medium text-sm text-gray-700" for="nombre">
                    Nombre
                </label>
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    id="nombre" placeholder="Nombre..." wire:model="nombre">
                <x-input-error for="nombre"></x-input-error>

                <label class="block font-medium text-sm text-gray-700 mt-4" for="descripcion">
                    Descripción
                </label>
                <textarea id="descripcion" placeholder="Descripcion..." class="w-full" wire:model="descripcion"></textarea>
                <x-input-error for="descripcion"></x-input-error>

                <label class="block font-medium text-sm text-gray-700 mt-4" for="stock">
                    Stock
                </label>
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    type="number" id="stock" placeholder="Stock..." step="1" min="0"
                    wire:model="stock">
                <x-input-error for="descripcion"></x-input-error>

                <label class="block font-medium text-sm text-gray-700 mt-4" for="pvp">
                    PVP (€)
                </label>
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    type="number" id="pvp" placeholder="Pvp..." step="0.01" min="0" max="9999.99"
                    wire:model="pvp">
                <x-input-error for="pvp"></x-input-error>

                <label class="block font-medium text-sm text-gray-700 mt-4" for="tags">
                    Etiquetas
                </label>
                <div class="flex flex-wrap">
                    @foreach ($misTags as $tag)
                        <input wire:model="tags" id="{{$tag -> id}}" type="checkbox" value="{{$tag -> id}}" 
                            class="w-4 h-4 text-blue-600 ml-2 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{$tag -> id}}"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-black-300 rounded ml-2" style="background-color: {{$tag -> color}}">{{$tag -> nombre}}</label>
                    @endforeach
                </div>
                <x-input-error for="tags"></x-input-error>

                <label class="block font-medium text-sm text-gray-700 mt-4" for="imagenC">
                    Imagen
                </label>
                <div class="relative w-full h-72 bg-gray-200 rounded">
                    <input type="file" wire:model="imagen" accept="image/*" hidden id="imagenC" />
                    <label for="imagenC"
                        class="absolute bottom-2 end-2 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-upload mr-2"></i>Subir
                    </label>
                    @if ($imagen)
                        <img src="{{ $imagen->temporaryUrl() }}"
                            class="p-1 rounded w-full h-full br-no-repeat bg-cover bg-center" />
                    @endif

                </div>
            </div>
            <x-input-error for="ImagenC"></x-input-error>

        </x-slot>

        <x-slot name="footer">
            <button wire:click="store" wire:loading.attr="disabled"
                class="bg-blue-500 mr-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-save"></i> GUARDAR
            </button>

            <button wire:click="salirModalCreate"
                class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-xmark"></i> CANCELAR
            </button>

        </x-slot>


    </x-dialog-modal>


</div>
