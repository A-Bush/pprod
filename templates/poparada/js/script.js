var POPARADA_MAPTYPE_ID = 'poparada_style';
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

function initialize() {
  var featureOpts = [{
    "featureType": "road",
    "stylers": [{
      "hue": "#ff0000"
    }, {
      "saturation": -48
    }]
  }, {
    "featureType": "water",
    "stylers": [{
      "hue": "#00bbff"
    }, {
      "saturation": -74
    }, {
      "lightness": 58
    }]
  }, {
    "featureType": "landscape",
    "stylers": [{
      "hue": "#ff0000"
    }, {
      "gamma": 1
    }, {
      "saturation": -100
    }, {
      "lightness": -4
    }]
  }];
  directionsDisplay = new google.maps.DirectionsRenderer();
  var poparadaCoord = new google.maps.LatLng(50.398360, 30.499980);
  var goloseevskaCoord = new google.maps.LatLng(50.397453, 30.508364);

  var mapOptions = {
    center: poparadaCoord,
    zoom: 16,
    mapTypeId: POPARADA_MAPTYPE_ID,
    scrollwheel: false
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  /*direction*/
  directionsDisplay.setMap(map);
  var request = {
    origin: goloseevskaCoord,
    destination: poparadaCoord,
    travelMode: google.maps.TravelMode.WALKING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });


  /*style*/
  var styledMapOptions = {
    name: 'Poparada Style'
  };

  var poparadaMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

  map.mapTypes.set(POPARADA_MAPTYPE_ID, poparadaMapType);

  /*marker*/
  var image = '/popa/rada/images/poparada_sm.png';
  var poparadaMarker = new google.maps.Marker({
    position: poparadaCoord,
    map: map,
    icon: image
  });

}
google.maps.event.addDomListener(window, 'load', initialize);

jQuery(document).ready(function($) {
  if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined') {
    Element.implement({
      slide: function(how, mode) {
        return this;
      },
      hide: function() {
        if (this.hasClass("deeper")) {
          return this;
        }
        mHide.apply(this, arguments);
      }
    });
  }
  var topNav = $('#top-nav');
  var subNav = $('#top-subnav');
  var subNavList = $('#top-subnavlist');
  var listWithDdown = $('#list-with-ddown');
  var ddownList = $('#list-with-ddown .ddown-list');


  /*drop down submenu*/
  var clicked;
  listWithDdown.on('click', '>li:not(:first-child)>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    var top = listWithDdown.offset().top + listWithDdown.outerHeight(true);
    if (!clicked || clicked.is($(this))) {
      clicked = $(this);
      clicked.next('.ddown-list').toggle().offset({
        top: top,
        left: 0
      });
    } else {
      clicked.next('.ddown-list').hide();
      clicked = $(this);
      clicked.next('.ddown-list').toggle().offset({
        top: top,
        left: 0
      });
    }
  });
  ddownList.on('click', '>li>a', function(event) {
    ddownList.hide();
  });

  $('.img-one-height').height(200);
  jQuery('.dropdown-toggle').dropdown();

  NavBarView.collapseNavToggleClass('#navbar-collapse-1', 'list-inline');
  if (jQuery('#price_eq').length) {
    NavBarView.getPrices();
  }

  NavBarView.carousel();
  /*subnav*/
  NavBarView.fixSubNav(subNav, topNav);
  NavBarView.fillSubNavList(subNavList);
  NavBarView.goTop();

});

