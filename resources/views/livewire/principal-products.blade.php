<div>
    <x-propios.principal>

        <div class="flex w-full mb-1 items-center">

            <div class="flex-1">
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-3/4"
                    placeholder="Busca un articulo" wire:model.live="buscar">
            </div>

            <div>
                @livewire('crear-product') {{-- ? Definimos el nombre de la vista para añadir el boton --}}
            </div>

        </div>


        {{-- ? Tabla --}}
        @if(count($producto))
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                            <i class="fa-solid fa-sort mr-2"></i>Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                            <i class="fa-solid fa-sort mr-2"></i> Stock
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('pvp')">
                            <i class="fa-solid fa-sort mr-2"></i>Precio
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                            <i class="fa-solid fa-sort mr-1"></i>DISPONIBLE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producto as $item)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <img src="{{ Storage::url($item->imagen) }}" class="w-16 md:w-32 max-w-full max-h-full"
                                    alt="Apple Watch">
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $item->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->descripcion }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    {{-- ? Boton para bajar stock --}}
                                    <button wire:click="bajarStock({{ $item->id }})"
                                        class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        <span class="sr-only">Quantity button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    {{-- ? Boton para bajar stock --}}
                                    <div>
                                        <input readonly id="first_product" @class([
                                            'bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500',
                                            'text-red-600' => $item->stock < 10,
                                            'text-green-600' => $item->stock > 10,
                                            'line-through font-bold' => $item->stock == 0,
                                        ])
                                            value="{{ $item->stock }}" required />
                                    </div>
                                    <button wire:click="subirStock({{ $item->id }})"
                                        class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        <span class="sr-only">Quantity button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $item->pvp }}€
                            </td>
                            <td @class([
                                'px-6 py-4 font-semibold text-gray-900 cursor-pointer',
                                'text-green-600' => $item->disponible == 'SI',
                                'text-red-600' => $item->disponible == 'NO',
                            ])
                                wire:click="actualizarDisponibleClick({{ $item->id }})">
                                {{ $item->disponible }}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="info({{ $item->id }})"><i
                                        class="fas fa-info text-blue-600 mr-2"></i></button>
                                <button wire:click="pedirConfirmacion({{ $item->id }})" type="submit"><i
                                        class="fas fa-trash text-red-600"></i></button>

                                <button wire:click="edit({{$item -> id}})"><i class="fas fa-edit text-yellow-600"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="my-2">
            {{ $producto->links() }}
        </div>
       @else
       <div>No se ha encontrado nada de lo que has buscado pesao</div> 
        @endif






        {{-- todo MODAL PARA INFO --}}
        @isset($Producto->imagen)
            <x-dialog-modal>
                <x-slot name="title">
                    Información del producto <span style="color: red"> {{ $Producto->nombre }}</span>
                </x-slot>
                <x-slot name="content">
                    <div
                        class="max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                        <img class="rounded-t-lg" src="{{ Storage::url($Producto->imagen) }}" alt="" />

                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $Producto->nombre }}</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                {{ $Producto->id }}
                            </p>
                            <p>Precio: <span>{{ $Producto->pvp }}</span></p>
                            <p>stock: <span>{{ $Producto->stock }}</span></p>
                            <p>Disponible: <span>{{ $Producto->disponible }}</span></p>

                            <span class="text-white"> ETIQUETAS</span>
                            <div class="flex flex-wrap">
                                {{-- ? tags proviene de ProducSeeder --}}
                                @foreach ($Producto->tags as $item)
                                    <div class="mr-1 p-1 rounded" style="background-color: {{ $item->color }}">
                                        {{ $item->nombre }}
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <button wire:click="salirModalInfo"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> Salir de la modal
                    </button>
                </x-slot>
            </x-dialog-modal>
        @endisset

        {{-- todo FIN  MODAL PARA INFO --}}


        {{-- TODO MODAL PARA UPDATE --}}

        @isset($form -> producto) {{-- * Que se abra cuando exista producto, mientras tanto no --}}
        <x-dialog-modal> {{-- ? Para que no se abra cada vez que se recarga la pagina --}}

            <x-slot name="title">
                Actualizando el producto <strong> {{$form -> producto -> nombre}} </strong>
            </x-slot>

            <x-slot name="content">
                <div class="mt-4 text-sm text-gray-600">
                    <label class="block font-medium text-sm text-gray-700" for="nombre">
                        Nombre
                    </label>
                    <input
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="nombre" placeholder="Nombre..." wire:model="form.nombre">
                    <x-input-error for="form.nombre"></x-input-error>

                    <label class="block font-medium text-sm text-gray-700 mt-4" for="descripcion">
                        Descripción
                    </label>
                    <textarea id="descripcion" placeholder="Descripcion..." class="w-full" wire:model="form.descripcion"></textarea>
                    <x-input-error for="form.descripcion"></x-input-error>

                    <label class="block font-medium text-sm text-gray-700 mt-4" for="stock">
                        Stock
                    </label>
                    <input
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        type="number" id="stock" placeholder="Stock..." step="1" min="0"
                        wire:model="form.stock">
                    <x-input-error for="form.stock"></x-input-error>

                    <label class="block font-medium text-sm text-gray-700 mt-4" for="pvp">
                        PVP (€)
                    </label>
                    <input
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        type="number" id="pvp" placeholder="Pvp..." step="0.01" min="0"
                        max="9999.99" wire:model="form.pvp">
                    <x-input-error for="form.pvp"></x-input-error>

                    <label class="block font-medium text-sm text-gray-700 mt-4" for="tags">
                        Etiquetas
                    </label>
                    <div class="flex flex-wrap">
                        @foreach ($misTags as $tag)
                            <input wire:model="form.tags" id="{{ $tag->id }}" type="checkbox"
                                value="{{ $tag->id }}"
                                class="w-4 h-4 text-blue-600 ml-2 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $tag->id }}"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-black-300 rounded ml-2"
                                style="background-color: {{ $tag->color }}">{{ $tag->nombre }}</label>
                        @endforeach
                    </div>
                    <x-input-error for="form.tags"></x-input-error>

                    <label class="block font-medium text-sm text-gray-700 mt-4" for="imagenU">
                        Imagen
                    </label>
                    <div class="relative w-full h-72 bg-gray-200 rounded">
                        <input type="file" wire:model="form.imagen" accept="image/*" hidden id="imagenU" />
                        <label for="imagenU"
                            class="absolute bottom-2 end-2 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                            <i class="fa-solid fa-upload mr-2"></i>Subir
                        </label>
                        @if ($form -> imagen)
                        {{-- ? Cargo la imagen que suba el usuario --}}
                            <img src="{{ $form -> imagen->temporaryUrl() }}"
                                class="p-1 rounded w-full h-full br-no-repeat bg-cover bg-center" />
                                @else
                                {{-- ? Cargo la iamgen que tenga el producto , este producto proviene de la clase UpdateForm --> public ?Product $producto = null; --}}

                                <img src="{{Storage::url( $form -> producto -> imagen)}}" class="p-1 rounded w-full h-full br-no-repeat bg-cover bg-center" />
                        @endif

                    </div>
                </div>
                <x-input-error for="form.imagenU"></x-input-error>

            </x-slot>

            <x-slot name="footer">
                <button wire:click="update" wire:loading.attr="disabled"
                    class="bg-blue-500 mr-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit"></i> Actualizar
                </button>

                <button wire:click="salirModalUpdate"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>

            </x-slot>


        </x-dialog-modal>
        @endisset






        {{-- TODO FIN  MODAL PARA UPDATE --}}


    </x-propios.principal>
</div>
