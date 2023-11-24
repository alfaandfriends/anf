<template>
  <image-box images-list-class="flex" :images="images"></image-box>
</template>

<script>
import { defineComponent } from "vue";
import ImageBox from "./components/ImageBox";

export default defineComponent({
  name: "App",
  components: {
    ImageBox,
  },
  setup() {
    const images = [
      {
        thumb:
          "https://nihonnleo.appspot.com/f/3/",
        src:
          "https://nihonnleo.appspot.com/f/3/",
        caption: "1",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/4/",
        src:
          "https://nihonnleo.appspot.com/f/4/",
        caption: "2",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/5/",
        src:
          "https://nihonnleo.appspot.com/f/5/",
        caption: "3",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/6/",
        src:
          "https://nihonnleo.appspot.com/f/6/",
        caption: "4",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/7/",
        src:
          "https://nihonnleo.appspot.com/f/7/",
        caption: "5",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/8/",
        src:
          "https://nihonnleo.appspot.com/f/8/",
        caption: "6",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/3/",
        src:
          "https://nihonnleo.appspot.com/f/3/",
        caption: "7",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/4/",
        src:
          "https://nihonnleo.appspot.com/f/4/",
        caption: "8",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/5/",
        src:
          "https://nihonnleo.appspot.com/f/5/",
        caption: "9",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/6/",
        src:
          "https://nihonnleo.appspot.com/f/6/",
        caption: "10",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/7/",
        src:
          "https://nihonnleo.appspot.com/f/7/",
        caption: "11",
      },
      {
        thumb:
          "https://nihonnleo.appspot.com/f/8/",
        src:
          "https://nihonnleo.appspot.com/f/8/",
        caption: "12",
      },
    ];

    return {
      images,
    };
  },
});
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

.flex {
  display: flex;
  width: 100%;
}

.flex img{
  max-width: 100px;
}
</style>
