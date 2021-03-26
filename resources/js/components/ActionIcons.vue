<template>
  <div class="icons-list">
    <div class="icons-left">
      <img
        @click="(e) => likePost(e)"
        class="mr-3"
        :src="renderImage('heart', post.liked)"
      />
      <img
        @click="openComment"
        class="mr-3"
        src="/storage/svgs/message-circle.svg"
      />
      <img src="/storage/svgs/send.svg" />
    </div>

    <img
      @click="(e) => bookmark(e)"
      :src="renderImage('bookmark', post.favorited)"
    />
  </div>
</template>


<script>
import { FavoriteActions } from "../store/modules/favorites";

export default {
  name: "action-icons",
  props: ["post"],
  methods: {
    renderImage: function (name, liked) {
      return `/storage/svgs/${name}${liked ? "-active" : ""}.svg`;
    },
    openComment() {
      this.$emit("openComment", { type: "store", comment_id: 0 });
    },
    likePost(e) {
      try {
        this.$emit("liked", this.post.id);

        const img = e.target;
        if (this.post.liked == 1) {
          img.classList.remove("liked");
        } else {
          img.classList.add("liked");
        }

        img.src = this.renderImage("heart", img.classList.contains("liked"));
      } catch (error) {
        console.log("banana", error);
      }
    },
    bookmark(e) {
      const img = e.target;
      img.classList.toggle("liked");
      img.src = this.renderImage("bookmark", img.classList.contains("liked"));
      this.$store.default.dispatch(FavoriteActions.TOGGLE, {
        id: this.post.id,
      });
    },
  },
};
</script>

<style lang="scss" >
.icons-list {
  position: relative;
  margin-bottom: 15px;
  display: inline-flex;
  width: 100%;
  flex-direction: row;
  justify-content: space-between;

  .icons-left {
    display: inline-flex;
    width: 100%;
    flex: 1;
  }

  img {
    cursor: pointer;
    width: auto;
  }

  @keyframes like {
    0% {
      transform: scale(0.8);
    }
    50% {
      transform: scale(1.2);
    }
    100% {
      transform: scale(1);
    }
  }
}
.liked {
  animation: like 480ms ease forwards;
}
</style>