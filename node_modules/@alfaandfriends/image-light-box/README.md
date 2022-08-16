# vue3-image-box

![SampleGif](https://linmasahiro.github.io/vue3-image-box/sample.gif)

A simple image lightbox component for vue3.0!!

I use CSS style from [vue-image-lightbox](https://www.npmjs.com/package/vue-image-lightbox)

## DEMO

[Online Demo](https://linmasahiro.github.io/vue3-image-box/dist/)

## SampleCode

### import
    import ImageBox from "vue3-image-box";

### component
    <image-box
      image-list-class="yourclass"
      :images="images"
    ></image-box>

### sample data
    setup() {
        const images=[
            {
                thumb: "http://example.com/thumb.jpeg",
                src: "http://example.com/image.jpeg",
                caption: "my image1!",
            },
            {
                thumb: "http://example.com/thumb2.jpeg",
                src: "http://example.com/image3.jpeg",
                caption: "my image2!",
            },
            ...
        ];

        return {
            images
        }
    }
