<template>
  <vue-dropzone
    id="dropzone"
    ref="dropzone"
    :options="dropzoneOptions"
    v-on:vdropzone-success="uploadSuccess"
    v-on:vdropzone-error="uploadError"
    v-on:vdropzone-removed-file="fileRemoved"
  >
  </vue-dropzone>
</template>

<script>
import VueDropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
  name: "file-input",
  components: {
    VueDropzone,
  },
  data() {
    return {
      images: [],
      dropzoneOptions: {
        url: "/s",
        thumbnailWidth: 250,
        thumbnailHeight: 250,
        addRemoveLinks: false,
        acceptedFiles: ".jpg, .jpeg, .png",
        maxFiles: 1,
      },
      fileName: "",
    };
  },
  methods: {
    async afterComplete(file) {
      try {
        const metadata = {
          contentType: "image/png",
        };
      } catch (error) {
        console.log(error);
      }
    },
    uploadSuccess(file, response) {
      console.log(
        "File Successfully Uploaded with file name: " + response.file
      );
      this.fileName = response.file;
    },
    uploadError(file, message) {
      console.log("An Error Occurred");
    },
    fileRemoved() {},
  },
};
</script>

<style>
</style>