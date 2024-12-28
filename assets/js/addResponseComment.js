
document.addEventListener("turbo:load", function() {
    // Your JS code that should run after a full page load


//console.log("je suis dans le fichier js addResponseComment.js")

//selectionner tous les élements qui ont l'attribut data-reply
document.querySelectorAll("[data-reply]").forEach(element => {
    element.addEventListener("click", function(){
        console.log(this)
    })
})


});