// go through all the map area elements, and add javascript event into each one of them 

var areas = document.querySelectorAll('.category')
var subarea = document.querySelector('#sub-category')
console.log( subarea )

areas.forEach(function(area, idx) {
    area.addEventListener('click', function(event) {
       showImg(event)
    })
})

var showImg = function(event) {
   var categoryName = event.target.title 
   console.log( categoryName )
    
   subarea.src = `./public/img/${categoryName}.png`
}

