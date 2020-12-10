<template>
  <div v-if="banner" class="log-banner">
    <span class="cross" @click="closeBanner">x</span>
    <div>image</div>
    <div>
      <p>Log In to Instagram</p>
      <p>
        Log in to see photos and videos from friends and discover other accounts
        you'll love.
      </p>
    </div>
    <div class="d-flex flex-column">
      <button @click="promptAuth" class="btn btn-primary">Log In</button>
      <a href="/register" class="btn btn-link">Sign Up</a>
    </div>
  </div>
</template>

<script>
import { AuthActions } from '../store/modules/authentication';
export default {
  name: "log-banner",
  data() {
    return {
      banner: true
    }
  },
  updated() {
    this.$destroy();
  },
  methods: {
    closeBanner() {
      this.banner = false;
    },
    promptAuth() {
      this.$store.default.dispatch(AuthActions.PROMPT)
    }
  }
}
</script>

<style lang='scss' >
.log-banner {
  color: #fff;
  bottom: 0;
  left: 0;
  height: 200px;
  width: 100%;
  position: fixed;
  background: rgba(0, 0, 0, 0.9);
  display: flex;
  padding: 0 10px;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;

  p {
    margin: 0;
  }
}
.cross {
  position: absolute;
  cursor: pointer;
  top: 15px;
  right: 20px;
  font-size: 20px;
}

@media (min-width: 768px) {
  .log-banner {
    height: 150px;
    flex-direction: row;
  }
}

@media (min-width: 800px) {
  .log-banner {
    padding: 0 50px;
  }
}

@media (min-width: 930px) {
  .log-banner {
    padding: 0 100px;
  }
}
@media (min-width: 1200px) {
  .log-banner {
    padding: 0 200px;
  }
}
</style>