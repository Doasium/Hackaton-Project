(function ($) {

	"use strict";

	// Page loading animation
	$(window).on('load', function () {

		$('#js-preloader').addClass('loaded');

	});

	// WOW JS
	$(window).on('load', function () {
		if ($(".wow").length) {
			var wow = new WOW({
				boxClass: 'wow',
				animateClass: 'animated', 
				offset: 20, 
				mobile: true, 
				live: true,
			});
			wow.init();
		}
	});

	$(window).scroll(function () {
		var scroll = $(window).scrollTop();
		var box = $('.header-text').height();
		var header = $('header').height();

		if (scroll >= box - header) {
			$("header").addClass("background-header");
		} else {
			$("header").removeClass("background-header");
		}
	});

	$('.filters ul li').click(function () {
		$('.filters ul li').removeClass('active');
		$(this).addClass('active');

		var data = $(this).attr('data-filter');
		$grid.isotope({
			filter: data
		})
	});

	var $grid = $(".grid").isotope({
		itemSelector: ".all",
		percentPosition: true,
		masonry: {
			columnWidth: ".all"
		}
	})

	var width = $(window).width();
	$(window).resize(function () {
		if (width > 992 && $(window).width() < 992) {
			location.reload();
		} else if (width < 992 && $(window).width() > 992) {
			location.reload();
		}
	})



	$(document).on("click", ".naccs .menu div", function () {
		var numberIndex = $(this).index();

		if (!$(this).is("active")) {
			$(".naccs .menu div").removeClass("active");
			$(".naccs ul li").removeClass("active");

			$(this).addClass("active");
			$(".naccs ul").find("li:eq(" + numberIndex + ")").addClass("active");

			var listItemHeight = $(".naccs ul")
				.find("li:eq(" + numberIndex + ")")
				.innerHeight();
			$(".naccs ul").height(listItemHeight + "px");
		}
	});

	$('.owl-features').owlCarousel({
		items: 3,
		loop: true,
		dots: false,
		nav: true,
		autoplay: true,
		margin: 30,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1200: {
				items: 3
			},
			1800: {
				items: 3
			}
		}
	})

	$('.owl-collection').owlCarousel({
		items: 3,
		loop: true,
		dots: false,
		nav: true,
		autoplay: true,
		margin: 30,
		responsive: {
			0: {
				items: 1
			},
			800: {
				items: 2
			},
			1000: {
				items: 3
			}
		}
	})

	$('.owl-banner').owlCarousel({
		items: 1,
		loop: true,
		dots: false,
		nav: true,
		autoplay: true,
		margin: 30,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	})

	// Menu Dropdown Toggle
	if ($('.menu-trigger').length) {
		$(".menu-trigger").on('click', function () {
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}


	// Menu elevator animation
	$('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				var width = $(window).width();
				if (width < 991) {
					$('.menu-trigger').removeClass('active');
					$('.header-area .nav').slideUp(200);
				}
				$('html,body').animate({
					scrollTop: (target.offset().top) - 80
				}, 700);
				return false;
			}
		}
	});

	$(document).ready(function () {
		$(document).on("scroll", onScroll);

		//smoothscroll
		$('.scroll-to-section a[href^="#"]').on('click', function (e) {
			e.preventDefault();
			$(document).off("scroll");

			$('.scroll-to-section a').each(function () {
				$(this).removeClass('active');
			})
			$(this).addClass('active');

			var target = this.hash,
				menu = target;
			var target = $(this.hash);
			$('html, body').stop().animate({
				scrollTop: (target.offset().top) - 79
			}, 500, 'swing', function () {
				window.location.hash = target;
				$(document).on("scroll", onScroll);
			});
		});
	});

	function onScroll(event) {
		var scrollPos = $(document).scrollTop();
		$('.nav a').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.nav ul li a').removeClass("active");
				currLink.addClass("active");
			} else {
				currLink.removeClass("active");
			}
		});
	}


	// Page loading animation
	$(window).on('load', function () {
		if ($('.cover').length) {
			$('.cover').parallax({
				imageSrc: $('.cover').data('image'),
				zIndex: '1'
			});
		}

		$("#preloader").animate({
			'opacity': '0'
		}, 600, function () {
			setTimeout(function () {
				$("#preloader").css("visibility", "hidden").fadeOut();
			}, 300);
		});
	});



	const dropdownOpener = $('.main-nav ul.nav .has-sub > a');

	// Open/Close Submenus
	if (dropdownOpener.length) {
		dropdownOpener.each(function () {
			var _this = $(this);

			_this.on('tap click', function (e) {
				var thisItemParent = _this.parent('li'),
					thisItemParentSiblingsWithDrop = thisItemParent.siblings('.has-sub');

				if (thisItemParent.hasClass('has-sub')) {
					var submenu = thisItemParent.find('> ul.sub-menu');

					if (submenu.is(':visible')) {
						submenu.slideUp(450, 'easeInOutQuad');
						thisItemParent.removeClass('is-open-sub');
					} else {
						thisItemParent.addClass('is-open-sub');

						if (thisItemParentSiblingsWithDrop.length === 0) {
							thisItemParent.find('.sub-menu').slideUp(400, 'easeInOutQuad', function () {
								submenu.slideDown(250, 'easeInOutQuad');
							});
						} else {
							thisItemParent.siblings().removeClass('is-open-sub').find('.sub-menu').slideUp(250, 'easeInOutQuad', function () {
								submenu.slideDown(250, 'easeInOutQuad');
							});
						}
					}
				}

				e.preventDefault();
			});
		});
	}





})(window.jQuery);

