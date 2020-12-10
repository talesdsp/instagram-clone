<template>
  <div class="post-image col-10 col-lg-6" @dblclick="like">
    <img :src="'/storage/' + post.image" class="w-100" />
  </div>
</template>

<script>

export default {
  name: "post-image",
  props: ['post'],
  methods: {
    like(e) {
      if (this.post.liked == 0) {
        e.target.classList.add('fade-in-out');

        setTimeout(() => {
          e.target.classList.remove('fade-in-out');
        }, 1020)
      } else {
        e.target.classList.remove('fade-in-out');
      }

      this.$emit('liked', this.post.id)
    }
  }
}
</script>

<style lang='scss'>
@keyframes fadeInOut {
  0%,
  100% {
    opacity: 0;
  }
  30%,
  70% {
    opacity: 0.8;
  }
}
.fade-in-out {
  &::before,
  &::after {
    animation: fadeInOut 1020ms linear forwards;
  }
}

.post-image {
  position: relative;
  padding: 0 !important;

  &::before,
  &::after {
    opacity: 0;
  }
  &::before {
    content: "";
    position: absolute;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }

  &::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    background-image: url("/storage/svgs/heart-fff.svg");
    background-repeat: no-repeat;
    background-size: contain;
    width: 120px;
    height: 140px;
    margin: auto;
  }

  @media (min-width: 992px) {
    padding: 0 15px !important;

    &::before {
      width: calc(100% - 30px);
      left: 15px;
    }
  }
}
</style>