
var app = new Vue({
  el: '#vueapp',
  data: {
    message: 'Hello Vue!'
  }
})


window.onload = function() {
  new Vue({
    el: '#app',
    data: {
      name: 'Sitepoint'
    },
  })
}
