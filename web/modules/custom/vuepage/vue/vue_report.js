



window.onload = function() {
  new Vue({
    el: '#app',
    data: {
      name: 'Sitepoint'
    },
    template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
  })
}

new Vue({ el: '#components-demo' })

var app = new Vue({
  el: '#vueapp',
  data: {
    message: 'Hello Vue!'
  }
})
