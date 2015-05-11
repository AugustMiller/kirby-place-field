# Place Field

> Please be aware that this field plugin is under development and is not recommended for use in production environments. Breaking changes are expected to be made to the way it saves and restores data.

I've found that adding location data to [http://getkirby.com](Kirby CMS) forms to be super useful.

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
git clone git@github.com:AugustMiller/kirby-place-field.git site/fields/place
```

It's important that the folder be named `place`, because kirby looks for the field class's definition in a PHP file with the same name as the folder.

You can also directly [https://github.com/AugustMiller/kirby-place-field/archive/master.zip](download) an archive of the current project state, rename the folder to `place`, and add it to the `site/fields` folder of your project.
