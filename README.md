carew-plugin-fastnav
====================

### TagList plugin

#### Summary
This is a simple [carew](http://carew.github.io) plugin that allow you to create a list of all the tags you used on your carew website.

An example can be seen on the right side of my blog below the tweet feed :)

#### How to install it

A package is available on packagist in order to make it very simple for you to install.

All you have to do is to edit your `composer.json` file to add this requirement:

    "bacardi55/carew-plugin-taglist": "1.*dev"

Then, `php composer.php update` or `php composer.php install` depending on your case.

#### How to use it

Edit the carew config.yml file to enable the extension:

    engine:
        […]
        extensions:
            …
            - Carew\Plugin\BlogRoll\TagListExtension
            …


Then, in your [twig](http://twig.sensiolabs.org) template file(s), you have access to a `tagList` variable which is an array of tag. Each entry of this array contains an array representing a tag. You have access to its name, its path and the number of post that reference that tag.

Here is an example of how I use it on my own blog:

    twig
    {% for label in tagList %}
      <a class="pull-left" href="/{{ label.path }}">{{ label.name | e('html') }} ({{ label.nbPosts | e('html') }})</a>
    {% endfor %}

#### Source code

You can find the code on github [here](https://github.com/bacardi55/carew-plugin-taglist).

The package can be found [here](https://packagist.org/packages/bacardi55/carew-plugin-taglist) on packagist.
