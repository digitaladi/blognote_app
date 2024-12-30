console.log("je suis dans le fichier js scripts.js")


/*
document.getElementById("heart").onclick = function(){

    document.querySelector(".fa-gratipay").style.color = "#E74C3C";
};

*/






//TRAITEMENT DU TAB DANS LA PAGE HOME


/*

var elements = document.getElementById("lien_tab").getElementsByClassName("nav-link");
Array.prototype.forEach.call(elements, function(el) {
    // Do stuff here
 
   // console.log(el.tagName);
    el.addEventListener("click", function (e) {
        el.classList.add("active")
        //alert("ok");
        console.log("this.className"); // logs the className of my_element
    
      });



});
*/

/*

						{% if comment.comments is not empty %}

							{% for response in comment.comments %}

								<div class="mt-3  ms-3 ps-3 mb-4 pb-1 border-start">
									<p>{{ response.content|nl2br }}</p>
									<p class="text-end mb-0 text-primary">

										<a class="text-primary" href="#add-comment" data-turbo="false" data-reply data-id="{{ response.id }}">Répondre</a>
										{{ ux_icon('ri:reply-fill', {height:'20px', width:'20px'}) }}</p>
								</div>

							{% endfor %}

						{% endif %}

*/