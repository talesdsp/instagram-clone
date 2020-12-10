<template>
  <div class="row justify-content-center">
    <post-image :post="post" @liked="userLikedPost($event)"></post-image>

    <div class="col-10 col-lg-4 p-0 pt-4 bg-white d-flex flex-column">
      <div
        class="d-flex align-items-center mb-3"
        :style="{ padding: '0 20px' }"
      >
        <div class="mr-3 stories post">
          <img :src="'/storage/' + profile.image" class="rounded-circle" />
        </div>

        <div
          class="font-weight-bold d-flex flex-row align-items-center w-100"
          :style="{ justifyContent: 'space-between' }"
        >
          <a :href="'/' + user.username">
            <span class="text-dark" v-text="user.username"></span>
          </a>

          <follow-button
            :follows="post.follows"
            :username="user.username"
            :same-user="sameUser"
          ></follow-button>
        </div>
      </div>

      <div :style="{ margin: '0 20px' }">
        <action-icons
          :post="post"
          @liked="userLikedPost($event)"
          @openComment="openComment($event)"
        ></action-icons>
      </div>

      <div class="scroll-v" @scroll="handleScroll">
        <p>
          <a :href="'/' + user.username">
            <span
              class="font-weight-bold text-dark"
              v-text="user.username"
            ></span>
          </a>
          {{ post.caption }}
        </p>

        <comment-section
          :open-comment="openComment"
          :post-id="post.id"
        ></comment-section>
      </div>

      <comment-submit
        @closeComment="closeComment"
        :is-open="isOpen"
        :post="post"
        :comment-id="commentId"
        :type="type"
      ></comment-submit>
    </div>
  </div>
</template>

<script>

import { CommentActions } from '../store/modules/comments'
import { PostActions } from '../store/modules/posts'
import debounce from 'lodash/debounce'
import ActionIcons from './ActionIcons.vue'
import CommentSection from './CommentSection.vue'
import CommentSubmit from './CommentSubmit.vue'
import FollowButton from './FollowButton.vue'
import PostImage from './PostImage.vue'

export default {
  name: 'post-info',
  components: {
    ActionIcons,
    CommentSection,
    CommentSubmit,
    FollowButton,
    PostImage
  },
  props: {
    'comments': { type: Object },
    'post': { type: Object },
    'profile': { type: Object },
    'sameUser': { type: Number, },
    'user': { type: Object },
  },
  created() {
    this.$store.default.dispatch(CommentActions.SET, { comments: this.comments.data })
  },
  data() {
    return {
      isOpen: false,
      commentId: 0,
      type: "",
    }
  },
  methods: {
    openComment(e) {
      this.isOpen = true
      this.commentId = e.comment_id;
      this.type = e.type;
      this.handleScrollAs = this.handleScroll;
    },
    closeComment() {
      this.isOpen = false
    },
    handleScroll: debounce(function (e) {
      const actual = e.target.scrollTop;
      const max = e.target.scrollTopMax;

      if (actual > max * .7) {
        console.log(actual, max)
      }
    }, 500),

    async userLikedPost(postId) {
      this.post.liked = !this.post.liked
      let res;
      try {
        res = await window.axios.post(`/like/p/${this.post.id}`);
      } catch (error) {
        if (error.response && error.response.status == 401) {
          window.location = '/login'
        } else console.log(error)
      }
    }
  }
}
</script>

<style lang="scss">
.scroll-v {
  padding: 0 20px;
  position: relative;
  overflow-x: visible;
  overflow-y: auto;
  scrollbar-width: thin;
  max-height: 450px;
}

@media (min-width: 992px) {
  .scroll-v {
    max-height: calc(420px - 90px);
  }
}

@media (min-width: 1200px) {
  .scroll-v {
    max-height: 420px;
  }
}
</style>