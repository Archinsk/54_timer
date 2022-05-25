<template>
  <div id="sounds-settings">
    <div class="row gx-2">
      <div id="sound-work" :class="['col-5', { active: soundMode === 'work' }]">
        <div class="sound-mode-title">Работа</div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="melody-selector-work"
            id="melody-1"
            value="1"
            checked
          />
          <label class="sound-item" for="melody-1" @click="soundMode = 'work'">
            Jazzsteppa
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="melody-selector-work"
            id="melody-2"
            value="2"
          />
          <label class="sound-item" for="melody-2" @click="soundMode = 'work'">
            Prodigy
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="melody-selector-work"
            id="melody-3"
            value="3"
          />
          <label class="sound-item" for="melody-3" @click="soundMode = 'work'">
            Laibach
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="melody-selector-work"
            id="melody-4"
            value="4"
          />
          <label class="sound-item" for="melody-4" @click="soundMode = 'work'">
            Ministry
          </label>
        </div>
      </div>
      <div id="sound-play" :class="['col-2', { active: !!soundMode }]">
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
      </div>
      <div id="sound-rest" :class="['col-5', { active: soundMode === 'rest' }]">
        <div class="sound-mode-title">Отдых</div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="melody-selector-rest"
            id="melody-5"
            value="5"
            checked
          />
          <label class="sound-item" for="melody-5" @click="soundMode = 'rest'">
            Bohren & Club
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="melody-selector-rest"
            id="melody-6"
            value="6"
          />
          <label class="sound-item" for="melody-6" @click="soundMode = 'rest'">
            Burzum
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="melody-selector-rest"
            id="melody-7"
            value="7"
          />
          <label class="sound-item" for="melody-7" @click="soundMode = 'rest'">
            Carbon Based
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="melody-selector-rest"
            id="melody-8"
            value="8"
          />
          <label class="sound-item" for="melody-8" @click="soundMode = 'rest'">
            Max Richter
          </label>
        </div>
      </div>
      <div id="sound-mode-selector"></div>
    </div>

    <audio
      id="testmusic"
      :src="selectedSource"
      type="audio/mpeg"
      volume="0.5"
    ></audio>
  </div>
</template>

<script>
export default {
  name: "AppSettingsTabSounds",
  props: ["config"],

  data() {
    return {
      soundMode: "",
      play: false,
      selectedSoundWork: "3",
      selectedSoundRest: "8",
    };
  },

  computed: {
    selectedSource: function () {
      if (this.soundMode === "work") {
        return "./sounds/" + this.selectedSoundWork + ".mp3";
      } else {
        return "./sounds/" + this.selectedSoundRest + ".mp3";
      }
    },
  },

  watch: {
    play: function () {
      let musicTest = document.getElementById("testmusic");
      if (this.play) {
        musicTest.play();
        console.log("play");
      } else {
        musicTest.pause();
        console.log("pause");
      }
    },

    selectedSoundWork: function () {
      this.play = false;
      this.$emit("set-work-mode-sound", this.selectedSoundWork);
    },

    selectedSoundRest: function () {
      this.play = false;
      this.$emit("set-rest-mode-sound", this.selectedSoundRest);
    },

    soundMode: function () {
      this.play = false;
    },
  },

  beforeMount() {
    this.selectedSoundWork = this.config.workMode;
    this.selectedSoundRest = this.config.restMode;
  },
};
</script>
