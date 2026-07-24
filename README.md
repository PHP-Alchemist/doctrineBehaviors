# DoctrineBehaviorsBundle  

-------
[![StyleCI](https://github.styleci.io/repos/913580276/shield?branch=master)](https://github.styleci.io/repos/913580276?branch=master)
-------
A simplified doctrine extension  to add common behaviors

Yet another fun-filled doctrine-behaviors-bundle. It isn't designed to be the 
end-all-be-all of DoctrineBehaviorsBundles, it's just the way we prefer it and
the way that we use it.  If this works for you great! We're excited you picked 
ours. If not, no hurt feelings.


## Installation 

Prior to adding the DoctrineBehaviorsBundle, you will need to add the PHPAlchemist symfony recipes repo to your configuration.
To do so, add the following to your `composer.json` file:

```json
{
 //...
"extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/PHP-Alchemist/symfony-recipes/contents/index.json",
        "flex://defaults"
      ]
    }
  }
}
  ```

Next you can require the bundle:
```shell
composer require php-alchemist/doctrine-behaviors
```

## Configuration

In your `config/packages` folder you should now find a `php_alchemist_doctrine_behaviors.yaml` file. The contents 
should resemble:

```yaml
php_alchemist_doctrine_behaviors:
  decision_service: ~
```

If you have a custom decision service in which your Behaviors will look to decide if they should be executed, here is 
where you will configure that.
The `decision_service` option should be filled in with class. 
Such as:

```yaml
php_alchemist_doctrine_behaviors:
  decision_service: App\Service\DoctrineBehaviorDecisionService
```
This class will replace the default one provided by the bundle.

### Turning behaviors off

Every behavior is on by default. If you only want some of them, switch the rest
off under `behaviors`:

```yaml
php_alchemist_doctrine_behaviors:
  behaviors:
    liable: true
    timestampable: true
    soft_deleteable: false
```

A behavior switched off here is removed from the container entirely — no
service, no Doctrine event listener, and no `decide()` call on flush. That makes
it cheaper than a decision service that returns `false`, which still pays the
lookup on every event.

The two options layer, and it is fine to use both:

| | Question it answers | When it runs |
| --- | --- | --- |
| `behaviors` | Should this listener exist at all? | Compile time |
| `decision_service` | Should it act on *this* flush? | Runtime, per event |
| Entity interface | Does this entity opt in? | Runtime, per entity |

So `behaviors` is the right place for a behavior you never want, and
`decision_service` is the right place for one you want to toggle at runtime —
from a feature flag, an environment, or a per-tenant setting.

The bundle's own `DecisionService` honors `behaviors` too, so the config works
without writing any class. If you supply your own `decision_service`, that class
owns the decision completely and is not handed the `behaviors` map — but
anything switched off under `behaviors` is already gone from the container, so
your class is never asked about it.
