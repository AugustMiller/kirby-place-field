<?php class PlaceField extends TextField {
  public function __construct() {
    $this->type = 'place';
    $this->icon = 'map-marker';
    $this->label = l::get('fields.place.label', 'Place');
    $this->placeholder = l::get('fields.place.placeholder', 'Address or Location');
    $this->default_location = array_merge(array(
      'lat' => 43.9,
      'lng' => -120.2291901,
      'zoom' => 1
    ), (array)$this->center);
  }

  static public $assets = array(
    'js' => array(
      'place.js'
    ),
    'css' => array(
      'place.css'
    )
  );

  public function content () {
    $field = new Brick('div');
    $field->addClass('field-multipart field-place');

    # Add each
    $field->append($this->input_location());
    $field->append($this->button_search());
    $field->append($this->map());
    $field->append($this->input_lat());
    $field->append($this->input_lng());
    $field->append($this->input_serialized());

    # Concatenate & Return
    return $field;
  }

  public function input () {
    # Use `BaseField`'s setup
    $input = parent::input();

    # Provide a hook for the Panel's form initialization. This is a jQuery method, defined in assets/js/place.js
    $input->data('field', 'mapField');
    return $input;
  }

  # Location Input & Search
  private function input_location () {
    # Container
    $location_container = new Brick('div');
    $location_container->addClass('field-content input-place');

    # Field
    $location_input = new Brick('input');
    $location_input->addClass('input input-address');
    $location_input->attr('placeholder', $this->placeholder);
    $location_input->val($this->value()->address);

    # Combine & Ship It
    $location_container->append($location_input);
    $location_container->append($this->icon());

    return $location_container;
  }

  # Search Button
  private function button_search () {
    # Wrapper
    $search_container = new Brick('div');
    $search_container->addClass('field-content input-search input-button');

    # Button
    $search_button = new Brick('input');
    $search_button->attr('type', 'button');
    $search_button->val(l::get('fields.place.locate', 'Locate'));
    $search_button->addClass('btn btn-rounded locate-button');

    # Combine & Ship It
    $search_container->append($search_button);

    return $search_container;
  }

  # Latitude Input
  private function input_lat () {
    # Wrapper
    $lat_content = new Brick('div');
    $lat_content->addClass('field-content field-lat');

    # Input (Locked: We use the map UI to update these)
    $lat_input = new Brick('input');
    $lat_input->attr('tabindex', '-1');
    $lat_input->attr('readonly', true);
    $lat_input->addClass('input input-split-left input-is-readonly place-lat');
    $lat_input->attr('placeholder', l::get('fields.place.placeholder', 'Latitude'));
    $lat_input->val($this->value()->lat);

    # Combine & Ship It
    $lat_content->append($lat_input);
    
    return $lat_content;
  }

  # Longitude Input
  private function input_lng () {
    # Wrapper
    $lng_content = new Brick('div');
    $lng_content->addClass('field-content field-lng');

    # Input (Locked: We use the map UI to update these)
    $lng_input = new Brick('input');
    $lng_input->attr('tabindex', '-1');
    $lng_input->attr('readonly', true);
    $lng_input->addClass('input input-split-right input-is-readonly place-lng');
    $lng_input->attr('placeholder', l::get('fields.place.placeholder', 'Longitude'));
    $lng_input->val($this->value()->lng);

    # Combine & Ship It
    $lng_content->append($lng_input);

    return $lng_content;
  }

  # Map
  public function map () {
    # Wrapper
    $map_content = new Brick('div');
    $map_content->addClass('field-content field-google-map-ui');
    $map_content->data($this->default_location);

    return $map_content;
  }


  # Serialized Input
  private function input_serialized () {
    # Wrapper
    $serialized_content = new Brick('div');
    $serialized_content->addClass('field-hidden field-serialized');

    # Field (Hidden: Users shouldn't be able to manipulate the JSON we'll store in here)
    $serialized_input = $this->input();
    $serialized_input->attr('type', 'hidden');

    # Combine & Ship It
    $serialized_content->append($serialized_input);

    return $serialized_content;
  }


  public function value() {
    # Convert JSON String to Array
    return json_decode($this->value);
  }

  public function result() {
    # Get Incoming Data, decode and re-encode.
    # This format may change, so this method will allow us to shim in more config options for storage, later. (YAML?)
    $result = parent::result();
    $data = json_decode($result);
    return json_encode($data);
  }
}
