<?php
require_once 'Template/top.php';
$_SESSION[SESSION_STRING_REGISTER_ERROR] = "";
$_SESSION[SESSION_STRING_REGISTER_ERROR_2] = "";
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CommentDataSource.inc';
$comment = new CommentDataSource();
$comment->open();
$c1 = $comment->FindOneCommentBasedOnId($_GET['commentId']);
?>
    <title><?php echo $settings->SiteName; ?> - جواب پرسش</title>
<script language="javascript">
    $(document).ready(
            function() {
                $("#pikame").PikaChoose({carousel: true, carouselOptions: {wrap: 'circular'}});
            });
</script>
<script src="Template/Scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->
<?php include_once 'Template/menu.php'; ?>
<div class="product-view">
    <!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->        
    <div id="faq" class="faq">
        <h3 class="title">
            <span class="caret-left"></span>
            پاسخ خود را مطرح نمایید
        </h3>
        <!--        <div class="horizontal-line"></div>-->
        <div class="faq-list-container">            
            <div class="faq-panel">
                <div class="heading">
                    <span class="header-title">
                        <span class="question-ico"></span>
                        پرسش
                    </span>
                    <time class="time">
                        <?php echo $c1->Date; ?>
                    </time>
                    <span class="auther">
                        <?php echo $c1->Customer->Name . ' ' . $c1->Customer->Family; ?>
                    </span>
                </div>
                <div class="question-body rounr-corner">
                    <?php echo $c1->Value; ?>
                </div>
            </div>
            <div class="space2"></div>
            <form action="Internal Inserting/InsertComment.php" method="post">
                <textarea id="productId" name="value" placeholder="متن پاسخ خود را اینجا بنویسید ..."></textarea>
                <input type="hidden" id="productId" name="productId" value="<?php echo $_GET['productId']; ?>" />
                <input type="hidden" id="commentId" name="commentId" value="<?php echo $_GET['commentId']; ?>" />
                <input type="hidden" id="customer" name="customer" value="<?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>"/>
                <div class="button-container">                        
                    <input type="submit" class="btn" value="ثبت پاسخ"/>
                    <div class="role">                    
                        <span>با انتخاب دکمه “ثبت پاسخ”، موافقت خود را با قوانین انتشار محتوا در فروشگاه اعلام می کنم.</span>
                    </div>
                </div>
            </form>
        </div>    
        </div>    
    </div>
    <div class="space3"></div>
    <?php
    require_once 'Template/bottom.php';
    