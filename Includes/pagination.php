<div class="container text-center">
    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
        <strong>Page <?= $page_no . " of " . $total_pages; ?></strong>
    </div>

    <ul class="pagination justify-content-center">
        <?php
        $page_redir = $redirect;
        if (isset($_GET['modalID'])) {
            $page_redir = preg_replace('/[?&]modalID=[^&]*/', '', $page_redir);
        }
        if (isset($_GET['alert'])) {
            $page_redir = preg_replace('/[?&]alert=[^&]*/', '', $page_redir);
        }
        if (strpos($page_redir, '?') !== false || strpos($page_redir, '&') !== false) {
            if (strpos($page_redir, 'page=') !== false) {
                $page_redir = preg_replace('/(page=)[^&]*/', '${1}', $page_redir);
            } else {
                $page_redir .= "&page=";
            }
        } else {
            $page_redir .= "?page=";
        }
        if ($page_no > 1) {
            echo "<li  class='page-item'><a class='page-link' href='$page_redir" . "1'>First Page</a></li>";
        } ?>

        <li <?php if ($page_no <= 1) {
                echo "class='disabled page-item'";
            } ?>>
            <a class='page-link' <?php if ($page_no > 1) {
                                        echo "href='$page_redir" . "$prev_page'";
                                    } ?>>Previous</a>
        </li>

        <?php
        if ($total_pages <= 10) {
            for ($counter = 1; $counter <= $total_pages; $counter++) {
                if ($counter == $page_no) {
                    echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";
                } else {
                    echo "<li  class='page-item'><a class='page-link' href='$page_redir" . "$counter'>$counter</a></li>";
                }
            }
        } elseif ($total_pages > 10) {
            if ($page_no <= 4) {
                for ($counter = 1; $counter < 8; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$counter'>$counter</a></li>";
                    }
                }
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$second_last'>$second_last</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$total_pages'>$total_pages</a></li>";
            } elseif ($page_no > 4 && $page_no < $total_pages - 4) {
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "1'>1</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "2'>2</a></li>";
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                for (
                    $counter = $page_no - $adjacents;
                    $counter <= $page_no + $adjacents;
                    $counter++
                ) {
                    if ($counter == $page_no) {
                        echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$counter'>$counter</a></li>";
                    }
                }
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$second_last'>$second_last</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$total_pages'>$total_pages</a></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "1'>1</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$page_redir" . "2'>2</a></li>";
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                for (
                    $counter = $total_pages - 6;
                    $counter <= $total_pages;
                    $counter++
                ) {
                    if ($counter == $page_no) {
                        echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$counter'>$counter</a></li>";
                    }
                }
            }
        }
        ?>

        <li <?php if ($page_no >= $total_pages) {
                echo "class='disabled page-item'";
            } ?>>
            <a class='page-link' <?php if ($page_no < $total_pages) {
                                        echo "href='$page_redir" . "$next_page'";
                                    } ?>>Next</a>
        </li>

        <?php if ($page_no < $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='$page_redir" . "$total_pages'>Last &rsaquo;&rsaquo;</a></li>";
        } ?>
    </ul>
</div>