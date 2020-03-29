<template>
    <div class="content">
        <div class="login" ><i class="tim-icons  icon-refresh-02 rotating"></i></div>
    </div>
</template>

<script>
export default {
    created(){
        this.$store.dispatch('destroyToken')
         .then(response => {
               this.$router.push('/home')
         })
    }
}
</script>