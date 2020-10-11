<template>
    <app-layout>
        <template #header>
            <Header />
        </template>

        <div>
            <div class="flex justify-center mx-auto py-4 px-3 h-screen">
                <div class="w-4/5 bg-white rounded border-0 border-gray-600 shadow min-h-full">
                    <div class="px-3 py-3 bg-gray-100">
                        <jet-button class="bg-green-500" @click.native="createPeriodClick()">
                            Nuevo periodo
                        </jet-button>
                    </div>
                    <table class="w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ID
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Descripción
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Desde - Hasta
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="period in periods" :key="period.id">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ period.id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ period.opened_at }} - {{ period.closed_at }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span
                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden
                                            :class="{
                                                absolute: true, 
                                                'inset-0': true, 
                                                'bg-green-200': period.opened, 
                                                'bg-red-200': !period.opened,
                                                'opacity-50': true,
                                                'rounded-full': true
                                            }"></span>
                                        <span class="relative">{{ periodStatus(period.opened) }}</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </app-layout>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout'
import JetButton from '../../Jetstream/Button'
import JetNavLink from '../../Jetstream/NavLink'
import Header from './Header'

export default {
    props: ['periods'],
    components: {
        AppLayout,
        JetButton,
        JetNavLink,
        Header
    },
    data() {
        return  {
            modalCreateOpen: false
        }
    },
    methods: {
        periodStatus(opened) {
            if (opened) return "Abierto";
            
            return "Cerrado";
        },
        createPeriodClick () {
            this.$inertia.visit('/periods/create')
        }
    }
}
</script>