<?php

$websites = page('websites')->children()->visible();

// if($sitetype = param('sitetype')) {
//   $websites = $websites->filterBy('sitetype', $sitetype, ',');
// }

if(param('sitetype')){
    $sitetypes = explode(",", param('sitetype'));
    $websites = $websites->filter(function($website) use ($sitetypes) {
      $inTags = true;
      foreach ($sitetypes as $sitetype) {
        $pTags = explode(",", $website->sitetype()); //get tags field from page
        if(!in_array($sitetype,$pTags)){
          $inTags = false;
        }
      }
      return $inTags;
    });
  }

/*

The $limit parameter can be passed to this snippet to
display only a specified amount of websites:

```
<?php snippet('showcase', ['limit' => 3]) ?>
```

Learn more about snippets and parameters at:
https://getkirby.com/docs/templates/snippets

*/

if(isset($limit)) $websites = $websites->limit($limit);

?>

<ul class="showcase grid gutter-1">

  <?php foreach($websites as $website): ?>

    <li class="showcase-item column">
        <a href="<?= $website->url() ?>" class="showcase-link">
          <?php if($image = $website->images()->sortBy('sort', 'asc')->first()): $thumb = $image->crop(600, 600); ?>
            <img src="<?= $thumb->url() ?>" alt="Thumbnail for <?= $website->title()->html() ?>" class="showcase-image" />
          <?php endif ?>
          <div class="showcase-caption">
            <h3 class="showcase-title"><?= $website->title()->html() ?></h3>
          </div>
        </a>
    </li>

  <?php endforeach ?>

</ul>