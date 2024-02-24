# wlib/i18n

Internationalisez le contenu de vos applications avec Gettext.

Cette libraire est une encapsulation de la librairie [pomo/pomo](https://packagist.org/packages/pomo/pomo) notamment utilisée au sein de WordPress.

Les fonctions de traductions popularisées par WordPress suivantes sont disponibles :

```php
__();	// traduction simple
_n();	// traduction singulier/pluriel
_x();	// traduction simple avec contexte
_nx();	// traduction singulier/pluriel avec contexte
_s();	// traduction simple + sprintf
_ns()	// traduction singulier/pluriel + sprintf
```