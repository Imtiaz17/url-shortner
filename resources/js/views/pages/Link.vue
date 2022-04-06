<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h3>You are being redirected , please wait.......</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "linke",
  data() {
    return {
      loading: "",
    };
  },
  created() {
    this.checkURL();
  },
  methods: {
    async checkURL() {
      this.loading = true;
      await axios
        .get(`api/url-shortner/${this.$route.params.link}`)
        .then((res) => {
          let valid_url = this.validateURL(res.data.original_url);
          window.location.replace(valid_url);
        })
        .catch((error) =>this.$router.push('/'));
    },
    validateURL(url) {
      if (url.indexOf("://") === -1) {
        return "http://" + url;
      } else {
        return url;
      }
    },
  },
};
</script>

<style>
</style>