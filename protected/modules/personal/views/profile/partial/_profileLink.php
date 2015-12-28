<div class="col-md-3">
    <h6><?php echo $header; ?></h6>
    <blockquote>
        <p><?php
            $o = explode("/", $link);
            if (strpos($link, "http://") !== FALSE || strpos($link, "https://") !== FALSE)
                echo '<a href="' . $link . '" target="_blank">' . $o[count($o) - 1] . '</a>';
            else {
                echo $link;
            }
            ?></p>
    </blockquote>
</div>