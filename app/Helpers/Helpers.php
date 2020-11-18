<?php


function generate_sidebar_groups($array, $output)
{

    foreach ($array as $item => $val) {
        if (is_array($val)) {
            $output .= '<a href="javascript:;" class="nav-link nav-toggle">';
            $output .= ' <li class="nav-item">';
            $output .= '<i class="icon-briefcase"></i><span class="title">' . $item . '</span><span class="arrow"></span>';
            $output .= '</a>';
            $output .= '<ul class="sub-menu">';
            $output = generate_sidebar_groups($val, $output);
            $output .= '</ul>';
            $output .= '</li>';
        } else {
            $output .= '<li class="nav-item  "><a href="' . $val . '" class="nav-link"><span class="title">' . $item . '</span></a></li>';

        }
    }

    return $output;
}
