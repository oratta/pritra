<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-text title>
            <div class="display-2 font-weight-thick">Weekly theme</div>
          </v-card-text>
          <v-textarea
                  placeholder="write your weekly theme"
                  auto-grow
                  clearable
                  outlined
                  rounded
          >
          </v-textarea>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <HabitDuration></HabitDuration>
    </v-row>
  </v-container>
</template>

<script>
import HabitDuration from '../components/HabitDuration'

export default {
  components: {
    HabitDuration
  }
}
</script>
