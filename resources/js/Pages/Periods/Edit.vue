<template>
    <div>
        <app-layout>
            <template #header>
                <Header :breadcumbs="['Editar']" />
            </template>
            <div class="container p-auto justify-center">
                <div class="sm:h-64 h-screen w-screen mt-0 sm:mt-8 flex flex-row justify-center">
                    <div class="bg-white w-screen rounded shadow h-full sm:w-screen md:w-screen lg:w-3/5 ">
                       <ul class="flex border-b">
                            <li :class="['mr-1', {'-mb-px mr-1': tabs.active == 'periodo'}]" @click="tabs.active = 'periodo'">
                                <a :class="['bg-white inline-block py-2 px-4 text-blue-700 font-semibold', {'rounded-t border-t border-r': tabs.active == 'periodo'}]" href="#">Periodo</a>
                            </li>
                            <li :class="['mr-1', {'-mb-px mr-1': tabs.active == 'secciones'}]" @click="tabs.active = 'secciones'">
                                <a :class="['bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold', {'rounded-t border-t border-r border-l': tabs.active == 'secciones'}]" href="#">
                                    Secciones
                                </a>
                            </li>
                            <li :class="['mr-1', {'-mb-px mr-1': tabs.active == 'lists'}]" @click="tabs.active = 'lists'">
                                <a :class="['bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold', {'rounded-t border-t border-r border-l': tabs.active == 'lists'}]" href="#">
                                    Listas de inscripción
                                </a>
                            </li>
                            <li class="mr-1">
                                <a class="bg-white inline-block py-2 px-4 text-gray-400 font-semibold" href="#">Tab</a>
                            </li>
                        </ul>
                        <div id="tabs">
                            <div v-show="tabs.active =='periodo'">
                                <h1>Perido</h1>
                            </div>
                            <div v-show="tabs.active =='secciones'">
                                <Table :columns="['seccion', 'pensum', 'teacher']" :groups="period.groups"/>
                                <div class="w-full p-3 justify-center">
                                    <button @click="createNewGroup()" class="bg-blue-500 p-4 text-white rounded hover:bg-blue-700 w-full font-bold border-blue-500 focus:border-blue-500">
                                        Agregar nueva seccion
                                    </button>
                                </div>
                            </div>
                            <div v-show="tabs.active =='lists'">
                                <h1>lists</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout'
import Header from './Header'
import Table from '../Groups/Table'
export default {
    props: ['period'],
    components: {
        AppLayout,
        Header,
        Table
    },
    data() {
        return {
            tabs: {
                active: "periodo"
            }
        }
    },
    mounted() {
        console.log(this.period)
    },
    methods: {
        createNewGroup() {
            this.$inertia.visit(this.newSeccionLink)
        }
    },
    computed: {
        newSeccionLink() {
            return `/periods/${this.period.id}/groups/create`
        }
    }
    
}
</script>