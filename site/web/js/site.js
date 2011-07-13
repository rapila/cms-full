jQuery(document).ready(function(){
	var color = jQuery.map(jQuery('header').css('background-color').split(','), function(color, i) {
		return color.match(/\d+/);
	}).slice(0, 3);
	color.push(40);
	jQuery("a[rel^='lightbox']").each(function() {
		Caman(jQuery(this).find('img')[0], function() {
			this.colorize.apply(this, color).render();
		});
	}).prettyPhoto({
		showTitle: true,
		theme: 'dark_square',
		allowresize: true
	});
});