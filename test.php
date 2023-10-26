<div class="col-sm-3 col-md-4 col-lg-2 m-0 p-0">

    <nav class="navbar navbar-expand-sm bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span><span style="position:relative; top:2px;">Filter</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <form action="" method="GET">
                    <div class="text-center ms-4 mt-3 ">
                        <b class="fs-3">Categories</b>
                        <hr>
                        <div class="text-start">

                            <?php
                            $categoriesData = $classified->getCategories();
                            $result = $categoriesData['result'];
                            $selectedCategories = $categoriesData['selectedCategories'];

                            if (mysqli_num_rows($result) > 0) :
                                while ($categories = $result->fetch_assoc()) {
                                    $categoryName = $categories["Category"];
                                    $isChecked = in_array($categoryName, $selectedCategories) ? 'checked' : '';
                            ?>
                                    <div class="checkbox-wrapper-4 ms-1" id="CateText">
                                        <input class="inp-cbx" id="<?= $categoryName ?>" type="checkbox" name="category[]" value="<?= $categoryName ?>" <?= $isChecked ?> />
                                        <label class="cbx" for="<?= $categoryName ?>"><span>
                                                <svg width="12px" height="10px">
                                                    <use xlink:href="#check-4"></use>
                                                </svg></span><span><?= $categoryName ?></span></label>
                                        <svg class="inline-svg">
                                            <symbol id="check-4" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </symbol>
                                        </svg>
                                    </div>
                            <?php
                                }
                            endif;
                            ?>

                        </div>


                        <b class="fs-3">Status</b>
                        <hr>
                        <div class="text-start">

                            <?php
                            $statusData = $classified->getStatus();
                            $result = $statusData['result'];
                            $selectedStatus = $statusData['selectedStatus'];

                            if (mysqli_num_rows($result) > 0) :
                                while ($stat = $result->fetch_assoc()) {
                                    $statusName = $stat["AdStatus"];
                                    $isChecked = in_array($statusName, $selectedStatus) ? 'checked' : '';
                            ?>
                                    <div class="checkbox-wrapper-4 ms-1" id="CateText">
                                        <input class="inp-cbx" id="<?= $statusName ?>" type="checkbox" name="status[]" value="<?= $statusName ?>" <?= $isChecked ?> />
                                        <label class="cbx" for="<?= $statusName ?>"><span>
                                                <svg width="12px" height="10px">
                                                    <use xlink:href="#check-4"></use>
                                                </svg></span><span><?= $statusName ?></span></label>
                                        <svg class="inline-svg">
                                            <symbol id="check-4" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </symbol>
                                        </svg>
                                    </div>
                            <?php
                                }
                            endif;
                            ?>

                        </div>


                        <input type="hidden" name="search" value="<?= $key ?>">
                        <input type="submit" class="button-31 mt-5 mb-5" value="Search">

                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>