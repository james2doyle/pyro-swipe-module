pyro-swipe-module
=================

Create multiple sliders with [swipe.js by Brad Birdsall](https://github.com/bradbirdsall/Swipe). Swipe is great because it is lightweight, framework-independent(no jQuery) and touch-capable.

This module lets you create multiple sliders and then call them using their id and the modules plugin. You just create a new folder in the `swipe` directory in the files module, and choose that new folder as your image source folder.

The slider will then generate a form for each image. If you want to sort your images, just use the **dragging sort** in the files module.

Slides have their own titles, and can be linked to pages on your site, or an outside URL.

### Usage

Suggested HTML markup using all the plugins helper keys.

```html
<!-- the id of the slider you want -->
{{ swipe:slider id="1" }}
<!-- keep the slider unique with the id -->
<div id="slider_{{id}}" class="swipe">
  <div class="swipe-wrap">
    <!-- as of 1.2 the array of files is accessible -->
    {{ files }}
    <div class="slide" id="slide-{{ count }}">
      <!-- an example of manually setting up the images -->
      <img src="{{ url:site }}files/thumb/{{ id }}/768/512" alt="{{ alt_attribute }} {{ description }} {{ swipe_title }}" />
      <!-- as of 1.2 there are titles for each slide -->
      {{ if swipe_title != '' }}
      <div class="slide-title">{{ swipe_title }}</div>
      {{ endif }}
    </div>
    {{ /files }}
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

**side note**: If you plan on using the assets plugin or minifying and concatenating all your js files, go ahead and ignore the {{ source }} and just add your js in the footer as you would normally.

CSS styles. These can be modified to suit your needs. But this is the basic setup from the [repos readme file](https://github.com/bradbirdsall/Swipe/blob/master/README.md).

```css
.swipe {
  overflow: hidden;
  visibility: hidden;
  position: relative;
}

.swipe-wrap {
  overflow: hidden;
  position: relative;
}

.swipe-wrap .slide {
  float: left;
  width: 100%;
  position: relative;
}

.swipe-wrap .slide img {
  max-width: 100%;
  height: auto;
}
```

### Using the {{ script }} key

In order to keep the HTML small, or to just be lazy, you can just use the built in script that the plugin returns. It just sets up everything in its place. But, this setup requires you to use the prefered html with `slide_{{id}}` set correctly.

```php
// currently in the plugin.php file
$swipe['script'] = "window.swipe{$swipe[id]} = new Swipe(document.getElementById('slider_{$swipe[id]}'), {
  startSlide: {$swipe[startslide]},
  speed: {$swipe[speed]},
  auto: {$swipe[auto]},
  continuous: {$swipe[continuous]},
  disableScroll: {$swipe[disablescroll]},
  stopPropagation: {$swipe[stoppropagation]}
});";
```

### Todo

* Add pagination option
* Add left-right controls option

### License

(The MIT License)

Copyright (c) 2013 James Doyle(james2doyle) james2doyle@gmail.com

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.