# Place Field

> Please be aware that this field plugin is under development and is not recommended for use in production environments. Breaking changes may be made to the way it saves and restores data.

I've found that adding location data to [Kirby CMS](http://getkirby.com) forms to be super useful.

Unfortunately, this isn't one of the many fields available to us, out of the box.

## Features
- Familiar Google Maps UI
- Discrete storage of location name, latitude and longitude
- Geocoding of place names and addresses
- Repositionable marker (in case search doesn't nail it)
- Support for multiple `place` fields per form
- Support for `place` fields within `structure` fields.
- Easy to implement (See "Getting Started", below)
- Customizable default position and zoom— globally and on a per-field basis

## Getting Started
If you like the command line, adding this to your project is super easy.

Be sure you have a `fields` folder in your `site` folder, then:

```sh
cd /path/to/your/project
git submodule add git@github.com:AugustMiller/kirby-place-field.git site/fields/place
```

It's important that the folder be named `place`, because kirby looks for the field class's definition in a PHP file with the same name as the folder.

You can also directly [download](https://github.com/AugustMiller/kirby-place-field/archive/master.zip) an archive of the current project state, rename the folder to `place`, and add it to the `site/fields` folder of your project.

Once you've added the plugin, you can add a location field to your blueprints, like this:

```yml
fields:
  location:
    label: Location
    type: place
    center:
      lat: 45.5230622
      lng: -122.67648159999999
      zoom: 9
    help: >
      Move the pin wherever you'd like, or search for a location!
```

The `center` key allows you to customize the initial position and zoom level of the map interface.

You can also set global defaults, in your `config.php`:

```php
c::set('place.defaults.lat', 45.5230622);
c::set('place.defaults.lng', -122.67648159999999);
c::set('place.defaults.zoom', 9);
```

These options will be overridden by any set on individual fields. Without either configured, it will default to hard-coded values.

## Accessing Saved Data

The Place Field stores data in JSON.

You can manually cast the field to a string (`(string)$page->location()`), then use PHP's `json_decode()` function to return an associative array.

I've also written a [custom `json` field method](https://gist.github.com/AugustMiller/2c3fe124d272541ff353) to handle decoding in a more automatic fashion. With the field method added to `site/plugins`, you can retrieve pieces of place data like this:

```php
$page->location->json('address');
```

Properties `address`, `lat` and `lng` exist in the decoded JSON object. If no property is passed to the field method, an associative array is returned, with all three elements.
