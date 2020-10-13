<template>
    <div>
        <app-layout>
            <template #header>
                <Header :breadcumbs="['Nuevo']"/>
            </template>
            <div class="w-full h-auto flex justify-center py-8">
                <div class="border shadow bg-white w-3/5 h-full align-middle content-center rounded">
                    <div class="m-h-12 bg-gray-200 p-2">
                        <p>Nuevo periodo</p>
                    </div>
                    <div v-if="showError" class="bg-orange-100 border-t-4 border-rounded-b border-orange-500 text-orange-700 p-4" role="alert">
                        <p class="font-bold">Algo ha salido mal</p>
                        <ul>
                            <li v-for="(index, property) in $page.errors" :key="property">
                                {{  $page.errors[property].join(", ") }}
                            </li>
                        </ul>
                    </div>
                    <form method="post" action="/periods"  @submit.prevent="createPeriod">
                        <div class="container px-3 py-3 flex flex-col">
                            <div class="flex flex-row gap-4 justify-center w-full h-full content-center py-3">
                                <div class="w-1/4">
                                    <label for="degree_id">
                                        <strong>Grado del periodo</strong>
                                    </label>
                                    <select 
                                        v-model="createForm.degree_id" 
                                        id="degree_id" 
                                        :class="[
                                            'appearence-none w-full bg-gray-200 text-gray-700 border border-gray-200 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500',
                                            {
                                                'border-orange-700': $page.errors.degree_id
                                            }
                                        ]">
                                        <option selected>Elija una opción</option>
                                        <option v-for="degree in degrees" :key="degree.id" :value="degree.id">
                                            {{ degree.degree }}
                                        </option>
                                    </select>
                                </div>
                                <div class="w-4/6 ">
                                    <label for="period_description">
                                        <strong>Nombre del periodo</strong>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="period_description"
                                        v-model="createForm.period_description" 
                                        placeholder="Nombre del periodo"
                                        :class="['appearence-none rounded w-full leading-tight  uppercase block text-gray-700 bg-gray-200 border border-gray-200 py-3 px-4 pr-8 focus:outline-none focus:bg-white focus:border-gray-500  form-bold mb-2',
                                            {
                                                'border-orange-700': $page.errors.period_description
                                            }
                                        ]"
                                    >
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 px-7 my-1">
                                <div class="w-3/6">
                                    <label for="period_opened_at"><strong>Fecha de inicio del periodo</strong></label>
                                    <input 
                                        type="date" 
                                        :class="['appearence-none px-4 rounded w-full leading-tight uppercase bloc text-gray-200 bg-gray-200 text-gray-700 py-3 px4 focus:outline-none focus:bg-white focus:bg-white focus:border-gray-500 form-bold mb2',
                                            {
                                                'border-orange-700': $page.errors.period_opened_at
                                            }
                                        ]"
                                        v-model="createForm.period_opened_at"
                                    >
                                </div>
                                <div class="w-3/6">
                                    <label for="period_opened_at"><strong>Fecha de cierre del periodo</strong></label>
                                    <input 
                                        type="date" 
                                        :class="['appearence-none px-4 rounded w-full leading-tight uppercase bloc text-gray-200 bg-gray-200 text-gray-700 py-3 px4 focus:outline-none focus:bg-white focus:bg-white focus:border-gray-500 form-bold mb2',
                                            {
                                                'border-orange-700': $page.errors.period_closed_at
                                            }
                                        ]"
                                        v-model="createForm.period_closed_at"
                                    >
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 justify-center px-7 my-3">
                                <div class="w-full">
                                    <label for="pensum_id"><strong>Pensum del periodo</strong></label>
                                    <select 
                                        v-model="createForm.pensum_id" 
                                        id="pensum_id"
                                        :class="['appearence-none rounded w-full leading-tight  uppercase block text-gray-700 bg-gray-200 border border-gray-200 py-3 px-4 pr-8 focus:outline-none focus:bg-white focus:border-gray-500  form-bold mb-2',
                                            {
                                                'border-orange-700': $page.errors.pensum_id
                                            }
                                        ]"
                                    >
                                        <option v-for="pensum in pensums" :key="pensum.id" :value="pensum.id">
                                            {{ pensum.code }} ({{ pensum.degree }})
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 justify-center px-7 my-3">
                                <div class="w-full">
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block w-full"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </app-layout>
    </div>
</template>
<script>
import JetDialogModal from '../../Jetstream/DialogModal'
import JetSecondaryButton from '../../Jetstream/SecondaryButton'
import JetButton from '../../Jetstream/Button'
import JetFormSection from '../../Jetstream/FormSection'
import JetInput from '../../Jetstream/Input'
import JetLabel from '../../Jetstream/Label'
import JetInputError from '../../Jetstream/InputError'
import AppLayout from '../../Layouts/AppLayout'
import Header from './Header'

export default {
    props: ['degrees', 'pensums'],
    components: {
        JetDialogModal,
        JetSecondaryButton,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        AppLayout,
        Header
    },
    data() {
        return {
            createForm: {
                period_description: '',
                period_opened_at: null,
                period_closed_at: null,
                degree_id: null,
            }, 
        }
    },
    methods: {
        onCloseModal () {
            this.$emit("onDimiss");
        },
        createPeriod (e) {
            this.$inertia.post('/periods', this.createForm)
        }
    },
    computed: {
        showError () {
            
            for(let key in this.createForm) {
                if (typeof(this.$page.errors[key]) !== 'undefined')
                    return true
            }

            return false
        }
    },
    mounted() {
        console.log("MOUNTED")
        console.log(this.$pages)
    }
}
</script>