// new namespace for ratings javascript
YAHOO.namespace('ratings');

YAHOO.ratings.main = {
	Dom: 			YAHOO.util.Dom,			// Some short-handed global events for YUI
	YE:				YAHOO.util.Event,
	$:				YAHOO.util.Dom.get,
	used_form:		true,					// Whether or not we want to use a form, also set by adding a class per rating div
	rating_action:	'/path/to/action',		// Form action to save the ratings, sent via post to this address
	rating_form:	'rating-form.html',		// If we are using a rating form, this is the path to that form
	// Instantiate the rating javascript
	init: function(){
		// No submissions have taken place, used later
        rating.submitted = false;
        // for each rating el, set it's style to display none
		var ratingEls = rating.Dom.getElementsByClassName('rating-el');
		var ratLen = (ratingEls.length);
		for(var i=0;i<ratLen;i++){
       		rating.Dom.setStyle(ratingEls[i], 'display', 'none');
		}
		// for each outer rating container, create the magic of stars!
        var ratingdivs = rating.Dom.getElementsByClassName('ratingdiv');
        var ratLen = (ratingdivs.length);
        for(i=0;i<ratLen;i++){
        	rating.make_stardiv(ratingdivs[i], i);
        }
	},
	// Creates each of the divs for the ratings to overwrite the element that exists in the page
	make_stardiv: function(ratingdiv, num){
		rating.Dom.setStyle(ratingdiv, 'width', '85px');

		var stardiv = document.createElement('div');
        rating.Dom.addClass(stardiv, 'rating');
		ratingdiv.appendChild(stardiv);

		// The text that we'll show messages on
        var notifytext = document.createElement('div');
		ratingdiv.appendChild(notifytext);
        rating.Dom.addClass(notifytext, 'notifytext');
        notifytext.innerHTML = 'Rate this business';
        notifytext.id = 'notify_' + num;

        var ratingel = rating.Dom.getFirstChild(ratingdiv);

		// Get the average rating from the title attribute of our node
        var average = ratingel.title.split(/:\s*/)[1].split(".");
		moParams = [stardiv, num, average];

        for (var i=1; i<=5; i++) {
            // first, make a div and then an a-element in it
            var star = document.createElement('div');
			star.id = 'star' + '_' + num + '_' + i;
            var a = document.createElement('a');
            a.href = '#' + i;
            a.innerHTML = i;
            rating.Dom.addClass(star, 'star');
            star.appendChild(a);
            stardiv.appendChild(star);

			moParams1 = [i, star, num];
			moParams2 = [stardiv, i, num];
            // add needed listeners to every star
            rating.YE.on(star, 'mouseover', rating.hover_star, moParams1);
            rating.YE.on(star, 'mouseout', rating.reset_stars, moParams);
            rating.YE.on(star, 'click', rating.get_rate_form, moParams2);
        }
        // show the average
        rating.reset_stars(null, moParams);
	},
	// The action to take when a star is hovered over
    hover_star: function(e, moParams1) {
    	var starNum = moParams1[0];
    	var star = moParams1[1];
    	var num = moParams1[2];
        for (var i=1; i<=starNum; i++) {
            var star = rating.$('star' + '_' + num + '_' + i);
            var a = star.firstChild;
            rating.Dom.addClass(star, 'hover');
            rating.Dom.setStyle(a, 'width', '100%');
        }
    },
	// Resets the stars back to their default value set in the average variable passed through in the array 'moParams'
    reset_stars: function(e, moParams) {
        // Resets the status of each star
        var stardiv = moParams[0];
		var num = moParams[1];
		var average = moParams[2];

        // If form is not submitted, the number of stars on depends on the given average value
        if (rating.submitted === false) {
            var stars_on = average[0];
            if (average[1] >= 0){
                stars_on = parseInt(average[0]) + 1;
            }
            var last_star_width = average[1] + '0%';
        } else {
            // if the form is submitted, then submitted number stays on
            stars_on = rating.submitted;
            last_star_width = '100%';
        }

		var starList = stardiv.getElementsByTagName('div');
		var starLen = (starList.length);
        // cycle through 1..5 stars
        for (var i=0; i<starLen; i++) {
        	var checkNum = i+1;

            var star = starList[i];
            var a = rating.Dom.getFirstChild(star);

            // first, reset all stars
            rating.Dom.removeClass(star, 'hover');
            rating.Dom.removeClass(star, 'on');

			if(i === 0){
                rating.Dom.setStyle(a, 'width', '100%');
			}
            // for every star that should be on, turn them on
            if (checkNum<=stars_on && !rating.Dom.hasClass(star, 'on')){
                rating.Dom.addClass(star, 'on');
			}
            // and for the last one, set width if needed
            if (checkNum == stars_on){
                rating.Dom.setStyle(a, 'width', last_star_width);
            }
        }

    },
	// Appends the review form the pop up after a rating has been clicked
    add_review_form: {
		customevents:{
	        onSuccess:function(eventType, args){
				if(args[0].responseText !== undefined){
					rating.review_cont.innerHTML+= args[0].responseText;
					// Create a hidden input with the rating value so that when the form
					// is submitted we get the rating that way, via the POST
					var hidIn = rating.createNamedElement('input', 'rating', 'hidden');
					hidIn.value = rating.finalnum;
					rating.$('add-review').appendChild(hidIn);

					var optImg = rating.review_cont.getElementsByTagName('img')[0];
					rating.YE.on(optImg, 'click', function(e){
						rating.review_form.parentNode.removeChild(rating.review_form);
					});

					var reviewForm = rating.review_cont.getElementsByTagName('form')[0];
					var oldRate = reviewForm.getElementsByTagName('p')[0];
					oldRate.parentNode.removeChild(oldRate);
					reviewForm.action = rating.rating_action;
					rating.YE.on(reviewForm, 'submit', rating.submit_rating, reviewForm);
				}
			}
		}
    },
    // Pops up the rating form
    get_rate_form: function(e, moParams2){
    	// If the form has not been submitted yet and submission is not in progress
        rating.YE.stopEvent(e);

		rating.stardiv = moParams2[0];
        rating.finalnum = moParams2[1];
        rating.starnum = moParams2[2];

		if(rating.used_form === true){
	        if(rating.Dom.hasClass(rating.stardiv.parentNode, 'no-form')){
	        	rating.used_form = false;
	        } else {
	        	rating.used_form = true;
	        }
		} else {
	        if(rating.Dom.hasClass(rating.stardiv.parentNode, 'use-form')){
	        	rating.used_form = true;
	        } else {
	        	rating.used_form = false;
	        }
		}

		if(rating.used_form === true){

	        var posCoords = rating.YE.getXY(e);
	        posX = posCoords[0] - 436;
	        if(posX < 0){
	        	posX = 0;
	        }
	        posY = posCoords[1];

			// Create our popup and get the form if it doesn't already exist
	        rating.review_form = rating.$('review-form');
	        rating.review_cont = rating.$('review-form-cont');
	        if(rating.review_form){
	        	rating.Dom.setStyle(rating.review_form, 'display', 'block');
	        	rating.Dom.setStyle(rating.review_form, 'top', posY + 'px');
	        	rating.Dom.setStyle(rating.review_form, 'left', posX + 'px');
	        } else {
	        	rating.review_form = document.createElement('div');
	        	document.body.appendChild(rating.review_form);
	        	rating.review_form.id = 'review-form';

	        	rating.review_cont = document.createElement('div');
	        	rating.review_form.appendChild(rating.review_cont);
	        	rating.review_cont.id = 'review-form-cont';

	        	var optImg = document.createElement('img');
				rating.review_cont.appendChild(optImg);
				optImg.src = 'images/button-close.png';
				optImg.alt = 'Close This Popup';
				rating.YE.on(optImg, 'click', function(e){
					rating.review_form.parentNode.removeChild(rating.review_form);
				});

				var h3Tag = document.createElement('h3');
	        	rating.review_cont.appendChild(h3Tag);
	        	h3Tag.appendChild(document.createTextNode('Add Your Review'));

	        	rating.Dom.setStyle(rating.review_form, 'position', 'absolute');
	        	rating.Dom.setStyle(rating.review_form, 'top', posY + 'px');
	        	rating.Dom.setStyle(rating.review_form, 'left', posX + 'px');
	        }

	       	var request = YAHOO.util.Connect.asyncRequest('POST', rating.rating_form, rating.add_review_form);
       	} else {
       		var reviewForm = document.createElement('form');
       		reviewForm.action = rating.action;
       		reviewForm.method = 'post';

       		var ratingIn = rating.createNamedElement('input', 'rating', 'hidden');
       		ratingIn.value = rating.finalnum;
       		reviewForm.appendChild(ratingIn);
			rating.submit_rating(null, reviewForm);
       	}
    },
	// Actions to take when a star has been clicked to add a rating
    submit_rating: function(e, rateForm) {
		// The submission functions to send the rating via ajax, may not be used in this context
        rating.notifyText = rating.Dom.getLastChild(rating.stardiv.parentNode);
        if (rating.submitted === false) {
        	if(e){
	        	rating.YE.stopEvent(e);
	        }
            rating.submitted = rating.finalnum;

            // change the statustext div and show it
            rating.notifyText.innerHTML = 'Saving rating...';
            var notify_display = new YAHOO.util.Anim(rating.notifyText, { opacity: { to: 1 } }, 0.25, YAHOO.util.Easing.easeIn);
            notify_display.animate();

            // change the rating-value for the form and submit the form
            var post_to = rateForm.action;
            YAHOO.util.Connect.setForm(rateForm);
            var c = YAHOO.util.Connect.asyncRequest('POST', rating.rating_action, rating.ajax_callback);
        }
    },
	// Callback function once the reviews have been submitted
    ajax_callback:{
		customevents:{
	        onSuccess:function(eventType, args){
				if(args[0].responseText !== undefined){
            		var isRated = args[0].responseText.split('|');
            		rating.submitted = false;
            		if(isRated[0] === 'failure'){
	           			rating.notifyText.innerHTML = 'Already rated!';
            		} else if(isRated[0] === 'session'){
	           			rating.notifyText.innerHTML = 'Must be <a href="/login.html" title="Log In" style="float:none">logged in</a>';
					} else {
	           			rating.notifyText.innerHTML = 'Thanks for rating!';
					}

           			rating.Dom.addClass(rating.stardiv, 'rated');
           			if(isRated[1]){
			        	average = isRated[1].split('.');
			        } else {
			        	average = rating.finalnum + '.0';
			        }
					moParams = [rating.stardiv, rating.finalnum, average];
		        	rating.reset_stars(null, moParams);

		        	for (var i=1; i<=5; i++) {
			            var star = rating.$('star' + '_' + rating.starnum + '_' + i);
		            	rating.YE.removeListener(star, 'click');
		            	rating.YE.removeListener(star, 'mouseover');
		            	rating.YE.removeListener(star, 'mouseout');
						rating.YE.on(star, 'click', rating.show_clicked, star);
					}

					rating.review_form.parentNode.removeChild(rating.review_form);
    			}
    		}
    	}
    },
	// Shows a message that the business has already been rated
    show_clicked: function(e, star){
    	rating.YE.stopEvent(e);
    	notifyText = rating.Dom.getAncestorByTagName(star, 'div');
    	notifyText = rating.Dom.getAncestorByTagName(notifyText, 'div');
    	rating.notifyText = rating.Dom.getLastChild(notifyText);
    	var oldText = rating.notifyText.innerHTML;
    	rating.notifyText.innerHTML = 'Already rated!';
    	if(oldText !== 'Already rated!'){
	    	setTimeout(rating.hide_clicked, 2000);
	    }
    },

    hide_clicked: function(){
    	rating.notifyText.innerHTML = 'Thanks for rating!';
    },

	createNamedElement: function(type, name, secType) {
	  var element;
	  try {
	    element = document.createElement('<'+type+' name="'+name+'" type="'+secType+'">');
	  } catch (e) {}
	  if (!element || !element.name) { // Not in IE, then
	    element = document.createElement(type);
	    element.name = name;
	    element.type = secType;
	  }
	  return element;
	}
}

rating = YAHOO.ratings.main;
rating.YE.onDOMReady(rating.init);