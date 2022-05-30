<template>
  <div id="sounds-settings">
    <div class="row gx-0">
      <div id="sound-work" :class="['col-5', { active: soundMode === 'work' }]">
        <div class="sound-mode-title">Работа</div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="sound-selector-work"
            id="sound-1"
            value="1"
          />
          <label class="sound-item" for="sound-1" @click="soundMode = 'work'">
            Jazzsteppa
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="sound-selector-work"
            id="sound-2"
            value="2"
          />
          <label class="sound-item" for="sound-2" @click="soundMode = 'work'">
            Prodigy
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="sound-selector-work"
            id="sound-3"
            value="3"
          />
          <label class="sound-item" for="sound-3" @click="soundMode = 'work'">
            Laibach
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundWork"
            class="btn-check"
            type="radio"
            name="sound-selector-work"
            id="sound-4"
            value="4"
          />
          <label class="sound-item" for="sound-4" @click="soundMode = 'work'">
            Ministry
          </label>
        </div>
      </div>
      <div
        id="sound-play"
        :class="[
          'col-2',
          { active: !!soundMode },
          soundTrackSelectorPositionClass,
        ]"
      >
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
            name="sound-selector-rest"
            id="sound-5"
            value="5"
          />
          <label class="sound-item" for="sound-5" @click="soundMode = 'rest'">
            Bohren & Club
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="sound-selector-rest"
            id="sound-6"
            value="6"
          />
          <label class="sound-item" for="sound-6" @click="soundMode = 'rest'">
            Burzum
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="sound-selector-rest"
            id="sound-7"
            value="7"
          />
          <label class="sound-item" for="sound-7" @click="soundMode = 'rest'">
            Carbon Based
          </label>
        </div>
        <div class="form-check">
          <input
            v-model="selectedSoundRest"
            class="btn-check"
            type="radio"
            name="sound-selector-rest"
            id="sound-8"
            value="8"
          />
          <label class="sound-item" for="sound-8" @click="soundMode = 'rest'">
            Max Richter
          </label>
        </div>
      </div>
      <div id="sound-mode-selector">
        <div class="additional-back"></div>
        <div
          :class="['sound-track-selector', soundTrackSelectorPositionClass]"
        ></div>
      </div>
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
      selectedSoundWork: this.config.workMode,
      selectedSoundRest: this.config.restMode,
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

    soundTrackSelectorPositionClass: function () {
      if (
        (this.selectedSoundWork === "1" && this.soundMode === "work") ||
        (this.selectedSoundRest === "5" && this.soundMode === "rest")
      ) {
        return "position-1";
      } else if (
        (this.selectedSoundWork === "2" && this.soundMode === "work") ||
        (this.selectedSoundRest === "6" && this.soundMode === "rest")
      ) {
        return "position-2";
      } else if (
        (this.selectedSoundWork === "3" && this.soundMode === "work") ||
        (this.selectedSoundRest === "7" && this.soundMode === "rest")
      ) {
        return "position-3";
      } else {
        return "position-4";
      }
    },
  },

  watch: {
    play: function () {
      let musicTest = document.getElementById("testmusic");
      if (this.play) {
        musicTest.play();
      } else {
        musicTest.pause();
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
  },
};
</script>