var NavBarView = {
  collapseNavToggleClass: function(selector, className) {
    jQuery(selector).on('show.bs.collapse', function() {
      jQuery(this).children('ul').css('position', 'static');
      jQuery(this).find('.collapse-toggle').toggleClass(className);
      jQuery(this).css('background', '#fff');
    });
    jQuery(selector).on('hide.bs.collapse', function() {
      jQuery(this).find('.collapse-toggle').toggleClass(className);
      jQuery(this).css('background', 'none');
    });
  },
  carousel: function(selector) {
    jQuery('#carousel-slider').carousel();
  },
  getPrices: function() {
    var self = this;
    var priceEl = jQuery('#price_eq');
    var itemPrice = parseFloat(priceEl.html().replace(',', ''));
    var sizePrice = 0;
    var fabricPrice = 0;
    var result = 0;
    var qtyPrice = 1;
    var sizeOptionValue;
    //      var size = jQuery('#selectSize option:selected')[0].value;
    var size = (jQuery('#selectSize option:selected')[0] != null) ? (jQuery('#selectSize option:selected')[0].value) : 0;
    // getPrice();
    jQuery('#selectSize').change(function() {
      size = this.value;
      jQuery('.fabrics-accordion input:checked').each(function(i, el) {
        checkFabric.call(el);
      })
    });
    jQuery('.fabrics-accordion input:radio').change(function() {
      this.checked = true;
      checkFabric.call(this);
      self.increaseHits();
    });
    jQuery('input[name="product_qty"]').change(function() {
      qtyPrice = +(jQuery(this).val());
      getPrice();
    });

    function checkFabric() {
      var category = parseInt(jQuery(this).attr('data-category'));
      sizeOptionValue = category + size;
      // sizeOptionValue = parseInt(jQuery(this).attr('data-category')) + sizeOptionValue;
      if (typeof sizesOptions !== 'undefined' && typeof sizesValues !== 'undefined') {
        if (jQuery(this).attr('data-product-option') == 'fabricsModal1') {
          sizesValues[0] = ({
            name: jQuery('#selectSize')[0].name,
            value: sizesOptions[sizeOptionValue].id
          });
          sizePrice = sizesOptions[sizeOptionValue].price;
        } else {
          var size2Opt = jQuery('.size2options input[data-name=' + sizeOptionValue + ']');
          size2Opt[0].checked = true;
          fabricPrice = +(size2Opt.attr('data-to-price'));
        }
      }
      getPrice();
    }

    function getPrice() {

      if (fabricPrice) {

        result = (sizePrice + fabricPrice) / 2 * qtyPrice;
      } else {
        result = (sizePrice) * qtyPrice;

      }
      priceEl.html(result.toFixed(2) + 'грн.');
    }

  },
  addSlick: {
    synced: function() {
      jQuery('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        arrows: true,
        // dots: true,
        fade: true,
        asNavFor: '.slider-nav'
      });
      jQuery('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 500,
        asNavFor: '.slider-for',
        arrows: false,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        //variableWidth: true
      });
    },
    center: function() {
      jQuery('.center').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        arrows: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            arrows: true,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 2
          }
        }, {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 1
          }
        }]
      });
    },
    single: function() {
      jQuery('.single-item').slick();
    },
    multiple: function() {
      jQuery('.multiple-items').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 3,
        responsive: [{
          breakpoint: 900,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 2,
            infinite: true
          }
        }, {
          breakpoint: 600,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true
          }
        }]
      });
    },
    responsive: function() {
      jQuery('.responsive').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 8,
        slidesToScroll: 4,
        responsive: [{
          breakpoint: 900,
          settings: {
            slidesToShow: 6,
            slidesToScroll: 3,
            infinite: true
          }
        }, {
          breakpoint: 600,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 2,
            infinite: true
          }
        }, {
          breakpoint: 480,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
          }
        }]
      });
      var responsiveSlide = jQuery('.responsive.slick-initialized .slick-slide');
      responsiveSlide.height(responsiveSlide.width());
    },
    varWidth: function() {
      jQuery('.variable-width').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        centerMode: true,
        centerPadding: '20px',
        variableWidth: true
      });
    },
    varBlog: function() {
      jQuery('.variable-width').slick({
        infinite: true,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        centerMode: true,
        centerPadding: '50px',
        variableWidth: true,
        responsive: [{
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true
          }
        }]
      });
    }
  },
  addAccordion: function($) {
    jQuery('.fabrics-accordion').on('show.bs.collapse', function(e) {
      $(e.target).prev().addClass('fabric-active');
      // console.log('show');
    });
    jQuery('.fabrics-accordion').on('hide.bs.collapse', function(e) {
      $(e.target).prev().removeClass('fabric-active');
    });
  },
  increaseHits: function() {
    // var id = jQuery(this).closest('.fabric-group')[0].id;

    // jQuery.post(
    //             '<?php echo JURI::base(); ?>includes/increase_hits.php',
    //             {option:'com_k2store', view:'mycart', id:id},
    //             function(data, status){
    //               console.log(data, status);
    //               // jQuery('#article_hits').html(data);
    //             },
    //             'text'
    //     );
    //   this.checked = true;
    //   var modal =  jQuery(this).closest('.fabricsModal');
    //   modal.modal('hide');
  },
  fixSubNav: function(subNav, topNav) {
    var subNavTop = subNav.offset().top,
      top, wScrollTop,
      topNavHeight = topNav.height(),
      limit = 40,
      padTop = jQuery('.inline-nav a').css('padding-top').replace('px', '');

    jQuery(window).scroll(function() {

      wScrollTop = jQuery(this).scrollTop();
      var percent = Math.floor(wScrollTop / 10);
      var newHeight = Math.floor(topNavHeight - topNavHeight * (percent / 100));

      if (jQuery(window).width() >= 768) {
        subNav.find('.ddown-list:visible').hide();
      }

      topNav.height(newHeight);
      if (percent < limit) {
        var coef = ((100 - percent) / 100);
        topNav.find('.navbar-header > *, .navbar-right').css({
          '-ms-transform': 'scale(' + coef + ')',
          '-webkit-transform': 'scale(' + coef + ')',
          'transform': 'scale(' + coef + ')'
        });
        topNav.find('.inline-nav a').css({
          'padding-top': (padTop * coef) + 'px',
          'padding-bottom': (padTop * coef) + 'px'
        });
      } else {
        topNav.find('.navbar-header > *, .navbar-right').css({
          '-ms-transform': 'scale(' + ((100 - limit) / 100) + ')',
          '-webkit-transform': 'scale(' + ((100 - limit) / 100) + ')',
          'transform': 'scale(' + ((100 - limit) / 100) + ')'
        });
        topNav.find('.inline-nav a').css({
          'padding-top': '10px',
          'padding-bottom': '10px'
        });
      }

      top = topNav.outerHeight();
      /*ununderstandable IE 1px*/
      if (subNavTop + 1 < wScrollTop + top) {
        topNav.css('background-color', 'rgba(255,255,255,0.95)');
        subNav.removeClass('start-position').addClass('fixedsubnav');
        subNav.css({
          top: top
        });
        if (jQuery(window).width() <= 768) {
          subNav.find('.ddown-list:visible').css({
            top: 80
          });
        }
      } else {
        topNav.css('background-color', 'rgba(255,255,255,0)');
        subNav.removeClass('fixedsubnav').addClass('start-position');
        subNav.css({
          top: 'auto'
        });
        if (jQuery(window).width() <= 768) {
          subNav.find('.ddown-list:visible').css({
            top: 110
          });
        }
      }

    });
  },
  fillSubNavList: function(subNavList) {
    var items = jQuery('.item-title');
    if (items.length) {
      items.each(function(index, val) {
        /* iterate through array or object */
        subNavList.append('<li><a href="#' + val.id + '">' + jQuery(val).text().trim() + '</a></li>')
      });
    } else {
      subNavList.hide();
    }

  },
  ratingStars: function(stars, rating) {
    colorStars(stars, rating);

    function colorStars(stars, num) {
      // body...
      stars.each(function(index, el) {
        if (index < num) {
          el.removeClass('glyphicon-star-empty');
          el.addClass('glyphicon-star');
        }
      });
    };

    function clearStars(stars) {
      stars.addClass('glyphicon-star-empty');
      stars.removeClass('glyphicon-star');
    };
    jQuery('.itemRatingList').hover(function(e) {
      /* Stuff to do when the mouse enters the element */

      jQuery('.itemRatingList>li').hover(function() {
        /* Stuff to do when the mouse enters the element */
        clearStars(stars);
        var num = +(jQuery(this).find('.stars').next('span').text());
        colorStars(stars, num);
      }, function() {
        /* Stuff to do when the mouse leaves the element */
        clearStars(stars);
      });
    }, function() {
      /* Stuff to do when the mouse leaves the element */
      colorStars(stars, rating);
    });
  },
  loopImages: function(images, $) {

    images.each(function(index, el) {
      var stop = false;
      $(el).hover(function(e) {
        /* Stuff to do when the mouse enters the element */
        stop = false;
        loop($(this).find('img:visible'), 0);
      }, function() {
        /* Stuff to do when the mouse leaves the element */
        stop = true;
      });

      function loop(elt, delay) {
        if (!stop) {
          if ($(elt).next('img').length) {
            $(elt).delay(delay).fadeOut(100, function() {
              $(elt).next('img').fadeIn(400, function() {
                loop(this, 800);
              });
            });
          } else if ($(elt).prev('img').length) {
            $(elt).delay(delay).fadeOut(100, function() {
              $(elt).prevAll().last().fadeIn(400, function() {
                loop(this, 800);
              });
            });
          };
        }
      }
    });
  },
  slideShow: function(el) {
    el.hover(function() {
      /* Stuff to do when the mouse enters the element */
      jQuery(this).find('.catItemIntroText').slideDown(400);
      console.log('slideShow');
    }, function() {
      /* Stuff to do when the mouse leaves the element */
      jQuery(this).find('.catItemIntroText').slideUp(400);
    });
  },
  hoverImgs: function(imgs) {
    imgs.hover(function() {
      /* Stuff to do when the mouse enters the element */
      jQuery(this).css('opacity', '1');
    }, function() {
      /* Stuff to do when the mouse leaves the element */
      jQuery(this).css('opacity', '0');
    });
  },
  goTop: function() {
    var body = jQuery('body');
    var bodyTop = body.scrollTop();
    jQuery('.up').on('click', function(e) {
      e.preventDefault();
      body.animate({
          scrollTop: 0
        },
        '500', 'swing',
        function() {});
    });
  }
}