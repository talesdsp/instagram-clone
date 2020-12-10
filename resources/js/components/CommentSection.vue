<template>
  <section class="comment-section">
    <article v-if="commentList.length > 0">
      <div v-for="comment in commentList" :key="comment.id">
        <comment @openComment="open($event)" :comment="comment"></comment>
        <div
          class="ml-1 pl-2"
          style="border-left: 1px dotted rgba(0, 0, 0, 0.5)"
          v-for="reply in comment.replies"
          :key="reply.id"
        >
          <comment
            @openComment="open($event)"
            :comment="reply"
            :reply="true"
          ></comment>
        </div>
      </div>
    </article>
  </section>
</template>

<script>
import Comment from './Comment.vue'
import { CommentActions } from '../store/modules/comments'
import { AuthActions } from '../store/modules/authentication'

export default {
  components: {
    Comment
  },
  name: "comment-section",
  props: ['postId', 'openComment'],
  data() {
    return {
      commentList: this.$store.default.getters.getComments
    }
  },
  methods: {
    open(event) {
      this.openComment(event)
    }
  }
}
</script>
