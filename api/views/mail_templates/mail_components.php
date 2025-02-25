<?php

$components = array();

$components['body'] =
    '
<div style="font-size: 14px; line-height: 25px; color: #666666; text-align: justify;" class="padding-justify">
    %content%
</div>
';

$components['more_details'] =
'
<div style="padding: 0 0 0 10px; font-size: 14px; line-height: 18px; color: #666666; text-align: justify;" class="padding-justify">
    %content%
</div>
';

$components['button'] =
'
<div style="text-align: center; padding: 10px 50px;">
    <a href="%link%" target="_blank" style="font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 25px; padding: 10px 0; border: 1px solid '.BRANDCOLOR_PRIMARY.'; background: '.BRANDCOLOR_PRIMARY.'; display: inline-block; width: 100%;" class="mobile-button">%action%</a>
</div>
';
