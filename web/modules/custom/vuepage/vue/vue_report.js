
console.log(666);


window.onload = function() {
  new Vue({
    el: '#app',
    data: {
      name: 'Sitepoint',
      message: 'Hello Vue!'
    },
    template: '<button >You clicked me times.</button>'
  })
}

window.onload = function() {
  var app = new Vue({
    el: '#vueapp',
    data: {
      message: 'Hello Vue!'
    }
  })
}
