<template>
  <form
    v-if="isOpen"
    id="comment-form"
    @click.self="emitClose"
    @submit.prevent="submit"
  >
    <div>
      <textarea
        ref="textarea"
        rows="1"
        type="text"
        name="text"
        v-model="text"
      ></textarea>
      <button type="submit" class="btn btn-light mt-3 mb-2">Submit</button>
      <p class="tips">
        <span class="chars" :class="classObject"
          >{{ charsLeft }} chars left</span
        >
      </p>
    </div>
  </form>
</template>

<script>
import { CommentActions } from "../store/modules/comments";

export default {
  name: "comment-submit",
  props: ["isOpen", "post", "commentId", "type"],
  data() {
    return {
      text: "",
    };
  },
  updated() {
    if (this.$refs.textarea) {
      this.$refs.textarea.focus();
    }
  },
  computed: {
    charsLeft() {
      return 300 - this.text.length;
    },
    classObject() {
      return {
        danger: this.text.length > 280,
      };
    },
  },
  methods: {
    submit() {
      if (this.type === "store") {
        this.$store.default.dispatch(CommentActions.STORE, {
          text: this.text,
          post_id: this.post.id,
          comment_id: this.commentId,
        });
      } else if (this.type === "update") {
        this.$store.default.dispatch(CommentActions.UPDATE, {
          id: this.comment.id,
          text: this.text,
          post_id: this.post.id,
          comment_id: this.comment.commentId,
        });
      }
      this.emitClose();
    },
    emitClose() {
      this.text = "";
      this.$emit("closeComment");
    },
  },
};
</script>

<style lang="scss">
@keyframes fadeUp {
  0% {
    transform: translateY(900px);
  }
  100% {
    transform: translateY(0);
  }
}

#comment-form {
  display: flex;
  position: fixed;
  width: 100%;
  height: 100%;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.1);

  & > div {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border-radius: 5px;
    margin: auto;
    width: 400px;
    max-width: 100vw;
    background: #fff;
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.3);
    z-index: 5;
    animation: fadeUp 680ms ease forwards;
  }
}
textarea {
  background: transparent;
  margin: auto;
  height: max-content;
  width: 100%;
  max-height: 100vh;
  overflow: none;
  font-family: Arial;
  border-right: none;
  border-top: none;
  border-left: none;
  font-size: 16px;
  padding: 5px 10px;
  outline: none;
  transition: border 300ms ease;

  &:focus {
    border-bottom-color: var(--primary);
  }
}
button {
  margin: auto;
}

.tips {
  margin: 0;
  width: 100%;
  display: flex;
  font-size: 13px;
  color: #555;
  justify-content: space-between;
}

.chars {
  align-self: flex-start;
}

.danger {
  color: var(--danger);
}
</style>

