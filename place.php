<?php class PlaceField extends TextField {
  public function __construct() {
    $this->type = 'text';
    $this->icon = 'map-marker';
    $this->label = l::get('fields.place.label', 'Place');
    $this->placeholder = l::get('fields.place.placeholder', 'Address or Location');
    $this->js_api = 'https://maps.googleapis.com/maps/api/js';
    $this->default_location = array(
      'lat' => 0,
      'lng' => 0
    );
  }

  static public $assets = array(
    'js' => array(
      'place.js',
      'https://maps.googleapis.com/maps/api/js'
    ),
    'css' => array(
      'place.css'
    )
  );

  public function input () {
    $input = parent::input();
    $input->data('field', 'mapField');
    $input->attr('name', 'location[address]');
    return $input;
  }

  public function content () {
    $field = new Brick('div');
    $field->addClass('field-multipart field-place');

    $field->append($this->input_location());
    $field->append($this->button_search());
    $field->append($this->map());
    $field->append($this->input_lat());
    $field->append($this->input_lng());
    // $field->append(js($this->js_api));

    # Concatenate & Return
    return $field;
  }

  # Location Input & Search
  private function input_location () {
    $location_container = new Brick('div');
    $location_container->addClass('field-content input-place');

    $location_input = $this->input();

    $location_container->append($location_input);
    $location_container->append($this->icon());

    return $location_container;
  }

  # Search Button
  private function button_search () {
    $search_container = new Brick('div');
    $search_container->addClass('field-content input-search input-button');

    $search_button = new Brick('input');
    $search_button->attr('type', 'button');
    $search_button->attr('value', l::get('fields.place.locate', 'Locate'));
    $search_button->addClass('btn btn-rounded locate-button');

    $search_container->append($search_button);

    return $search_container;
  }

  # Latitude Input
  private function input_lat () {
    $lat_content = new Brick('div');
    $lat_content->addClass('field-content field-lat');

    $lat_input = new Brick('input');
    $lat_input->addClass('place-lat');
    $lat_input->attr('tabindex', '-1');
    $lat_input->attr('readonly', true);
    $lat_input->attr('name', 'location[lat]');
    $lat_input->addClass('input input-split-left input-is-readonly');

    $lat_content->append($lat_input);
    
    return $lat_input;
  }

  # Longitude Input
  private function input_lng () {
    $lng_content = new Brick('div');
    $lng_content->addClass('field-content field-lng');

    $lng_input = new Brick('input');
    $lng_input->addClass('place-lng');
    $lng_input->attr('tabindex', '-1');
    $lng_input->attr('readonly', true);
    $lng_input->attr('name', 'location[lng]');
    $lng_input->addClass('input input-split-right input-is-readonly');

    $lng_content->append($lng_input);

    return $lng_content;
  }

  # Map
  public function map () {
    $map_content = new Brick('div');
    $map_content->addClass('field-content field-google-map-ui');
    $map_content->data($this->default_location);

    return $map_content;
  }


  # Serialized Input
  private function input_serialized () {
    $serialized_content = new Brick('div');
    $serialized_content->addClass('field-hidden field-serialized');

    $serialized_input = new Brick('input');
    $serialized_input->attr('name', $this->name);
    $serialized_input->attr('type', 'hidden');

    $serialized_content->append($serialized_input);

    return $serialized_content;
  }


  public function value() {
    if(is_string($this->value)) {
      $this->value = yaml::decode($this->value);
    }

    return $this->value;
  }

  public function result() {
    $result = parent::result();
    $data = (array)json_decode($result);
    return yaml::encode($data);
  }
}
