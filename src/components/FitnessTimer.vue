<template>
  <div>
    <div class="d-flex justify-content-center">
      <div class="mx-2">
        Режим: <b>{{ mode }}</b>
      </div>
      <div class="mx-2">
        Прогресс: <b>{{ play }}</b>
      </div>
    </div>

    <div :class="mode + ' main-timer fw-bold position-relative'">
      <span>{{ currentMinutesFirstDigit }}</span>
      <span>{{ currentMinutesSecondDigit }}</span>
      :
      <span>{{ currentSecondsFirstDigit }}</span>
      <Transition name="fade">
        <span v-if="secondsSecondDigitTrigger" class="position-absolute">{{
          currentSecondsSecondDigit
        }}</span>
        <span v-else class="position-absolute">{{
          currentSecondsSecondDigit
        }}</span>
      </Transition>
    </div>
    <div>
      Время:
      <b>
        {{ pastMinutes }} : {{ pastSeconds }} / {{ futureMinutes }} :
        {{ futureSeconds }} / {{ totalTimeMinutes }} : {{ totalTimeSeconds }}</b
      >
    </div>

    <div class="d-flex justify-content-center mt-2 mb-3">
      <div class="mx-2">
        Цикл: <b>{{ currentCycle }} / {{ config.cycles }}</b>
      </div>
      <div class="mx-2">
        Раунд: <b>{{ currentRound }} / {{ config.rounds }}</b>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FitnessTimer",
  props: ["config", "actual", "mode", "play", "pastTime"],
  data() {
    return {
      secondsSecondDigitTrigger: false,
    };
  },

  computed: {
    totalTime: function () {
      return (
        this.config.prepTime +
        ((this.config.workTime + this.config.restTime) * this.config.rounds -
          this.config.restTime +
          this.config.clearTime) *
          this.config.cycles -
        this.config.clearTime
      );
    },
    totalTimeMinutes: function () {
      return Math.floor(this.totalTime / 60);
    },
    totalTimeSeconds: function () {
      return this.totalTime % 60;
    },

    configPrepMinutes: function () {
      return Math.floor(this.config.prepTime / 60);
    },
    configPrepSeconds: function () {
      return this.config.prepTime % 60;
    },
    configWorkMinutes: function () {
      return Math.floor(this.config.workTime / 60);
    },
    configWorkSeconds: function () {
      return this.config.workTime % 60;
    },
    configRestMinutes: function () {
      return Math.floor(this.config.restTime / 60);
    },
    configRestSeconds: function () {
      return this.config.restTime % 60;
    },
    configClearMinutes: function () {
      return Math.floor(this.config.clearTime / 60);
    },
    configClearSeconds: function () {
      return this.config.clearTime % 60;
    },

    prepMinutes: function () {
      return Math.floor(this.actual.prepTime / 60);
    },
    prepSeconds: function () {
      return this.actual.prepTime % 60;
    },
    workMinutes: function () {
      return Math.floor(this.actual.workTime / 60);
    },
    workSeconds: function () {
      return this.actual.workTime % 60;
    },
    restMinutes: function () {
      return Math.floor(this.actual.restTime / 60);
    },
    restSeconds: function () {
      return this.actual.restTime % 60;
    },
    clearMinutes: function () {
      return Math.floor(this.actual.clearTime / 60);
    },
    clearSeconds: function () {
      return this.actual.clearTime % 60;
    },

    currentMinutes: function () {
      if (this.mode === "prep") {
        return this.prepMinutes;
      } else if (this.mode === "work") {
        return this.workMinutes;
      } else if (this.mode === "rest") {
        return this.restMinutes;
      } else {
        return this.clearMinutes;
      }
    },
    currentMinutesFirstDigit: function () {
      return Math.floor(this.currentMinutes / 10);
    },
    currentMinutesFirstDigitNext: function () {
      return (this.currentMinutesFirstDigit + 1) % 10;
    },
    currentMinutesSecondDigit: function () {
      return Math.floor(this.currentMinutes % 10);
    },
    currentMinutesSecondDigitNext: function () {
      return (this.currentMinutesSecondDigit + 1) % 10;
    },
    currentSeconds: function () {
      if (this.mode === "prep") {
        return this.prepSeconds;
      } else if (this.mode === "work") {
        return this.workSeconds;
      } else if (this.mode === "rest") {
        return this.restSeconds;
      } else {
        return this.clearSeconds;
      }
    },
    currentSecondsFirstDigit: function () {
      return Math.floor(this.currentSeconds / 10);
    },
    currentSecondsFirstDigitNext: function () {
      return (this.currentSecondsFirstDigit + 1) % 10;
    },
    currentSecondsSecondDigit: function () {
      return Math.floor(this.currentSeconds % 10);
    },
    currentSecondsSecondDigitNext: function () {
      return (this.currentSecondsSecondDigit + 1) % 10;
    },
    currentTimeArray: function () {
      return [
        { id: 0, value: this.currentMinutesFirstDigit },
        { id: 1, value: this.currentMinutesSecondDigit },
        { id: 2, value: ":" },
        { id: 3, value: this.currentSecondsFirstDigit },
        { id: 4, value: this.currentSecondsSecondDigit },
      ];
    },

    currentRound: function () {
      return this.config.rounds - this.actual.rounds;
    },
    currentCycle: function () {
      return this.config.cycles - this.actual.cycles;
    },

    pastMinutes: function () {
      return Math.floor(this.pastTime / 60);
    },
    pastSeconds: function () {
      return this.pastTime % 60;
    },
    futureTime: function () {
      return this.totalTime - this.pastTime;
    },
    futureMinutes: function () {
      return Math.floor(this.futureTime / 60);
    },
    futureSeconds: function () {
      return this.futureTime % 60;
    },
  },

  watch: {
    currentSecondsSecondDigit: function () {
      this.secondsSecondDigitTrigger = !this.secondsSecondDigitTrigger;
    },
  },
};
</script>

<style lang="scss" scoped>
.test {
  display: inline-block;
  span {
    display: inline-block;
    width: 6rem;
    height: 6rem;
    background-color: orangered;
    font-size: 4rem;
    font-weight: 700;
  }
}

.prep {
  background-color: darkviolet;
}

.work {
  background-color: mediumorchid;
}

.rest {
  background-color: rebeccapurple;
}

.clear {
  background-color: indigo;
}

.finish {
  background-color: blueviolet;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s;
}
.fade-enter-from /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(-4rem);
}
.fade-leave-to /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(4rem);
}

.time-enter-active,
.time-leave-active {
  transition: all 0.5s;
}
.time-enter-from /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(-4rem);
}
.time-leave-to /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(4rem);
}
</style>
