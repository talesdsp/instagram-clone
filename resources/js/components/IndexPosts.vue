<template>
  <div class="container">
    <div
      v-for="post in postList"
      :key="post.id"
      class="row justify-content-center align-items-center flex-column pb-4"
    >
      <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12">
        <div class="d-flex align-items-baseline pb-2">
          <div class="pr-3">
            <a :href="'/' + post.user.username">
              <img
                :src="'/storage/' + post.user_profile.image"
                class="rounded-circle w-100"
                :style="{ maxWidth: '40px' }"
              />
            </a>
          </div>

          <div>
            <div class="font-weight-bold">
              <a :href="'/' + post.user.username">
                <span class="text-dark">{{ post.user.username }}</span>
              </a>
            </div>
          </div>
        </div>

        <a :href="'/p/' + post.id">
          <img :src="'/storage/' + post.image" class="w-100" />
        </a>
      </div>

      <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 pt-3">
        <action-icons @openComment="goto(post.id)" :post="post"></action-icons>
        <p>
          <a :href="'/' + post.user.username">
            <span class="font-weight-bold text-dark">{{
              post.user.username
            }}</span>
          </a>

          {{ post.caption }}
        </p>
        <p @click="goto(post.id)" v-if="post.comments_count == 1">
          Ver {{ post.comments_count }} comentário
        </p>
        <p @click="goto(post.id)" v-else-if="post.comments_count > 1">
          Ver {{ post.comments_count }} comentários
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { PostActions } from "../store/modules/posts";
import ActionIcons from "./ActionIcons.vue";

export default {
  name: "index-posts",
  components: {
    ActionIcons,
  },
  props: ["posts"],
  created() {
    this.$store.default.dispatch(PostActions.SET, { posts: this.posts.data });
  },
  data() {
    return {
      postList: this.$store.default.getters.getPosts,
    };
  },
  methods: {
    goto(url) {
      window.location = "/p/" + url;
    },
  },
};
</script>

<style>
@media (min-width: 768px) {
  .container {
    margin-left: 0;
  }
}

@media (min-width: 1200px) {
  .container {
    margin-left: auto;
  }
}
</style>