jQuery(document).ready(function ($) {
	jQuery(document).on('click', '.iconInner', function (e) {
		jQuery(this).parents('.botIcon').addClass('showBotSubject');
		$("[name='msg']").focus();
	});

	jQuery(document).on('click', '.closeBtn, .chat_close_icon', function (e) {
		jQuery(this).parents('.botIcon').removeClass('showBotSubject');
		jQuery(this).parents('.botIcon').removeClass('showMessenger');
	});

	jQuery(document).on('submit', '#botSubject', function (e) {
		e.preventDefault();

		jQuery(this).parents('.botIcon').removeClass('showBotSubject');
		jQuery(this).parents('.botIcon').addClass('showMessenger');
	});

	/* Chatboat Code */
	$(document).on("submit", "#messenger", function (e) {
		e.preventDefault();

		var val = $("[name=msg]").val().toLowerCase();
		var mainval = $("[name=msg]").val();
		name = '';
		nowtime = new Date();
		nowhoue = nowtime.getHours();

		function userMsg(msg) {
			$('.Messages_list').append('<div class="msg user"><span class="avtr"><figure style="background-image: url(https://mrseankumar25.github.io/Sandeep-Kumar-Frontend-Developer-UI-Specialist/images/avatar.png)"></figure></span><span class="responsText">' + mainval + '</span></div>');
		};

		function appendMsg(msg) {
			$('.Messages_list').append('<div class="msg"><span class="avtr"><figure style="background-image: url(https://mrseankumar25.github.io/Sandeep-Kumar-Frontend-Developer-UI-Specialist/images/avatar.png)"></figure></span><span class="responsText">' + msg + '</span></div>');
			$("[name='msg']").val("");
		};


		userMsg(mainval);
		if (val.indexOf("hello") > -1 || val.indexOf("hi") > -1 || val.indexOf("good morning") > -1 || val.indexOf("good afternoon") > -1 || val.indexOf("good evening") > -1 || val.indexOf("good night") > -1) {
			if (nowhoue >= 12 && nowhoue <= 16) {
				appendMsg('good afternoon');
			} else if (nowhoue >= 10 && nowhoue <= 12) {
				appendMsg('hi');
			} else if (nowhoue >= 0 && nowhoue <= 10) {
				appendMsg('good morning');
			} else {
				appendMsg('good evening');
			}

			appendMsg("what's you name?");

		} else if (val.indexOf("i have problem with") > -1) {
			if (val.indexOf("girlfriend") > -1 || val.indexOf("gf") > -1) {

				appendMsg("take out your girlfriend, for dinner or movie.");
				appendMsg("is it helpful? (yes/no)");

			} else if (val.indexOf("boyfriend") > -1 || val.indexOf("bf") > -1) {
				appendMsg("bye something for him.");
				appendMsg("is it helpful? (yes/no)");
			} else {
				appendMsg("sorry, i'm not able to get you point, please ask something else.");
			}
		} else if (val.indexOf("yes") > -1) {

			var nowtime = new Date();
			var nowhoue = nowtime.getHours();
			appendMsg("it's my pleaser that i can help you");

			saybye();
		} else if (val.indexOf("no") > -1) {

			var nowtime = new Date();
			var nowhoue = nowtime.getHours();
			appendMsg("it's my bad that i can't able to help you. please try letter");

			saybye();
		} else if (val.indexOf("my name is ") > -1 || val.indexOf("i am ") > -1 || val.indexOf("i'm ") > -1 || val.split(" ").length < 2) {
			/*|| mainval != ""*/
			// var name = "";
			if (val.indexOf("my name is") > -1) {
				name = val.replace("my name is", "");
			} else if (val.indexOf("i am") > -1) {
				name = val.replace("i am", "");
			} else if (val.indexOf("i'm") > -1) {
				name = val.replace("i'm", "");
			} else {
				name = mainval;
			}

			// appendMsg("hi " + name + ", how can i help you?");
			appendMsg("hi " + name + ", how can i help you?");
		} else {
			appendMsg("sorry i'm not able to understand what do you want to say");
		}

		function saybye() {
			if (nowhoue <= 10) {
				appendMsg(" have nice day! :)");
			} else if (nowhoue >= 11 || nowhoue <= 20) {
				appendMsg(" bye!");
			} else {
				appendMsg(" good night!");
			}
		}

		var lastMsg = $('.Messages_list').find('.msg').last().offset().top;
		$('.Messages').animate({
			scrollTop: lastMsg
		}, 'slow');
	});
	/* Chatboat Code */
})