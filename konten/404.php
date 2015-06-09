
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <!--
Copyright (c) 2015 by circunspecter (http://codepen.io/circunspecter/pen/lsdwt)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->

  <title>CodePen - Make Frowning smile [404 page]</title>

  <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css'>

  <style>
  @import url(//fonts.googleapis.com/css?family=Lato:700);

body {
    color: #999;
    text-align:center;
    background-color: #fafafa;
    font-family:'Lato', sans-serif;
}

.p404 {
    overflow: hidden;
}

@-webkit-keyframes eye-blink {
    95% { color: #bbb; text-shadow: 3px 0 0 #fafafa; }
    100% { color: #fafafa; text-shadow: 3px 0 0 #bbb; }
}
@-moz-keyframes eye-blink {
    95% { color: #bbb; text-shadow: 3px 0 0 #fafafa; }
    100% { color: #fafafa; text-shadow: 3px 0 0 #bbb; }
}
@-o-keyframes eye-blink {
    95% { color: #bbb; text-shadow: 3px 0 0 #fafafa; }
    100% { color: #fafafa; text-shadow: 3px 0 0 #bbb; }
}
@keyframes eye-blink {
    95% { color: #bbb; text-shadow: 3px 0 0 #fafafa; }
    100% { color: #fafafa; text-shadow: 3px 0 0 #bbb; }
}

.face {
    color: #bbb;
    line-height: 0.8;
    font-size: 300px;
    margin-bottom: 120px;
}
.face .eyes {
    text-shadow: 3px 0 0 #fafafa;
    -webkit-animation: eye-blink 3s infinite;
    -moz-animation: eye-blink 3s infinite;
    -o-animation: eye-blink 3s infinite;
    animation: eye-blink 3s infinite;
}
.face-smile .eyes {
    color: #fafafa;
    text-shadow: -5px 0 0 #bbb;
    -webkit-animation: none;
    -moz-animation: none;
    -o-animation: none;
    animation: none;
}
.face-smile .mouth {
    display: inline-block;
    -webkit-transition: all .7s ease;
    -webkit-transform: rotateY(180deg);
    -moz-transition: all .7s ease;
    -moz-transform: rotateY(180deg);
    -o-transition: all .7s ease;
    -o-transform: rotate(180deg);
    transition: all .7s ease;
    transform: rotateY(180deg);
}
.message {
    font-size: 22px;
}
.message span {
    color: #ff5500;
}
.message a {
    color: #444;
    padding-bottom: 2px;
    text-decoration: none;
}
.message a:link, .message a:visited {
    border-bottom: 2px solid #ddd;
}
.message a:hover, .message a:active {
    border-bottom: 2px solid #ff5500;
}

  </style>

  <script>
    window.console = window.console || function(t) {};
    window.open = function(){ console.log('window.open is disabled.'); };
    window.print = function(){ console.log('window.print is disabled.'); };
    // Support hover state for mobile.
    if (false) {
      window.ontouchstart = function(){};
    }
  </script>

</head>

<body>

  <div class="p404">
    <div class="face"><span class="eyes">:</span><span class="mouth">(</span></div>
    <p class="message">Oops, there is nothing in <span>/itsyourbadimflawless</span>... Want to go to the <a href="#homepage">homepage</a>?</p>
</div>

  <script src='//assets.codepen.io/assets/libs/fullpage/jquery-c152c51c4dda93382a3ae51e8a5ea45d.js'></script>

  <script>
    if (document.location.search.match(/type=embed/gi)) {
      window.parent.postMessage('resize', "*");
    }
  </script>

  <script src="//assets.codepen.io/assets/common/stopExecutionOnTimeout-6c99970ade81e43be51fa877be0f7600.js"></script>

  <script>
    function vCenter() {
    $('.p404').css({
        'position': 'relative',
        'top': ($(document).height() - $('.p404').height()) / 2
    });
}
function toggleSmile(e) {
    var face = $(this).parent().siblings('.face');
    if (face.hasClass('face-smile') && $(this).is('form') && e.type === 'focusin') {
        face.data('trigger', $(this));
    } else if (!face.hasClass('face-smile') || face.hasClass('face-smile') && $(this).is(face.data('trigger'))) {
        face.toggleClass('face-smile').data('trigger', $(this));
    }
}
vCenter();
$('.message a').on('mouseenter mouseleave', toggleSmile);
$('.p404').on('focusin focusout', '.search-box form', toggleSmile);
window.onresize = vCenter;
    //@ sourceURL=pen.js
  </script>

</body>

</html>
