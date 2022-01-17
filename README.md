# Roosky

A wildly different approach to building an application with Drupal

More information on the way.

## Quickstart

```
php vendor/bin/drush env:generate --sqlite
php vendor/bin/drush site:install
cd web && php -S 127.0.0.1:8080 .ht.router.php
```

Note, the above doesn't use `drush serve` is broken on PHP 8. The `--default-server`
option defaults to `null` but passes `null` to a function which requires a `string`.

It's also not having the `bootstrap.php` file to be autoloaded, somehow.

## Configure

This part isn't very controversial, but it'd be nice if we could support it out
of the box like most frameworks.

* `.env` controls various things and is generated.
* `sites/default/settings.php` reads the environment variables

## Develop

This is under work.

`app` is namespaced to `App` and provides an alternative HttpKernel for Drupal.

It registers `App\Provider`, if the class exists, to add or alter the service container.

No way to

* implement hooks
* register an extension (module)
