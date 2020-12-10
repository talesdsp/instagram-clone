<template>
  <div class="profile-wrapper">
    <h3>Recommended</h3>
    <section class="profile" v-for="profile in profileList" :key="profile.id">
      <img
        @click="goto(profile.user.username)"
        :src="'/storage/' + profile.image"
      />

      <span class="name">
        <strong>@{{ profile.user.username }}</strong>
      </span>
      <p>{{ profile.bio }}</p>
      <follow-button
        :follows="false"
        :sameUser="false"
        :username="profile.user.username"
      ></follow-button>
    </section>
  </div>
</template>

<script>
import { ProfileActions } from "../store/modules/profiles";
import FollowButton from "./FollowButton.vue";

export default {
  components: { FollowButton },
  name: "recommend-profiles",
  props: ["profiles"],
  data() {
    return {
      profileList: this.profiles,
    };
  },
  methods: {
    goto(url) {
      window.location = "/" + url;
    },
  },
};
</script>

<style lang="scss">
.profile-wrapper {
  right: 0%;
  position: absolute;
  top: 205px;
  display: flex;
  flex-direction: column;
}

.profile {
  margin-bottom: 10px;
  border-radius: 5px;
  overflow: hidden;
  width: 100px;
  cursor: pointer;

  img {
    width: 100%;
  }
}

@media (min-width: 768px) {
  .profile-wrapper {
    right: 5%;
  }
}

@media (min-width: 1200px) {
  .profile-wrapper {
    right: 10%;
  }
}
</style>