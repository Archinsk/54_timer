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

    <div :class="mode + ' main-timer fw-bold'">
      {{ currentMinutes }} :
      {{ currentSeconds }}
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
};
</script>

<style scoped>
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
</style>
