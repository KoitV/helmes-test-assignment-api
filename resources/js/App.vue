<template>
  <v-app>
    <v-main>
      <v-container>
        <router-view/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import {VApp, VMain, VContainer} from "vuetify/lib";

export default {
  name: "App",
  components: {
    VApp,
    VMain,
    VContainer
  }
}
</script>

<style scoped>

</style>