# CMB2 Field Type: Select2 Posts

## Desc
Enable to select post by Select2

##Install
You can install select2 posts field as a Wordpress plugin

1. Download plugin
2. Place in `wp-content/plugins` directory
3. Active in Wordpress plugin section

## Use
`own_select2_posts` as a field type.

```php
array(
  'name'        => 'Select',
  'placeholder' => 'Set your value',
  'id'          => $prefix . 'select2_posts',
  'type'        => 'own_select2_posts',
  'post_type'   => 'post',
  'width'       => '300px',
)
```

## Screenshots

![Image](screen-1.jpg?raw=true)

## To-Do

* Add support for repeatable group.
* Add multiple selections.
* Add multiple post types.
