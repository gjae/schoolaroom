<template>
    <div>
        {{ text }} / {{ getBreadcumbs }}
    </div>
</template>
<script>
export default {
    props: {
        text: {
            type: String,
            default: 'Periodos academicos'
        },
        breadcumbs: {
            default: null
        }
    },
    computed: {
        getBreadcumbs () {
            if (this.breadcumbs === null) 
                return ""
                
            return this.breadcumbs.join(' / ')
        }
    }
}
</script>