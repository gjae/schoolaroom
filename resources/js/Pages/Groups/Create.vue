<template>
    <app-layout>
        <template #header>
            <Header text="Secciones" :breadcumbs="['Nueva']" />
        </template>
        <div class="container mx-auto h-auto w-screen border border-red content-center justify-center py-4">
            <div class="h-full w-full justify-center items-center px-2">
                <div class="grid grid-rows-14 h-auto p-8 bg-white">
                    <section id="matters">
                        <div class="grid gird-rows-1 border border-orange-700 ">
                            <div v-for="matter in matters" :key="matter.id">
                                <div class="bg-green-200 shadow text-center text-green-700 font-bold rounded p-4">
                                    {{ matter.name }}
                                </div>

                                <section id="hourly">
                                    <div class="h-64 grid grid-rows-1 text-center grid-flow-col">
                                        <div class="bg-orange-200 border border-orange-300 grid grid-cols">
                                            <h1 class="font-bold text-center">Lunes</h1>
                                            <button @click="addDetails('lunes', matter.code)" class="bg-orange-400 text-orange-500 rounded px-3 py-1 border border-white h-9">
                                                <p class="text-white font-bold">Agregar</p>
                                            </button>
                                            <div class="grid grid-cols-2 grid-flow-row gap-1 w-full">
                                                <ul>
                                                    <li v-for="(index, schedule) in showDetailFrom('lunes', matter.code)" :key="index">
                                                        <input type="time" name="init_time" class="h-6" v-model="mattersSchedule[matter.code]['lunes'][index].init_time">
                                                        <input type="time" name="" id="" class="h-6" v-model="mattersSchedule[matter.code]['lunes'][index].finish_time">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h1 class="bg-blue-200 border border-blue-300">Martes</h1>
                                        <h1 class="bg-green-200 border border-green-300">Miercoles</h1>
                                        <h1 class="bg-yellow-200 border border-yellow-300">Jueves</h1>
                                        <h1>Viernes</h1>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout'
import Header from '../Periods/Header'

export default {
    props: ['period', 'pensum', 'matters'],
    components: {
        AppLayout,
        Header
    },
    data() {
        let mattersSchedule = [];
        this.matters.forEach((matter) => {
            mattersSchedule[matter.code] = {
                lunes: [],
                martes: [],
                miercoles: [],
                jueves: [],
                viernes: []
            }
        })
        return {
            mattersSchedule
        }
    },
    methods: {
        addDetails(day, matter) {
            this.mattersSchedule[matter][day].push({
                init_time: null,
                finish_time: null
            })
            console.log(`${matter}/${day}`, this.mattersSchedule[matter][day] )
        },
        showDetailFrom(day, matter) {
            return this.mattersSchedule[matter][day]
        }
    },
    mounted() {
        console.log(this.mattersSchedule[this.matters[0].code])
    }
    
}
</script>