(function ($) {
  var PlaceField;

  PlaceField = function (field) {
    this.field = $(field);
    this.container = this.field.parents('.field-place');
    this.map_canvas = this.container.find('.field-google-map-ui')[0];
    this.settings = {
      map: {
        center: {
          lat: -34.397,
          lng: 150.644
        },
        zoom: 8
      }
    };

    this.init();
  };

  PlaceField.prototype = {
    init: function () {
      console.log(this, google);
      this.map = new google.maps.Map(this.map_canvas, this.settings.map);
      this.listen();
      console.log(this);
    },
    listen: function () {

    }
  }

  $.fn.mapField = function () {
    var fields = this,
        maps = document.createElement('script'),
        random_callback_key = 'map_init_' + Math.floor(Math.random() * 100000).toString();


    maps.type = 'text/javascript';
    maps.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=' + random_callback_key;
    document.body.appendChild(maps);

    window[random_callback_key] = function () {
      fields.each(function (index, el) {
        var field = $(this);

        if( field.data('map') ) {
          return field.data('map');
        } else {
          var map = new PlaceField(field);
          field.data('map', map);
          return map;
        }
      });
    }

  };
})(jQuery);
