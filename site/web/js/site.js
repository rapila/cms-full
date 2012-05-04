jQuery(document).ready(function(){
	var color = jQuery.map(jQuery('header').css('background-color').split(','), function(color, i) {
		return color.match(/\d+/);
	}).slice(0, 3);
	color.push(40);
	jQuery("a[rel^='lightbox']").each(function() {
		var link = jQuery(this);
		Caman(link.find('img')[0], function() {
			this.colorize.apply(this, color).render();
		});
		var license_url = link.attr('data-license-url');
		var license_image = link.attr('data-license-image');
		if(license_url && license_image) {
			license_image = '<a href="'+license_url+'"><img src="'+license_image+'" /></a>';
		}
		link.prettyPhoto({
			showTitle: true,
			theme: 'dark_square',
			allowresize: true,
			overlay_gallery: false,
			keyboard_shortcuts: false,
			gallery_markup: '',
			social_tools: license_image,
			deeplinking: false
		});
	});
});
