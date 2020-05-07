<?php
require_once 'Template/top.php';
$_SESSION[SESSION_STRING_REGISTER_ERROR] = "";
$_SESSION[SESSION_STRING_REGISTER_ERROR_2] = "";
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
$discount = new DiscountDataSource();
$discount->open();
$price = new PriceDataSource();
$price->open();
?>
    <title>مقایسه کالا</title>
    <meta name="description" content="لیست مقایسه">
    <meta name="keywords" content="مقایسه کالا,مقایسه,مقایسه کالا ها,Compare">
    <script language="javascript">
        $(document).ready(
            function () {
                $("#pikame").PikaChoose({carousel: true, carouselOptions: {wrap: 'circular'}});
            });
    </script>
    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $(document).ready(function () {
            $('.compare-search').on('input', function () {
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/CompareSearch.php',
                        data: {
                            string: $('.compare-search').val()
                        },
                        success: function (data) {
                            $('.searches').html(data);
                        }

                    });
                }, 500);
            });
            $('.compare-search2').on('input', function () {
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/CompareSearch.php',
                        data: {
                            string: $('.compare-search2').val()
                        },
                        success: function (data) {
                            $('.searches2').html(data);
                        }

                    });
                }, 500);
            });
            $('.compare-search3').on('input', function () {
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/CompareSearch.php',
                        data: {
                            string: $('.compare-search3').val()
                        },
                        success: function (data) {
                            $('.searches3').html(data);
                        }

                    });
                }, 500);
            });
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("#gallery").unitegallery({
                thumb_width: 100,
                thumb_height: 70,
                slider_scale_mode: "fit",
                strippanel_background_color: "#F5F6F7",
                gallery_skin: "alexis",
                slider_loader_color: "black",
                slider_play_button_offset_vert: 9,
                slider_play_button_offset_hor: 50,
                slider_progress_indicator_offset_hor: 90,
                slider_progress_indicator_offset_vert: 12,
            });
        });
    </script>

<!--    <script type='text/javascript' src='Template/unitegallery/js/jquery-11.0.min.js'></script>-->
    <script type='text/javascript' src='Template/unitegallery/js/unitegallery.min.js'></script>
    <link href="Template/unitegallery/skins/alexis/alexis.css" rel="stylesheet" type="text/css"/>
    <link rel='stylesheet' href='Template/unitegallery/css/unite-gallery.css' type='text/css'/>

    <script type='text/javascript' src='Template/unitegallery/themes/compact/ug-theme-compact.js'></script>

    <!--<script src="Template/Scripts/jquery-1.9.1.min.js" type="text/javascript"></script>-->
    <!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->
