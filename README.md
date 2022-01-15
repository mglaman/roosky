# Roosky

A wildly different approach to building an application with Drupal

More information on the way.

## Quickstart

```
php roosky env:generate --sqlite
php roosky install
php roosky serve
```

## Configure

* `.env` controls various things and is generated.
* `config/settings.php` is equal to `sites/default/settings.php`
* `config/services/default.yml` is equal to `sites/default/services.yml`

## Develop

This is under work.

`app` is namespaced to `App` and provides an alternative HttpKernel for Drupal.

It registers `App\Provider` to add or alter the service container.

No way to implement hooks / register an extension.
