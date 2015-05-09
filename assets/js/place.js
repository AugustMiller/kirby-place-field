(function ($) {
  var MapManager, PlaceField;

  window.Fields = window.Fields || {};

  MapManager = function () {
    // Storage
    this.js = 'https://maps.googleapis.com/maps/api/js?v=3.exp' + '&callback=Fields.MapManager.end_load';
    this.script = document.createElement('script');
    this.script.src = this.js;
    this.script.type = 'text/javascript';

    // Collections & Properties
    this.maps = [];
    this.is_loaded = false;
    this.is_loading = false;

    // Methods
    this.load = function () {
      if (this.should_load()) {
        this.is_loading = true;
        document.body.appendChild(this.script);
      }
    };

    this.should_load = function () {
      return !this.is_loaded && !this.is_loading;
    };

    this.add = function (input) {
      this.maps.push(new window.Fields.Place(input));
    };

    this.end_load = function () {
      this.is_loaded = true;
      this.refresh();
    }

    this.refresh = function () {
      if ( this.is_loaded ) {
        for (var m = 0; m < this.maps.length; m++) {
          this.maps[m].init();
        };
      }
    };
  };

  window.Fields.MapManager = window.Fields.MapManager || new MapManager();

  Place = function (field) {
    this.is_active = false;
    this.field = $(field);
    this.container = this.field.parents('.field-place');
    this.map_canvas = this.container.find('.field-google-map-ui');
    this.settings = {
      map: {
        center: {
          lat: parseFloat(this.map_canvas.data('lat')),
          lng: parseFloat(this.map_canvas.data('lng'))
        },
        zoom: 6
      }
    };
  };

  Place.prototype = {
    init: function () {
      if ( !this.is_active ) {
        this.map = new google.maps.Map(this.map_canvas.get(0), this.settings.map);
        this.listen();
        console.log(this);
      }
      this.is_active = true;
    },
    listen: function () {

    }
  }

  window.Fields.Place = window.Fields.Place || Place;

  $.fn.mapField = function () {

    window.Fields.MapManager.load();

    for ( var f = 0; f < this.length; f++ ) {
      window.Fields.MapManager.add(this[f]);
    }

    window.Fields.MapManager.refresh();

    /*
    if ( $(document.body).hasClass('google-maps-loaded') ) {
      this.each(function (index, el) {
        var field = $(this);

        if( field.data('map') ) {
          return field.data('map');
        } else {
          var map = new window.Fields.Place(field);
          field.data('map', map);
          return map;
        }
      });
    }
    */
  };

})(jQuery);
