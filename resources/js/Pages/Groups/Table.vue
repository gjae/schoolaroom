<template>
    <div>
        <table class="w-full leading-normal">
            <thead>
                <tr>
                    <th
                        v-show="'seccion' in columns"
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Sección
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Periodo
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Pensum
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Profesor
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="group in groups" :key="group.id" class="bg-white hover:bg-gray-100 cursor-pointer">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p 
                                    class="font-bold text-gray-900 whitespace-no-wrap">
                                    {{ group.group }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            {{ group.period.period_description }}
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            {{ group.pensum.code }} ({{ group.pensum.degree.degree }})
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <span
                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden
                                :class="{
                                    absolute: true, 
                                    'inset-0': true, 
                                    'bg-green-200': true, 
                                    'bg-red-200': false,
                                    'opacity-50': true,
                                    'rounded-full': true
                                }"></span>
                            <span class="relative">Sin asignar</span>
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
</template>
<script>
export default {
    props: ['groups', 'columns']
    
}
</script>