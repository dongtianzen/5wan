
console.log(666);


window.onload = function() {
  new Vue({
    el: '#app',
    data: {
      name: 'Sitepoint'
    },
    template: '<button >You clicked me times.</button>'
  })
}


var app = new Vue({
  el: '#vueapp',
  data: {
    message: 'Hello Vue!'
  }
})
