/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

const store = require("./store");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const components = require.context(".", true, /\.vue$/i);
// components.keys().map(key =>
//   Vue.component(
//     key
//       .split("/")
//       .pop()
//       .split(".")[0],
//     components(key).default || components(key)
//   )
// );
import * as components from "./components";

Vue.config.devtools = true;

const app = new Vue({
  el: "#app",
  mounted() {
    delete window.post;
  },
  data() {
    return {
      post: window.post
    };
  },
  store,
  components: {
    ...components
  }
});
