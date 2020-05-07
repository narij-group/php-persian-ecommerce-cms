<?php

require_once __DIR__ .DIRECTORY_SEPARATOR . "ClassesEx/datasource/ProductDataSource.inc";
require_once __DIR__ .DIRECTORY_SEPARATOR .  "ClassesEx/datasource/SupperGroupDataSource.inc";


?>
<div class="seb">
    <table>
        <tr>
            <td>
                <div class="groups">
                    <div class="Title">گروه ها</div>
                    <div class="searched">
                        <ul>
                            <?php
                            if (isset($_POST['string'])) {
                                //echo  $_POST['string'];
                                $sgroup = new SupperGroupDataSource();
                                $sgroup ->open();
                                $sgroups = $sgroup->SearchSupperGroups($_POST['string']);
                                foreach ($sgroups as $s) {
                                    echo "<li><a href='Products.php?spgroup=$s->SupperGroupId'>" . "گروه " . "$s->Name</a></li>";
                                }
                                if ($sgroups == null) {
                                    echo "<li>موردی پیدا نشد!</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="products">
                    <div class="Title">محصولات</div>
                    <div class="scroll">
                        <?php
                        if (isset($_POST['string'])) {
                            $product = new ProductDataSource();
                            $product ->open();
                            $products = $product->SearchProducts($_POST['string']);
                            foreach ($products as $p) {
                                ?>
                                <div class="searched">
                                    <a href="<?php echo "Post.php?id=$p->ProductId"; ?>"
                                       onclick="fillme('<?php echo $p->LatinName . " " . $p->Name; ?>');">
                                        <div class="user_div">
                                            <img src="<?php echo $p->Image; ?>" style="border-radius:5px;"/>
                                            <div class="pname"><?php
                                                echo $p->Name;
                                                echo '</div><div class="lname">';
                                                echo $p->LatinName;
                                                ?></div>
                                            <br>
                                            <div class="cntry"></div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        if ($products == null) {
                            ?>
                            <div class="no_data">محصولی با این نام وجود ندارد !</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </td>
            <!--            <td>-->
            <!--                <div class="videos">-->
            <!--                    <div class="Title">ویدیو ها</div>-->
            <!--                    <div class="searched">-->
            <!--                        <a href="#">-->
            <!--                            <div class="user_div">-->
            <!--                                <img src="News/1.jpg"/>-->
            <!--                                <span class="tag">10:17</span>-->
            <!--                                <span>بازدید : 1170</span>-->
            <!--                                <div class="pname">مهم ترین مزیت این امکان اما، گسترش زمینه ارتباط و تعامل...</div>-->
            <!--                            </div>-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                    <div class="searched">-->
            <!--                        <a href="#">-->
            <!--                            <div class="user_div">-->
            <!--                                <img src="News/2.jpg"/>-->
            <!--                                <span class="tag">27:01</span>-->
            <!--                                <span>بازدید : 4900</span>-->
            <!--                                <div class="pname">محصول محبوب و کاربردی کمپانی August که با نام Smart Lock ...</div>-->
            <!--                            </div>-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                    <div class="searched">-->
            <!--                        <a href="#">-->
            <!--                            <div class="user_div">-->
            <!--                                <img src="News/3.jpg"/>-->
            <!--                                <span class="tag">27:01</span>-->
            <!--                                <span>بازدید : 4900</span>-->
            <!--                                <div class="pname">سرویس خدمات خانه ی هوشمند Misfit قرار است به زودی ...</div>-->
            <!--                            </div>-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                    <div class="searched">-->
            <!--                        <a href="#">-->
            <!--                            <div class="user_div">-->
            <!--                                <img src="News/4.jpg"/>-->
            <!--                                <span class="tag">27:01</span>-->
            <!--                                <span>بازدید : 4900</span>-->
            <!--                                <div class="pname"> دستگاهی که با شنیدن صدای آب می تواند میزان مصرف آ ...</div>-->
            <!--                            </div>-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="news">-->
            <!--                    <div class="Title">خبر ها</div>-->
            <!--                    <div class="searched">-->
            <!--                        <ul>-->
            <!--                            <li><a href="#"><h3>Wi-Vi نام تکنولوژی جدیدی است که به افراد این امکان را می‌دهد تا-->
            <!--                                        با...</h3></a></li>-->
            <!--                            <li><a href="#"><h3>شرکت Owlet اخیرا جوراب هوشمندی به بازار ارائه کرده است...</h3></a></li>-->
            <!--                            <li><a href="#"><h3>فرآیند ارسال داده‌ها در فناوری اینترنت اشیاء نیازی به تعامل-->
            <!--                                        «انسان...</h3></a></li>-->
            <!--                            <li><a href="#"><h3>کانکت مکعبی کوچک و سفید رنگ است که به یکی از پریز های...</h3></a></li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </td>-->
        </tr>
    </table>
</div>
  