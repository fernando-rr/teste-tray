<template>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="mx-auto p-6 lg:p-8">
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <vendedores-list />
                    <vendas-list />
                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                    <div class="flex items-center gap-4">
                        <a href="https://github.com/fernando-rr/teste-tray" class="link-github group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            <img src="https://github.com/fluidicon.png" class="logo-git">
                            Github
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VendasListComponent from "./Vendas/VendasListComponent.vue";
    import VendedoresListComponent from "./Vendedores/VendedoresListComponent.vue";

    export default {
        components: {
            'vendas-list': VendasListComponent,
            'vendedores-list': VendedoresListComponent,
        }
    }
</script>
