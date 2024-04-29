/**
 * Functionality specific to Nathalie_Mota.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	var body    = $( 'body' ),
	    _window = $( window );

  /**
   * Changed Gravity Forms Default Style to Bootstrap Style
   */
  var gform = $(document).find('.gform_wrapper').attr('class');
  if(typeof gform !== 'undefined' && gform !== 'false'){
    $(document).on('gform_post_render',function(){
      var form = $('.gform_wrapper');
      var required = $('.gfield_contains_required');
      var controlGroup = $('.gfield');
      required.each(function(){
        $(this).find('input, textarea, select').not('input[type="checkbox"], input[type="radio"]').attr('required', 'true');
      });
      $('.gform_fields').each(function(){
        $(this).addClass('row');
      });
      controlGroup.each(function(){
        $(this).addClass('form-group').find('input, textarea, select').not('input[type="checkbox"], input[type="radio"], input[type="file"]').after('<span class="help-block"></span>').addClass('form-control');
      });
      form.find("input[type='submit'], input[type='button']").addClass('btn btn-primary').end().find('.gfield_error').removeClass('gfield_error').addClass('has-error');
      $('.gfield_checkbox, .gfield_radio').find('input[type="checkbox"], input[type="radio"]').each(function(){
        var sib = $(this).siblings('label');
        $(this).prependTo(sib);
      }).end().each(function(){
        $(this).after('<span class="help-block"></span>');
        if($(this).is('.gfield_checkbox')){
          $(this).addClass('checkbox');
        } else {
          $(this).addClass('radio');
        }
      });
      $('.validation_message').each(function(){
        var sib = $(this).prev().find('.help-block');
        $(this).appendTo(sib);
      });
      $('.validation_error').addClass('alert alert-danger');
      $('.gf_progressbar').addClass('progress progress-striped active').children('.gf_progressbar_percentage').addClass('progress-bar progress-bar-success');
    });
  }

	/**
	 * Adds a top margin to the footer if the sidebar widget area is higher
	 * than the rest of the page, to help the footer always visually clear
	 * the sidebar.
	 */
	$( function() {
		if ( body.is( '.sidebar' ) ) {
			var sidebar   = $( '#secondary .widget-area' ),
			    secondary = ( 0 === sidebar.length ) ? -40 : sidebar.height(),
			    margin    = $( '#tertiary .widget-area' ).height() - $( '#content' ).height() - secondary;

			if ( margin > 0 && _window.innerWidth() > 999 ) {
				$( '#colophon' ).css( 'margin-top', margin + 'px' );
			}
		}
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var nav = $( '#site-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click.Nathalie_Mota', function() {
			nav.toggleClass( 'toggled-on' );
		} );

		// Better focus for hidden submenu items for accessibility.
		menu.find( 'a' ).on( 'focus.Nathalie_Mota blur.Nathalie_Mota', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		} );
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.Nathalie_Mota', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();
		}
	} );

	// Filter of photos
	var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
    for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
    }
    return null;
  };

function buildUrl(param, value) {
	let format = getUrlParameter("format") ? "format=" + getUrlParameter("format") + "&" : "";
	let category = getUrlParameter("category") ? "category=" + getUrlParameter("category") + "&" : "";
	let date = getUrlParameter("date") ? "date=" + getUrlParameter("date") + "&" : "";

	if (param == "format") format = "format=" + value + "&";
	if (param == "category") category = "category=" + value + "&";
	if (param == "date") date = "date=" + value + "&";

	let currentURL = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'  + (category) + (format) + (date);

	window.history.pushState({ path: currentURL }, '', currentURL);
}
function toFilter() {
	var format_selected = $('#format-selected').val();
	var category_selected = $('#category-selected').val();
	var date_selected = $('#date-selected').val();
	let for_tag = false;
	let for_format = false;
	
	$('.photos-items').each(function () {
		var filtertags = $(this).attr("data-categorie").split(",");
		var filterformat = $(this).attr("data-format").split(",");
		if (date_selected === "ASC") {
			$(".photo-items .photos-items").sort(function (a, b) {
					var dateA = parseCustomDate($(a).data("date"));
					var dateB = parseCustomDate($(b).data("date"));
					return dateA - dateB;
			}).appendTo('.photo-items');
		} else if (date_selected === "DESC") {
			$(".photo-items .photos-items").sort(function (a, b) {
					var dateA = parseCustomDate($(a).data("date"));
					var dateB = parseCustomDate($(b).data("date"));
					return dateB - dateA;
			}).appendTo('.photo-items');
		}
			if (category_selected.length > 0) {
				var category_selected_array = category_selected.split(",");
				var commonCategory = filtertags.filter(x => category_selected_array.indexOf(x) !== -1);
				for_tag = commonCategory.length > 0;
			}
			else {
				for_tag = true;
			}
			if (format_selected.length > 0) {
				var format_selected_array = format_selected.split(",");
				var commonFormat = filterformat.filter(x => format_selected_array.indexOf(x) !== -1);
				for_format = commonFormat.length > 0;
		    }
			else {
				for_format = true;
			}
		
			if (for_format && for_tag) {
				$(this).removeClass("d-none");
			} else {
				$(this).addClass("d-none");
			}
			if ($('.photos-items:visible').length === 0) {
        $('.photolabel').addClass('d-block').removeClass('d-none');
			} else {
				$('.photolabel').addClass('d-none').removeClass('d-block');
			}
	});
}
// Formate date
function parseCustomDate(customDate) {
	var parts = customDate.split("/");
	var day = parseInt(parts[0]);
	var month = parseInt(parts[1]) - 1; 
	var year = parseInt(parts[2]) + 2000; 
	return new Date(year, month, day);
}


