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
            Позитив
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
            Мотивация
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
            Энергия
          </label>
        </div>
        <!--        Четвертая мелодия вырезана из-за недостатка места на экране мобильных устройств-->
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
          class="btn btn-primary btn-icon-square rounded-circle audio-control"
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
            Спокойствие
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
            Романтика
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
            Космос
          </label>
        </div>
        <!--        Восьмая мелодия вырезана из-за недостатка места на экране мобильных устройств-->
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
      soundTrackSelectorPositionClass: "",
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
      } else {
        musicTest.pause();
      }
    },

    selectedSoundWork: function () {
      this.play = false;
      this.soundTrackSelectorPositionClass =
        "position-" + this.selectedSoundWork;
      this.$emit("set-work-mode-sound", this.selectedSoundWork);
    },

    selectedSoundRest: function () {
      this.play = false;
      this.soundTrackSelectorPositionClass =
        "position-" + (this.selectedSoundRest - 4);
      this.$emit("set-rest-mode-sound", this.selectedSoundRest);
    },

    soundMode: function () {
      this.play = false;
      if (this.soundMode === "work") {
        this.soundTrackSelectorPositionClass =
          "position-" + this.selectedSoundWork;
      }
      if (this.soundMode === "rest") {
        this.soundTrackSelectorPositionClass =
          "position-" + (this.selectedSoundRest - 4);
      }
    },
  },
};
</script>
