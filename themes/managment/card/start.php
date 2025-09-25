<?php $this->layout("layout"); ?>
<div class="flex flex-col h-screen w-screen md:w-auto">

    <header class="p-4 px-6 flex justify-start border-b border-gray-200 mt-8 md:mt-0">
        <h1 class="font-semibold text-black">Cartão Alimentação</h1>
    </header>

    <header class="w-screen md:w-auto border-b border-gray-200 md:flex md:justify-start mt-6 md:mt-0">
        <div class="flex flex-col md:flex-row px-6"> 
            <a href="" class="py-2 px-6 cursor-pointer font-semibold border-b-2 border-green-800 duration-all transition-300 w-full md:w-auto text-green-800">Novo</a>
            <a href="" class="py-2 px-6 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">Emergencial</a>
            <a href="" class="py-2 px-6 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">2° Via</a>
            <a href="" class="py-2 px-6 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">Recarga</a>
            <a href="" class="py-2 px-6 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">Recarga extra</a> 
        </div>
    </header>

    <header class="w-screen md:w-auto border-b border-gray-200 md:flex md:justify-start mt-6 md:mt-0">
        <div class="flex flex-col md:flex-row px-6"> 
            <a href="" class="py-2 px-4 cursor-pointer font-semibold border-b-2 border-green-800 duration-all transition-300 w-full md:w-auto text-sm text-green-800">Solicitados</a>
            <a href="" class="py-2 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Enviados</a>
            <a href="" class="py-2 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Recarga</a>
            <a href="" class="py-2 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Carregados</a>
        </div>
    </header>

    <header class="flex flex-col gap-4 md:gap-0 md:flex-row md:items-center md:justify-between border-b border-gray-200 p-6">
        <div class="flex items-center gap-2 w-[700px]">
            <input type="text" class="p-2 px-4 bg-white w-full rounded-full border border-gray-300" placeholder="Pesquise por beneficiários. Ex:João Da Silva...">
            <button class="border rounded-full p-2 bg-black text-white cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
        </div>
        <div class="">
            <a href="" class="rounded-md bg-blue-500 text-white py-2 px-4 cursor-pointer font-semibold w-full">Novo cartão</a>
        </div>
    </header>
    
    <main class="p-6 h-full">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 h-full">
            <div class="md:col-span-2 border border-gray-200">
                
                <!-- tabel stays here -->
                <div>
                    <title>Beneficiários</title>
                    <table>
                        <tr>
                            <th>Nome</th>
                            <th>Nome</th>
                        </tr>
                        <tr>
                            <td>Fulano de tal</td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="md:col-span-1 bg-gray-100">
                
            </div>
        </div>
    </main>
</div>
