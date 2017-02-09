(function(){
	"use strict";
	var links = document.querySelectorAll('.clickable-yt');

	var playYoutubeEmbed = function(e){
		e.preventDefault();
		console.log(e.currentTarget);
		var embedID = e.currentTarget.getAttribute('data-youtube-id');
		var embed = '<iframe src="https://www.youtube.com/embed/' + embedID + '?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>';
		e.currentTarget.innerHTML = embed;

		e.currentTarget.removeEventListener('click', playYoutubeEmbed, false);
		return false;
	};

	for (var i = links.length - 1; i >= 0; i--) {
		links[i].addEventListener('click', playYoutubeEmbed, false);
	}
}());