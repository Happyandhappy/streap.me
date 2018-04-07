<?php
return [
    'wrapper' => '<nav aria-label="breadcrumb"><ol class="breadcrumb"{{attrs}}>{{content}}</ol></nav>',
    'item' => '<li class="breadcrumb-item"{{attrs}}><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>',
    'itemWithoutLink' => '<li class="breadcrumb-item active" aria-current="page"{{attrs}}><span{{innerAttrs}}>{{title}}</span></li>',
]
?>