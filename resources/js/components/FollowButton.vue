<template>
  <button
    @click="toggleFollow"
    class="btn"
    :class="classFollow"
    v-text="buttonText"
    v-if="!sameUser"
  >
    Follow
  </button>
</template>

<script>
export default {
  name: "follow-button",
  props: ["follows", "username", "sameUser"],
  data() {
    return {
      status: this.follows,
    };
  },
  computed: {
    buttonText() {
      return this.status ? "Unfollow" : "Follow";
    },
    classFollow() {
      return this.status ? "btn-outline-dark" : "btn-primary";
    },
  },
  methods: {
    async toggleFollow() {
      try {
        let path = `/follow/${this.username}`;
        this.status = !this.status;

        await axios.post(path);
        const result = await axios.get(path);

        const followElement = document.querySelector("#followers strong");
        if (followElement) {
          followElement.textContent = result.data;
        }
      } catch (e) {
        this.status = !this.status;
        if (e.response && e.response.status == 401) {
          window.location = "/login";
        } else {
          console.log(e);
        }
      }
    },
  },
};
</script>
