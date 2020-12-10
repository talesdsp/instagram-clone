<template>
  <div class="row pt-5">
    <div class="col-3">
      <div v-if="stories.data.length == 0">
        <img
          class="w-100 rounded-circle"
          :src="'/storage/' + user.profile.image"
        />
      </div>

      <stories-section
        v-else
        :profile-page="true"
        :user="user"
        :stories="storiesData"
      ></stories-section>
    </div>
    <div class="col-9">
      <div class="bio d-flex justify-content-between align-items-baseline">
        <div class="d-flex align-items-center py-3">
          <h3 class="mr-4">{{ user.username }}</h3>

          <follow-button
            :same-user="sameUser"
            :follows="follows"
            :username="user.username"
          ></follow-button>
        </div>

        <a v-if="authUser.id == user.id" href="/p/create">New</a>
      </div>

      <a v-if="authUser.id == user.id" :href="'/' + user.username + '/edit'"
        >Edit Profile</a
      >

      <div class="d-flex">
        <div class="pr-5">
          <strong>{{ postCount }}</strong> posts
        </div>
        <div id="followers" class="pr-5">
          <strong>{{ followersCount }}</strong> followers
        </div>
        <div class="pr-5">
          <strong>{{ followingCount }}</strong> following
        </div>
      </div>

      <div class="pt-4 font-weight-bold">{{ user.profile.name }}</div>
      <div>{{ user.profile.bio }}</div>
      <div>
        <a :href="user.profile.url" target="_blank" class="">{{
          user.profile.url
        }}</a>
      </div>
    </div>
  </div>
</template>

<script>
import FollowButton from "./FollowButton";
import StoriesSection from "./StoriesSection";

export default {
  name: "profile",
  components: { FollowButton, StoriesSection },
  props: {
    stories: Object,
    sameUser: Number,
    user: Object,
    authUser: {
      type: Object,
      default: function () {
        return { id: 0 };
      },
    },
    postCount: Number,
    followingCount: Number,
    followersCount: Number,
    follows: Number,
  },
  computed: {
    storiesData() {
      const profile = {
        ...this.user.profile,
        user: this.user,
      };

      return { data: [{ ...profile, user_stories: this.stories.data }] };
    },
  },
};
</script>
