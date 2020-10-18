<template>
    <app-layout>
        <template #header>
            <Header />
        </template>

        <div>
            <div class="flex justify-center mx-auto py-4 px-3 h-screen flex-row">
                
                <div class="w-4/5 bg-white rounded border-0 border-gray-600 shadow min-h-full">
                    <div v-if="$page.success" class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>{{ $page.success }}</p>
                    </div>
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
                                <th
                                   class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="period in periods" :key="period.id" class="bg-white hover:bg-gray-100 cursor-pointer" v-on:click="editPeriodClick(period.id)">
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ period.id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ period.description }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ period.opened_at }} - {{ period.closed_at }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
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
                                <td class="">
                                    <svg class="text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
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
import { InertiaProgress } from '@inertiajs/progress'
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
        },
        editPeriodClick (id) {
            InertiaProgress.init()
            this.$inertia.visit(`/periods/${id}/edit`, {
                onProgress: progress => {
                    console.log("progress", progress)
                    InertiaProgress.init({ delay: 250, showSpinner: false})
                },
            })
        }
    }
}
</script>