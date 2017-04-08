(function($) {
	
	$(document).ready(function() {
		$('.menu-section-container-container').hide();
		
		$('body').on('click', '.menu-section-title', function() {
			$(this).find('.arrow').toggleClass('open');
			var parent = $(this).parent();
			if (parent.hasClass('open')) {
				$(this).siblings('.menu-section-container-container').slideToggle(400, function() {
					parent.toggleClass('open');
				});
			} else {
				parent.toggleClass('open');
				$(this).siblings('.menu-section-container-container').slideToggle();
				var positioners = $(this).siblings('.menu-section-container-container').find('.positioner');
				positioners.each(function() {
					imageSize($(this));
				});
			}
			
		});
		
		$(window).resize(imageSizes);
	});
	
	function imageSize(positioner) {
		var containedImage = positioner.find('.section-image');
		if (positioner.height() < positioner.width()) {
			containedImage.addClass('cut').removeClass('full');
		} else {
			containedImage.addClass('full').removeClass('cut');
		}
	}
	
	function imageSizes() {
		$('.positioner').each(function() {
			imageSize($(this));
		});
	}
	
}) (jQuery);
