<template>
  <div class="d-flex flex-row">
    <div class="stories comment">
      <img
        @click="seeProfile(comment.user.username)"
        :src="'/storage/' + comment.user_profile.image"
      />
    </div>
    <p class="comment-text">
      <!-- <span class="edit" @click="emitOpen(comment.id, 'update')"> Editar </span> -->

      <img
        class="like"
        :class="{ liked: comment.liked }"
        :src="renderImage(comment.liked)"
        @click="(e) => likeComment(e, comment.id)"
      />
      <strong
        @click="seeProfile(comment.user.username)"
        v-text="comment.user.username"
      ></strong>
      {{ comment.text }}

      <br />
      <span class="timestamp">{{ fromNow(comment.created_at) }}</span>
      <span class="likes mr-2 ml-2">{{ comment.likes_count }} curtidas</span>
      <span class="answer" v-if="!reply" @click="emitOpen(comment.id, 'store')">
        Responder
      </span>
      <br />
      <span
        @click="loadReplies"
        class="replies"
        v-if="
          (comment.pages == null && comment.replies_count > 0) ||
          (comment.pages != null && comment.pages.next_page_url !== null)
        "
      >
        <hr />
        See
        {{
          this.comment.replies_count -
          ((this.comment.replies && this.comment.replies.length) || 0)
        }}
        replies
      </span>
    </p>
  </div>
</template>


<script>
import debounce from "lodash/debounce";
import { CommentActions } from "../store/modules/comments";

export default {
  name: "comment",
  props: {
    comment: { default: {}, type: Object },
    reply: { type: Boolean, default: false },
  },
  methods: {
    renderImage: (liked) => `/storage/svgs/heart${liked ? "-active" : ""}.svg`,
    fromNow(created) {
      return dayjs()
        .from(created, true)
        .split(" ")
        .map((v, i, self) => {
          if (i === 0) {
            return v === "a" || v == "an" ? 1 : v;
          } else if (i > 1) {
            return;
          }
          const time = v.slice(0, 1);
          return time === "f" ? "s" : time;
        })
        .join("");
    },
    seeProfile(e) {
      window.location = "/" + e;
    },
    likeComment(e, id) {
      const img = e.target;

      img.classList.toggle("liked");
      img.src = this.renderImage(img.classList.contains("liked"));

      this.$store.default.dispatch(CommentActions.LIKE, {
        id,
        liked: this.comment.liked || 0,
        likes_count: +this.comment.likes_count,
        comment_id: +this.comment.comment_id,
      });
    },
    emitOpen(comment_id, type) {
      this.$emit("openComment", { comment_id, type });
    },
    loadReplies: debounce(function () {
      const id = this.comment.id;
      const url = this.comment.pages && this.comment.pages.next_page_url;

      if (url) {
        this.$store.default.dispatch(CommentActions.FETCH, { id, url });
      } else {
        this.$store.default.dispatch(CommentActions.FETCH, { id });
      }
    }, 400),
  },
};
</script>


<style lang="scss" >
.comment-section {
  position: relative;
  display: flex;
  flex-direction: column;
  height: fit-content;
  max-height: min-content;
}

strong {
  font-size: 14px;
  cursor: pointer;
}

.comment-text {
  width: 100%;
  position: relative;
  line-height: 1.2;

  & > span {
    font-size: 12px;
  }
}

.like {
  cursor: pointer;
  float: right;
  margin-top: 12px;
  margin-left: 8px;
  margin-right: 3px;
  width: 15px;
  height: 15px;
  z-index: 5;
}

.likes,
.answer {
  font-weight: bold;
  cursor: pointer;
}

.replies {
  cursor: pointer;

  hr {
    display: inline-block;
    margin-top: 0px;
    margin-bottom: 4px;
    margin-left: 0;
    margin-right: 8px;
    width: 25px;
  }
}
</style>