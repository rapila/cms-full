jQuery(document).ready(function(){
	jQuery("a[rel='lightbox']").fancybox({
		type: 'image',
		beforeLoad: function() {
			var link = this.element;
			var license_url = link.attr('data-license-url');
			var license_image = link.attr('data-license-image');
			if(license_url && license_image) {
				license_image = '<a href="'+license_url+'"><img src="'+license_image+'" /></a>';
				link.data('license-image-object', license_image);
			}
			this.title = link.attr('title') + ' ' + license_image;
		}
	});
});
