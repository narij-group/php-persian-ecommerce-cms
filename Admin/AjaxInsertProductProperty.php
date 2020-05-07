<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span
                aria-hidden="true" id="closeModal1">&times;</span><span
                class="sr-only">Close</span></button>
    <h4 class="modal-title">افزودن ویژگی جدید</h4>
</div>
<div class="modal-body">
    <div class="alert alert-success">
        آموزش: اگر می خواهید خاصیت در هنگام افزودن محصول به صورت دلخواه انتخاب شود تنها '-' در محتوا بنویسید.
    </div>
    <div class="alert alert-success">
        آموزش 2: اگر می خواهید خاصیت به صورت گزینه ای نمایش داده شود، گزینه ها را با '-' جدا کنید.
    </div>

    <div class="">
        <form id="form11">
            <input type="hidden" value="<?php echo $_POST['suppergroup']; ?>" id="group" name="group"/>
            <fieldset class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-12 control-label">
                        نام :
                    </label>
                    <div class="col-sm-12">
                        <input type="Text" id='name' placeholder="نام ویژگی را وارد کنید..." name='name'
                               class="form-control input-sm m-b-xs" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12 control-label">
                        محتوا :
                    </label>
                    <div class="col-sm-12">
                        <input type="Text" id='value' placeholder="طبق آموزش در بالا عمل کنید..." name='value'
                               class="form-control input-sm m-b-xs" value=""/>
                    </div>
                </div>
            </fieldset>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">بستن
    </button>
    <button type="button" id="insert-pp" class="btn btn-primary"
            data-dismiss="modal">تایید
    </button>
</div>
</form>

<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#e-close2").click(function () {
//            $("#pp-modal").fadeOut(250);
            $('#closeModal1').click(function(){return true;}).click();
        });

        $("#insert-pp").click(function () {
//            $("#pp-modal").fadeOut(250);
            $('#closeModal1').click(function(){return true;}).click();
            $.ajax({
                url: 'AjaxInsertPP.php',
                type: 'POST',
                data: $('#form11').serialize(),
                success: function () {
                    $.ajax({
                        url: 'AjaxProductAndPropertiesLoad.php',
                        type: 'POST',
                        data: {product: <?php echo $_POST['product'];?> },
                        success: function (result) {
                            $("#properties").html(result)
                        }
                    });
//                    $("#p-info").fadeOut(250);
//                    $('#closeModal2').click(function(){return true;}).click();
//                    $("#modalback").fadeOut(250);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        timeOut: 5000
                    };
                    toastr.success('ویژگی جدید با موفقیت افزوده شد!', 'پیغام');
//                    $("#pp-success-msg").fadeIn(250);
//                    setTimeout(function () {
//                        $("#pp-success-msg").fadeOut(250);
//                    }, 7000);
                }
            });
        });
    });
</script>