<?php include_once 'Template/menu.php'; ?>

    <div class="container">
        <div class="main-container">
            <div class="compare-view">
                <!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->
                <?php
                if (isset($_GET['id']) == TRUE) {
                    if ((!isset($_SESSION[SESSION_INT_PRODUCT_1]) || $_SESSION[SESSION_INT_PRODUCT_1] == 0) && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != $_GET['id']) {
                        $_SESSION[SESSION_INT_PRODUCT_1] = $_GET['id'];
                    } elseif ((!isset($_SESSION[SESSION_INT_PRODUCT_2]) || $_SESSION[SESSION_INT_PRODUCT_2] == 0) && isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != $_GET['id']) {
                        $_SESSION[SESSION_INT_PRODUCT_2] = $_GET['id'];
                    } elseif ((!isset($_SESSION[SESSION_INT_PRODUCT_3]) || $_SESSION[SESSION_INT_PRODUCT_3] == 0) && isset($_SESSION[SESSION_INT_PRODUCT_2]) && isset($_SESSION[SESSION_INT_PRODUCT_1]) && $_SESSION[SESSION_INT_PRODUCT_2] != $_GET['id'] && $_SESSION[SESSION_INT_PRODUCT_1] != $_GET['id']) {
                        $_SESSION[SESSION_INT_PRODUCT_3] = $_GET['id'];
                    }
                }
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductPropertyDataSource.inc';
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductAndPropertyDataSource.inc';

                $productProperty = new ProductPropertyDataSource();
                $productProperty->open();
                $productProperties = $productProperty->Fill();
                $productProperty->close();

                if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                    $productAndProperty4 = new ProductAndPropertyDataSource();
                    $productAndProperty4->open();
                    $productAndProperties4 = $productAndProperty4->getSameProperties2($_SESSION[SESSION_INT_PRODUCT_1], $_SESSION[SESSION_INT_PRODUCT_2], $_SESSION[SESSION_INT_PRODUCT_3]);
                    $productAndProperty4->close();

                    $productAndProperty5 = new ProductAndPropertyDataSource();
                    $productAndProperty5->open();
                    $productAndProperties5 = $productAndProperty5->getSameProperties2($_SESSION[SESSION_INT_PRODUCT_2], $_SESSION[SESSION_INT_PRODUCT_1], $_SESSION[SESSION_INT_PRODUCT_3]);
                    $productAndProperties8 = $productAndProperty5->getSameProperties2($_SESSION[SESSION_INT_PRODUCT_3], $_SESSION[SESSION_INT_PRODUCT_2], $_SESSION[SESSION_INT_PRODUCT_1]);
                    $productAndProperty5->close();

                } elseif (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                    $productAndProperty4 = new ProductAndPropertyDataSource();
                    $productAndProperty4->open();
                    $productAndProperties4 = $productAndProperty4->getSameProperties($_SESSION[SESSION_INT_PRODUCT_1], $_SESSION[SESSION_INT_PRODUCT_2]);
                    $productAndProperty4->close();

                    $productAndProperty5 = new ProductAndPropertyDataSource();
                    $productAndProperty5->open();
                    $productAndProperties5 = $productAndProperty5->getSameProperties($_SESSION[SESSION_INT_PRODUCT_2], $_SESSION[SESSION_INT_PRODUCT_1]);
                    $productAndProperty5->close();
                }
                if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                    $product = new ProductDataSource();
                    $product->open();
//            $product->ProductId = $_SESSION[SESSION_INT_PRODUCT_1];
                    $product1 = $product->FindOneProductBasedOnId($_SESSION[SESSION_INT_PRODUCT_1]);

                    $productAndProperty = new ProductAndPropertyDataSource();
                    $productAndProperty->open();
                    $productAndProperties = $product->GetProperties($_SESSION[SESSION_INT_PRODUCT_1]);
                    $productAndProperty->close();
                    $product->close();
                }
                if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                    $pproduct = new ProductDataSource();
                    $pproduct->open();
