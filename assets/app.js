
import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

//on importe le css app.css
import './styles/app.css';

//on importe le css bootstrap.min.css
import './styles/bootstrap.min.css';

//on importe le js scripts.js
import './js/scripts.js';


//importe le fichier js addResponseComment.js
import './js/addResponseComment.js';


//récuperer le module
import { maj } from './js/my_module.js';

//console.log(maj("aladi"))

//console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');



