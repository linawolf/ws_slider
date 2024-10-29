<?php

call_user_func(
    function ($extKey) {

        /* add backend css */
        $GLOBALS['TBE_STYLES']['skins']['backend']['stylesheetDirectories'][$extKey] = 'EXT:'.$extKey.'/Resources/Public/CSS/Backend/';

    },
    'ws_slider'
);