//            $pproduct->ProductId = $_SESSION[SESSION_INT_PRODUCT_2];
                    $product2 = $pproduct->FindOneProductBasedOnId($_SESSION[SESSION_INT_PRODUCT_2]);

                    $productAndProperty2 = new ProductAndPropertyDataSource();
                    $productAndProperty2->open();
                    $productAndProperties2 = $pproduct->GetProperties($_SESSION[SESSION_INT_PRODUCT_2]);
                    $productAndProperty2->close();
                    $pproduct->close();
                }
                if (isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                    $pproduct3 = new ProductDataSource();
                    $pproduct3->open();
//            $pproduct3->ProductId = $_SESSION[SESSION_INT_PRODUCT_3];
                    $product3 = $pproduct3->FindOneProductBasedOnId($_SESSION[SESSION_INT_PRODUCT_3]);

                    $productAndProperty3 = new ProductAndProperty();
                    $productAndProperties3 = $pproduct3->GetProperties($_SESSION[SESSION_INT_PRODUCT_3]);

                    $pproduct3->close();
                }
                ?>

                <div class="col-md-12">
                    <div class="specification2">
                        <table>
                            <tr>
                                <td class="btn-td">
                                    <a href="UpdateCompare.php">پاک کردن لیست</a>
                                    <?php
                                    if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                        echo '<div>';
                                        echo "<span class='warn'>توجه : </span><span>اگر می خواهید محصول دیگری را مقایسه کنید ، لیست را پاک کنید  ";
                                        echo "یا یکی از محصولات را حذف کنید.</span>";
                                        echo '</div>';
                                    }
                                    ?>
                                </td>
                                <td class="product-td">
                                    <?php
                                    if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                                        ?>
                                        <a class="btn-delete"
                                           href="UpdateCompare.php?id=<?php echo $product1->ProductId; ?>">حذف
                                            این محصول</a>
                                        <?php
                                    }
                                    ?>
                                    <div class="back-td">
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                                            ?>
                                            <a href="Post.php?id=<?php echo $product1->ProductId; ?>"><img
                                                        src="<?php echo $product1->Image; ?>"/></a>
                                            <?php
                                        } else {
                                            ?>
                                            <input class="compare-search" placeholder="جستجو بین کالا ها..."/>
                                            <div class="searches">

                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <br/>
                                        <span class="name">
                            <?php
                            if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                                echo $product1->Name;
                            }
                            ?>
                        </span>
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                                            ?>
                                            <span class="price">
                            <?php
                            echo number_format(($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_1]) - ($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_1]) * $discount->GetLastDiscountForOneProduct($_SESSION[SESSION_INT_PRODUCT_1]) / 100)) * $tax) . " تومان";
                            ?>
                        </span>
                                            <?php
                                        }
                                        ?>
                                        <!--                        <span class="latin-name">-->
                                        <!--                            --><?php
                                        //                            if (isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                                        //                                echo $product1->LatinName;
                                        //                            } else {
                                        //                                echo '...';
                                        //                            }
                                        //                            ?>
                                        <!--                        </span>-->
                                    </div>
                                </td>
                                <td class="product-td">
                                    <?php
                                    if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                        ?>
                                        <a class="btn-delete"
                                           href="UpdateCompare.php?id=<?php echo $product2->ProductId; ?>">حذف
                                            این محصول</a>
                                        <?php
                                    }
                                    ?>
                                    <div class="back-td">
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                            ?>
                                            <a href="Post.php?id=<?php echo $product2->ProductId; ?>"><img
                                                        src="<?php echo $product2->Image; ?>"/></a>
                                            <?php
                                        } else {
                                            ?>
                                            <input class="compare-search2" placeholder="جستجو بین کالا ها..."/>
                                            <div class="searches2">

                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <br/>
                                        <span class="name">
                            <?php
                            if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                echo $product2->Name;
                            }
                            ?>

                        </span>
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                            ?>
                                            <span class="price">
                            <?php
                            echo number_format(($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_2]) - ($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_2]) * $discount->GetLastDiscountForOneProduct($_SESSION[SESSION_INT_PRODUCT_2]) / 100)) * $tax) . " تومان";
                            ?>
                        </span>
                                            <?php
                                        }
                                        ?>
                                        <!--                        <span class="latin-name">-->
                                        <!--                            --><?php
                                        //                            if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                        //                                echo $product2->LatinName;
                                        //                            } else {
                                        //                                echo '...';
                                        //                            }
                                        //                            ?>
                                        <!--                        </span>                   -->
                                    </div>
                                </td>
                                <td class="product-td">
                                    <?php
                                    if (isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                        ?>
                                        <a class="btn-delete"
                                           href="UpdateCompare.php?id=<?php echo $product3->ProductId; ?>">حذف
                                            این محصول</a>
                                        <?php
                                    }
                                    ?>
                                    <div class="back-td">
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                            ?>
                                            <a href="Post.php?id=<?php echo $product3->ProductId; ?>"><img
                                                        src="<?php echo $product3->Image; ?>"/></a>
                                            <?php
                                        } else {
                                            ?>
                                            <input class="compare-search3" placeholder="جستجو بین کالا ها..."/>
                                            <div class="searches3">

                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <br/>
                                        <span class="name">
                            <?php
                            if (isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                echo $product3->Name;
                            }
                            ?>
                        </span>
                                        <?php
                                        if (isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                            ?>
                                            <span class="price">
                            <?php
                            echo number_format(($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_3]) - ($price->GetLastPriceForOneProduct($_SESSION[SESSION_INT_PRODUCT_3]) * $discount->GetLastDiscountForOneProduct($_SESSION[SESSION_INT_PRODUCT_3]) / 100)) * $tax) . " تومان";
                            ?>
                        </span>
                                            <?php
                                        }
                                        ?>
                                        <!--                        <span class="latin-name">-->
                                        <!--                            --><?php
                                        //                            if (isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                        //                                echo $product2->LatinName;
                                        //                            } else {
                                        //                                echo '...';
                                        //                            }
                                        //                            ?>
                                        <!--                        </span>                   -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="titles">
                                        <?php
                                        if (isset($productAndProperties4) == TRUE) {
                                            foreach ($productAndProperties4 as $ppp) {
                                                echo '<li>';
                                                echo $ppp->ProductProperty->Name;
                                                echo '</li>';
                                            }
                                        } else if (isset($productAndProperties) == TRUE) {
                                            foreach ($productAndProperties as $pp) {
                                                echo '<li>';
                                                echo $pp->ProductProperty->Name;
                                                echo '</li>';
                                            }
                                        } else if (isset($productAndProperties2) == TRUE) {
                                            foreach ($productAndProperties2 as $pp) {
                                                echo '<li>';
                                                echo $pp->ProductProperty->Name;
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="values">
                                        <?php
                                        if (isset($productAndProperties4) == TRUE && isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                            foreach ($productAndProperties4 as $pp2) {
                                                echo '<li class="';
                                                if (trim($pp2->Value) == "دارد") {
                                                    echo "green-back";
                                                } elseif (trim($pp2->Value) == "ندارد") {
                                                    echo "red-back";
                                                }
                                                echo '">';
                                                if (trim($pp2->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12 "/>';
                                                } elseif (trim($pp2->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width ="12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp2->Value;
                                                }

                                                echo '</li>';
                                            }
                                        } else if (isset($productAndProperties) == TRUE) {
                                            foreach ($productAndProperties as $pp3) {
                                                echo '<li class="';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo " green-back ";
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo " red-back ";
                                                }
                                                echo '">';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12" />';
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width= "12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp3->Value;
                                                }
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="values">
                                        <?php
                                        if (isset($productAndProperties5) == TRUE && isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                                            foreach ($productAndProperties5 as $pp3) {
                                                echo '<li class="';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo " green-back ";
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo " red-back ";
                                                }
                                                echo '">';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12" />';
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width= "12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp3->Value;
                                                }
                                                echo '</li>';
                                            }
                                        } else if (isset($productAndProperties2) == TRUE) {
                                            foreach ($productAndProperties2 as $pp3) {
                                                echo '<li>';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12" />';
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width= "12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp3->Value;
                                                }
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </td>

                                <td>
                                    <ul class="values">
                                        <?php
                                        if (isset($productAndProperties8) == TRUE && isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_2]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_2] != 0 && isset($_SESSION[SESSION_INT_PRODUCT_3]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_3] != 0) {
                                            foreach ($productAndProperties8 as $pp3) {
                                                echo '<li>';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12" />';
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width= "12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp3->Value;
                                                }
                                                echo '</li>';
                                            }
                                        } else if (isset($productAndProperties3) == TRUE) {
                                            foreach ($productAndProperties3 as $pp3) {
                                                echo '<li>';
                                                if (trim($pp3->Value) == "دارد") {
                                                    echo '<img src="Template/Images/Exist.png" width= "12" height = "12" />';
                                                } elseif (trim($pp3->Value) == "ندارد") {
                                                    echo '<img src="Template/Images/NotExist.png" width= "12" height = "12" />';
                                                } else {
                                                    echo '<span class="technicalspecs-value">';
                                                    echo $pp3->Value;
                                                }
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
require_once 'Template/bottom.php';
