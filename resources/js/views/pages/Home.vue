<template>
  <div class="container text-center">
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-10">
          <input type="text" placeholder="Your link here...." class="form-control" v-model="url" />
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-success">Shorten</button>
        </div>
      </div>
    </form>

    <div class="card mt-3" v-show="short_url">
      <div class="card-header">
        <h4 class="text-center" style="color:green;">Your shortened URL is ready !</h4>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mx-auto">
              <input type="text" class="form-control" ref="short_url"  v-model="short_url" />
              <button class="btn btn-info mt-2" @click="copyurl">Copy</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "home",
  data() {
    return {
      url: "",
      short_url:""
    };
  },
  methods: {
    async submit() {
      this.short_url=''
      await axios
        .post("api/url-shortner", { url: this.url })
        .then((response) => {
          this.short_url=response.data.short_url
        });
    },
    copyurl(){
       var Url = this.$refs.short_url;
      Url.innerHTML = window.location.href;
      console.log(Url.innerHTML)
      Url.select();
      document.execCommand("copy");
    }
  },
};
</script>