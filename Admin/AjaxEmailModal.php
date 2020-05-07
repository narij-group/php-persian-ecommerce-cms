<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$c = new CustomerDataSource();
$c->open();
$customer = $c->FindOneCustomerBasedOnId($_POST['customerId']);
$c->close();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span
                aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
    <h4 class="modal-title"><i class="fa fa-envelope text-danger m-xs"></i>ارسال ایمیل
    </h4>
    <div class="customer-info">
        <div>
            <i class="fa fa-user text-primary m-xs"></i>
            <?php
            echo $customer->Name . " " . $customer->Family . "  " . $customer->Email;
            ?>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="inputs">
        <input type="hidden" value="<?php echo $_POST['customerId']; ?>" id="customerId" name="customerId"/>
        <textarea required placeholder="متن ایمیل..." id="txt" class="form-control input-sm m-b-xs" name="txt" style="height: 85px"></textarea>
        <script>
            $(document).ready(function () {
                $('#SendEmail').click(function () {
                    $.ajax({
                        url: 'AjaxSendCustomEmail.php',
                        type: 'POST',
                        data: {text: $("#txt").val(), email: "<?php echo $customer->Email; ?>"},
                        success: function () {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                positionClass: 'toast-top-left',
                                timeOut: 5000
                            };
                            toastr.success('ایمیل با موفقیت ارسال شد!', 'ایمیل');

//                    $("#success-msg").fadeIn(250);
//                    setTimeout(function () {
//                        $("#success-msg").fadeOut(250);
//                    }, 7000);
                        }
                    });
                    $('#email-modal').fadeOut(250);
                    $('#modalback').fadeOut(500);
                });
            });
        </script>
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="SendEmail" class="SendEmail btn btn-primary" style="width: 100%" data-dismiss="modal">ارسال ایمیل </button>
</div>