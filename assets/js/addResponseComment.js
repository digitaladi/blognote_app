document.addEventListener("turbo:load", function() {
    // Your JS code that should run after a full page load


//console.log("je suis dans le fichier js addResponseComment.js")

//on met un ecouteur sur tous les bouttons "répondre"
//selectionner tous les élements qui ont l'attribut data-reply
document.querySelectorAll("[data-reply]").forEach(element => {
    //écouter le click sur chaque boutton réponse
    //attention mettre en callback une fonction normal au lieu d'une fonction fléché permet de récupérer le contexte du this (donc this correpond sur l'élément cliqué et non document)
    element.addEventListener("click", function(){
        //id : form_profil_comment_commet_id
      var valueInput =  document.getElementById("form_profil_comment_parent_id").value = this.dataset.id;
        console.log(valueInput)

    })
})


})