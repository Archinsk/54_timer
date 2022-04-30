<template>
  <div id="sounds-settings">
    <SoundsNavbar @sound-select="soundMode = $event" />

    <div v-if="soundMode === 'work'" id="sound-selector-work">
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
        <label class="sound-item" for="melody-1"> Мелодия №1 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
        <label class="sound-item" for="melody-2"> Мелодия №2 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
        <label class="sound-item" for="melody-3"> Мелодия №3 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
        <label class="sound-item" for="melody-4"> Мелодия №4 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
      </div>
      <div class="form-check">
        <input
          v-model="selectedSoundWork"
          class="btn-check"
          type="radio"
          name="melody-selector-work"
          id="melody-5"
          value="5"
        />
        <label class="sound-item" for="melody-5"> Мелодия №5 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
      </div>
    </div>

    <div v-if="soundMode === 'rest'" id="sound-selector-rest">
      <div class="form-check">
        <input
          v-model="selectedSoundRest"
          class="btn-check"
          type="radio"
          name="melody-selector-rest"
          id="melody-6"
          value="6"
          checked
        />
        <label class="sound-item" for="melody-6"> Мелодия №6 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
        <label class="sound-item" for="melody-7"> Мелодия №7 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
        <label class="sound-item" for="melody-8"> Мелодия №8 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
      </div>
      <div class="form-check">
        <input
          v-model="selectedSoundRest"
          class="btn-check"
          type="radio"
          name="melody-selector-rest"
          id="melody-9"
          value="9"
        />
        <label class="sound-item" for="melody-9"> Мелодия №9 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
      </div>
      <div class="form-check">
        <input
          v-model="selectedSoundRest"
          class="btn-check"
          type="radio"
          name="melody-selector-rest"
          id="melody-10"
          value="10"
        />
        <label class="sound-item" for="melody-10"> Мелодия №10 </label>
        <button
          class="audio-control btn btn-primary btn-icon-square rounded-circle"
          @click="play = !play"
        >
          <span :class="['anicons-icons', play ? 'playing' : '']">H</span>
        </button>
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
import SoundsNavbar from "./SoundsNavbar";
export default {
  name: "AudioSettings",
  components: { SoundsNavbar },

  data() {
    return {
      soundMode: "work",
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
    },

    selectedSoundRest: function () {
      this.play = false;
    },

    soundMode: function () {
      this.play = false;
    },
  },
};
</script>