function toPaginateInitial() {
	var HZwrapper = 'photo-items'; 
	var HZlines = 'photos-items'; 
	var HZperPage = 8; 
	var elementsToShow = HZperPage; 
	var $photosWrapper = $('.' + HZwrapper);

	$photosWrapper.find('.' + HZlines).addClass('d-none');
	$photosWrapper.find('.' + HZlines).slice(0, elementsToShow).removeClass('d-none').addClass('d-block');
	var totalElements = $photosWrapper.find('.' + HZlines).length;
	if (totalElements > HZperPage) {
		$('#loadMoreBtn').removeClass('d-none').addClass('d-block');
	}
	$('#loadMoreBtn').on('click', function() {
		elementsToShow += HZperPage;
		$photosWrapper.find('.' + HZlines + ':lt(' + elementsToShow + ')').removeClass('d-none').addClass('d-block');

		if (elementsToShow >= totalElements) {
			$('#loadMoreBtn').addClass('d-none');
		}
	});
}
function toPaginate() {
	var categoryFilter = $("#category-selected").val();
	var formatFilter = $("#format-selected").val();

	$('.photos-items').each(function(index, value) {
		var category = $(this).data('categorie');
		var format = $(this).data('format');
		if (category === categoryFilter && format === formatFilter) {
			$(this).addClass("photos-paginate");
			$(this).addClass("d-block");
		} else {
			$(this).removeClass("photos-paginate");
			$(this).removeClass("d-block");
		}
	});

	var visibleItems = $('.photos-paginate:not(.d-none)');

	if (visibleItems.length > 8) {
		$('.photos-paginate').slice(8).addClass('d-none');
	}
	if ($('.photos-paginate.d-none').length === 0) {
		$('#loadMoreBtn').addClass('d-none');
	} else {
		$('#loadMoreBtn').removeClass('d-none');
	}

	$('#loadMoreBtn').off('click').on('click', function() {
		$('.photos-paginate.d-none').slice(0, 8).removeClass('d-none');
		if ($('.photos-paginate.d-none').length === 0) {
			$('#loadMoreBtn').addClass('d-none');
		}
	});
}

$(document).ready(function() {
	$("#format-selected").val("");
	if (getUrlParameter("format")) {
		$("#format-selected").val(getUrlParameter("format"));
	}
	$("#date-selected").val("");
	if (getUrlParameter("date")) {
		$("#date-selected").val(getUrlParameter("date"));
	}
	$("#category-selected").val("");
	if (getUrlParameter("category")) {
		$("#category-selected").val(getUrlParameter("category"));
	}

	if (getUrlParameter("format") || getUrlParameter("category") || getUrlParameter("date")) {
		toFilter()
		toPaginate();
	} else {
		toPaginateInitial()
	}
});
$(document).on('click', '.list-tag', function () {
	let category_selected = $(this).text().trimStart().trimEnd();
	let currentSelection = $("#category-selected").val();
	if (currentSelection !== category_selected) {
		$("#category-selected").val(category_selected); 
		$(this).addClass("selected"); 
		$(".list-tag").not(this).removeClass("selected"); 
		$(".categories-filter a").text(category_selected);
		buildUrl("category", category_selected); 
		toFilter(); 
		toPaginate();
	}
});

$(document).on('click', '.list-format', function () {
	let format_selected = $(this).text().trimStart().trimEnd();
	let currentSelection = $("#format-selected").val();
	if (currentSelection !== format_selected) {
		$("#format-selected").val(format_selected); 
		$(this).addClass("selected"); 
		$(".list-format").not(this).removeClass("selected");
		$(".format-filter a").text(format_selected);
		buildUrl("format", format_selected);
		toFilter();
		toPaginate();
		}
});

$(document).on('click', '.list-day', function () {
	let date_selected = $(this).attr("data-day");
	let day_selected = $(this).text().trimStart().trimEnd();
	let currentSelection = $("#date-selected").val();
	if (currentSelection !== date_selected) {
		$("#date-selected").val(date_selected); 
		$(this).addClass("selected"); 
		$(".list-day").not(this).removeClass("selected");
		$(".day-filter a").text(day_selected);
		buildUrl("date", date_selected);
		toFilter();
		toPaginate();
	}
});
$(document).ready(function () {
	var reference = $('input[name=reference]').val();
	$('input[name=your-ref]').val(reference);
});

	/**
	 * Arranges footer widgets vertically.
	 */
	if ( $.isFunction( $.fn.masonry ) ) {
		var columnWidth = body.is( '.sidebar' ) ? 228 : 245;

		$( '#secondary .widget-area' ).masonry( {
			itemSelector: '.widget',
			columnWidth: columnWidth,
			gutterWidth: 20,
			isRTL: body.is( '.rtl' )
		} );
	}

  var wow = new WOW({
    animateClass: 'animate__animated', // animation css class (default is animated)
  });
  wow.init();
  $(document).ready(function($) {
    var image = $('.photo-items');
		var pic_data = ajax_object.pic_data;
    image.slickLightbox({
      src: 'data-src',
      itemSelector: '.photos-image-hover > .icon-lighbox',
    }).on({
			'show.slickLightbox': function(){ 
				$('.slick-lightbox-slick-item-inner').each(function() {
					var the_src = $(this).find('img').attr('src');
						var ref = pic_data[the_src].ref;
						var cat = pic_data[the_src].cat;
						$(this).append('<div class="d-flex justify-content-between" style="color: white;max-width:90%;margin:0 auto"><div class="thepicref">'+ ref + '</div><div class="thepiccat">'+ cat +'</div></div>');
				});
			 },
		});

		$('.modalcontent a').on('click', function(event) {
			event.preventDefault();
			$('#exampleModal').modal('show');
	});

  });
} )( jQuery );

