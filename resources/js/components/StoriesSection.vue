<template>
  <div class="flex-row d-flex">
    <div
      v-for="(profile, index) in storiesList"
      :key="'profile-' + profile.id"
      @click.capture="showStories(profile, index)"
      :class="classObj(profile, index)"
    >
      <img class="rounded-circle" :src="'/storage/' + profile.image" />
      <p
        v-if="!profilePage"
        :style="{
          position: 'absolute',
          bottom: '-20px',
          fontWeight: 'bold',
          left: '0',
          right: 0,
          width: 'min-content',
          margin: '0 auto',
        }"
      >
        {{ profile.user.username }}
      </p>
    </div>

    <div @click.self="exit" v-if="currentStory" class="stories-modal">
      <div class="stories-card">
        <div class="story-bars">
          <span
            class="story-bar"
            :class="{ '--active': bar == i }"
            v-for="(storyBar, i) in bars"
            :key="i"
          ></span>
        </div>
        <div
          class="profile-info mb-2"
          @click="goto('/' + profile.user.username)"
        >
          <img :src="'/storage/' + profile.image" />{{ profile.user.username }}
        </div>
        <div
          @pointerdown="pauseTime"
          @mouseover="pauseTime"
          @pointerleave="resumeTime"
          @pointerup="resumeTime"
          class="story-player"
        >
          <video
            v-if="profile.user_stories[bar].type == 'video'"
            :src="'/storage/' + profile.user_stories[bar].story"
          />
          <img v-else :src="'/storage/' + profile.user_stories[bar].story" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { StoryActions } from "../store/modules/stories";

export default {
  name: "stories-section",
  props: {
    stories: Object,
    user: Object,
    profilePage: { required: false, type: Boolean, default: false },
  },
  created() {
    this.$store.default.dispatch(StoryActions.SET, {
      stories: this.stories.data,
    });
  },

  data() {
    return {
      storiesList: this.$store.default.getters.getStories,
      currentStory: null,
      bars: 0,
      bar: 0,
      index: 0,
      profile: null,
      timer: null,
      counter: 5,
    };
  },
  watch: {
    counter: function (actualValue, _) {
      if (actualValue == 0) {
        this.nextStory();
      }
    },
  },
  methods: {
    classObj(p, i) {
      return {
        stories: true,
        profile: this.profilePage,
        feed: !this.profilePage,
        "has-stories": p.user_stories[i].watched_by.length == 0,
      };
    },
    activateTimer() {
      // set "slide time" to 5 seconds, with being possibly paused on mousedown and resumed on mouseup
      this.timer = setInterval(() => (this.counter -= 1), 1000);
    },
    pauseTime() {
      clearTimeout(this.timer);
    },
    resumeTime() {
      this.activateTimer();
    },
    showStories(p, i) {
      const notWatched = p.user_stories.filter((p) => p.watched_by.length == 0);

      this.bars = p.user_stories.length;

      if (notWatched.length == 0) this.bar = 0;
      else this.bar = this.bars - notWatched.length - 1;

      this.currentStory = true;
      this.profile = p;
      this.index = i;

      this.activateTimer();

      this.$store.default.dispatch(StoryActions.WATCH, {
        profile: p.id,
        story: p.user_stories[this.bar].id,
      });
    },
    nextStory() {
      clearInterval(this.timer);
      this.counter = 5;
      const isLastBar = this.profile.user_stories.length - 1 == this.bar;

      if (isLastBar) {
        return this.nextProfile();
      }

      this.activateTimer();

      this.bar++;
      this.$store.default.dispatch(StoryActions.WATCH, {
        profile: this.profile.id,
        story: this.profile.user_stories[this.bar].id,
      });
    },
    previousStory() {
      clearInterval(this.timer);
      this.counter = 5;

      const isFirstBar = this.bar == 0;
      if (isFirstBar) {
        return this.previousProfile();
      }

      this.bar--;
      this.$store.default.dispatch(StoryActions.WATCH, {
        profile: this.profile.id,
        story: this.profile.user_stories[this.bar].id,
      });
    },
    exit() {
      clearTimeout(this.timer);
      this.timer = null;
      this.bars = 0;
      this.bar = 0;
      this.counter = 5;
      this.profile = null;
      this.currentStory = null;
    },
    goto(url) {
      window.location = url;
    },
    nextProfile() {
      const isLastProfile = this.index == this.storiesList.length - 1;

      this.index++;

      if (isLastProfile) this.exit();
      else this.showStories(this.storiesList[this.index], this.index);
    },
    previousProfile() {
      const isFirstProfile = this.index == 0;

      this.index--;

      if (isFirstProfile) this.exit();
      else this.showStories(this.storiesList[this.index], this.index);
    },
  },
};
</script>

<style lang="scss">
.story-bars {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  transition: all 200ms ease;
}

.story-bar {
  transition: all 200ms ease;
  flex: 1;
  height: 2px;
  border-radius: 5px;
  margin: 0 10px;
  background: #777;

  &.--active {
    background: #ddd;
  }
}

.stories-modal {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.7);
  z-index: 100;
}
.stories-card {
  display: flex;
  margin: auto;
  flex-direction: column;
  width: 100%;
  max-width: 800px;
  max-height: 80vh;

  & .profile-info {
    display: inline-block;
    cursor: pointer;
    width: fit-content;
    color: #fff;
    font-weight: bold;

    & > img {
      width: 40px;
      border-radius: 50%;
      margin-right: 3px;
    }
  }

  .story-player {
    & > img,
    & > video {
      width: 100%;
      object-fit: contain;
    }
  }
}

.plus-button {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  font-size: 15px;
  height: 20px;
  width: 20px;
  right: 10px;
  border-radius: 50%;
  bottom: 10px;
  border: 2px solid #fff;
  font-size: 16px;
  color: #fff;
  background-color: var(--primary);
}
</style>
