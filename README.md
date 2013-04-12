pyro-swipe-module
=================

Create multiple sliders with [swipe.js](https://github.com/bradbirdsall/Swipe). Swipe is great because it is lightweight, framework-independent(no-jquery) and touch-capable.

This module lets you create multiple sliders and then call them using their id and the modules plugin. You just drop a folder in the swipe folder and choose that as your sliders source.

Usage
------

Suggested HTML markup using all the plugins helper keys.

```html
<!-- the id of the slider you want -->
{{ swipe:slider id="1" }}
<!-- keep the slider unique with the id -->
<div id='slider_{{id}}' class='swipe'>
  <div class='swipe-wrap'>
    <!-- folder key is the id of the folder -->
    {{ files:listing folder=folder }}
    <div><img src="{{ url:site }}files/large/{{ id }}" alt="{{ description }}"/></div>
    {{ /files:listing }}
  </div>
</div>
<!-- source is set in plugin -->
<script src="{{ source }}"></script>
<script>
window.onload = function() {
  // window onload fires last... on most browsers...
  {{ script }}
};
</script>
{{ /swipe:slider }}
```

CSS styles. These can be modified to suit your needs. But this is the basic setup from the repos readme file.

```css
<style>
.swipe {
  overflow: hidden;
  visibility: hidden;
  position: relative;
}
.swipe-wrap {
  overflow: hidden;
  position: relative;
}
.swipe-wrap > div {
  float:left;
  width:100%;
  position: relative;
}
.swipe-wrap > div img {
  max-width: 100%;
  height: auto;
}
</style>
```

What's in the plugin
---------------------

In order to keep the HTML small, you can just use the built in script that the plugin returns.

```php
// a default setup for the plugin
// this setup requires you to use the prefered html with `slide_{{id}}` set correctly
$swipe['script'] = "window.swipe{$swipe[id]} = new Swipe(document.getElementById('slider_{$swipe[id]}'), {
  startSlide: {$swipe[startslide]},
  speed: {$swipe[speed]},
  auto: {$swipe[auto]},
  continuous: {$swipe[continuous]},
  disableScroll: {$swipe[disablescroll]},
  stopPropagation: {$swipe[stoppropagation]}
});";
```