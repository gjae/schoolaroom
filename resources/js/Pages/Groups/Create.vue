<template>
    <app-layout>
        <jet-dialog-modal :show="showDialogModal" class="z-40">
            <template #title>
                Materias
            </template>
            <template #content>
                <div class="">
                    <div class="flex flex-row w-full justify-evenly">
                        <select v-model="matterSelected" id="" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-4/3 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                            <option disabled selected>Materias</option>
                            <option v-for="(matter, index) in matters" :value="matter" :key="matter.id">
                                {{ matter.name }} ({{ matter.code }})
                            </option>
                        </select>
                        <input type="time" v-model="timeFrom" id="" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-4/3 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                        <input type="time" v-model="timeTo" id="" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-4/3 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                      
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-button class="bg-blue-600 text-white" @click.native="onMatterSelected">
                    Aceptar
                </jet-button>
                <jet-danger-button @click.native="showDialogModal = false">
                    Cancelar
                </jet-danger-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="showGroupInfo" class="z-40">
            <template #title>
                Descripción
            </template>
            <template #content>
                <div class="">
                    <div class="flex flex-row justify-evenly w-full">
                        <input 
                            type="text" 
                            placeholder="Identificación el grupo"
                            id="group"
                            v-model="group"
                            :disabled="submited"
                            class="bg-gray-200 uppercase appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 "
                        >
                        <input 
                            type="number" 
                            name="" 
                            id="max_quotas"
                            v-model="max_quotas"
                            placeholder="Número de cupos"
                            :disabled="submited"
                            class="bg-gray-200 uppercase appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 "
                        >
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-button class="bg-blue-600 text-white" @click.native="sumitData" >
                    Aceptar
                </jet-button>
                <jet-danger-button @click.native="showGroupInfo = false">
                    Cancelar
                </jet-danger-button>
            </template>
        </jet-dialog-modal>
        <template #header>
            <div class="flex flex-row  flex-shirk justify-between">
                <Header text="Secciones" :breadcumbs="['Nueva']" />
            </div>
        </template>
        <div class="container mx-auto w-screen border-red content-center justify-center mt-6 pt-3 bg-white shadow">
            <div class="flex justify-end w-full px-5">
                <button @click="onSaveClick" class="bg-blue-400 block w-1/6 h-8 hover:bg-blue-600 hover:border-blue-600 border border-blue-500 rounded shadow text-white mb-2">
                    Guardar
                </button>
            </div>
            <div style="height: 32rem;">
                <vue-cal 
                    ref="vuecal"
                    class="w-full" 
                    hide-title-bar
                    hide-weekends
                    :time-from="6 * 60"
                    :time-to="20 * 60"
                    locale="es"
                    :time-step="30"
                    :editable-events="{ title: false, drag: true, resize: true, delete: true, create: true }"
                    :disable-views="['years', 'year', 'week', 'weeks', 'day', 'days', 'month']"
                    @cell-dblclick="addNewHourly"
                    :on-event-create="onCreateEvent"
                />
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout'
import JetDialogModal from '../../Jetstream/DialogModal'
import JetButton from '../../Jetstream/Button'
import JetDangerButton from '../../Jetstream/DangerButton'
import Header from '../Periods/Header'
import VueCal from 'vue-cal'
import moment from 'moment'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'

export default {
    props: ['period', 'pensum', 'matters'],
    components: {
        AppLayout,
        Header,
        VueCal,
        JetDialogModal,
        JetButton,
        JetDangerButton
    },
    data() {
        return {
            horary: [],
            showDialogModal: false,
            matterSelected: null,
            onCellHourly: null,
            timeFrom: null,
            timeTo: null,
            showGroupInfo: false,
            group:null,
            max_quotas: null,
            submited: false,
            mattersSelectables: this.matters.map(matter => ({
                id: matter.id,
                name: matter.name,
                code: matter.code
            })),
            customDaySplitLabels: [
                {label: "Lunes"},
                {label: "Martes"},
                {label: "Miercoles"},
                {label: "Jueves"},
                {label: "Viernes"},
            ]
        }
    },
    methods: {
        addNewHourly (e) {
            this.showDialogModal = true
            this.onCellHourly = e;
            console.log("HOUR", e)
        },
        onCreateEvent (event, deleteEventFunction) {

            this.horary.push(event)
            return event;
        },
        onMatterSelected(event, e) {
            this.showDialogModal = false;
            let from =new Date(`${this.onCellHourly.format('YYYY-MM-DD')} ${this.timeFrom}`);
            let to = new Date(`${this.onCellHourly.format('YYYY-MM-DD')} ${this.timeTo}`);
            let diff = Math.abs(moment(from).diff(to, 'minutes'))

            if (
                this.onCellHourly == null || 
                this.matterSelected == null || 
                this.timeTo == null || 
                this.timeFrom ==  null
            ) {
                this.resetEventData();

                return false;
            }

            if (this.timeFrom >= this.timeTo) {
                this.resetEventData();
                return;
            }

            this.$refs.vuecal.createEvent(
                from,
                diff,
                {
                    title: this.matterSelected.name, 
                    content: this.matterSelected.code,
                    class: 'bg-blue-300 text-white',
                    extra: {
                        ...this.matterSelected
                    }
                }
            )

            this.resetEventData()
        },
        resetEventData() {

            this.onCellHourly = null;
            this.matterSelected = null
            this.timeFrom = null,
            this.timeTo = null
        },
        onSaveClick() {
            this.showGroupInfo = true;
        },
        sumitData() {
            this.submited = true;

            let data = {
                pensum_id: this.pensum.id,
                period_id: this.period.id,
                group: this.group,
                max_quotas: this.max_quotas,
                horary: this.horary.filter(matter => !matter.deleting).map(matter => ({
                    curricular_unit_id: matter.extra.id,
                    init_time: {day: moment(matter.start).format("d"), hour: moment(matter.start).format("HH:mm")},
                    finish_time: {day: moment(matter.end).format("d"), hour: moment(matter.end).format("HH:mm")},
                    code: matter.extra.code 
                }))
            }

            console.log(data)

        }
    }
}
</script>
<style>
.vuecal__event.bg-blue-300 {
    --bg-opacity: 1;
    background-color: #a4cafe;
    background-color: rgba(164, 202, 254, var(--bg-opacity));
}
.vuecal__event.text-white {
    color: white;
    font-weight: bold;
}
</style>