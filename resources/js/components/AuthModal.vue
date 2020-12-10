<template>
  <div class="shadow" v-if="shouldPrompt">
    <div class="modal-card">
      <div @click="closeModal" class="cross">x</div>

      <h2
        class="mb-4 mt-2"
        style="font-family: serif; font-size: 33px; font-weight: 600"
      >
        Instagram
      </h2>

      <form @submit.prevent="submit" class="w-100">
        <div class="form-group row">
          <div class="col-sm-8 offset-sm-2">
            <input
              id="email"
              type="email"
              class="form-control"
              name="email"
              v-model="email"
              required
              placeholder="email"
              aria-label="email"
              autocomplete="email"
            />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-8 offset-sm-2">
            <input
              id="password"
              type="password"
              class="form-control"
              name="password"
              v-model="password"
              placeholder="password"
              aria-label="password"
              required
              autocomplete="current-password"
            />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-8 offset-sm-2">
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="checkbox"
                name="remember"
                id="remember"
              />

              <label class="form-check-label" for="remember">
                Remember Me
              </label>
            </div>
          </div>
        </div>

        <div class="form-group p-0 mb-0 col-sm-8 offset-sm-2">
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
      </form>

      <a
        class="btn btn-link"
        href="/password/reset"
        style="font-size: 12px; margin-top: 15px"
      >
        Forgot Your Password?
      </a>

      <hr />
      <p style="font-size: 13px" class="p-0 m-0">
        Don't have an account? <a href="/register">Sign up</a>
      </p>
      <hr />
    </div>
  </div>
</template>

<script>
import { AuthActions } from '../store/modules/authentication'

export default {
  name: 'auth-modal',
  data() {
    return {
      email: '',
      password: '',
      checkbox: false
    }
  },
  computed: {
    shouldPrompt() { return this.$store.default.getters.shouldPrompt },
  },
  methods: {
    closeModal() {
    },
    async submit() {
      try {
        await window.axios.post('/login', { email: this.email, password: this.password, checkbox: this.checkbox })

        window.location.reload();
      } catch (error) {
        console.log(error)
      }
    }
  }
}
</script>

<style>
.shadow {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.7);
}
.modal-card {
  position: fixed;
  display: flex;
  flex-direction: column;
  align-items: center;
  overflow: hidden;
  background: #fff;
  border-radius: 10px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  width: 360px;
  border: 1px solid #ccc;
  padding: 20px;
  height: 410px;
  max-width: 100vw;
}

input::placeholder {
  font-size: 13px;
  text-transform: capitalize;
}

hr {
  width: 100%;
}
</style>