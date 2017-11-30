<?php echo $header; ?><?php echo $column_left;
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

$token = $_GET['token'];

?>
<link href="view/stylesheet/mysklad.css" rel="stylesheet">

<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<div id="content" style="margin-left:50px;">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
       <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo "Настройка модуля"; ?></h3>
      </div>
      <div class="panel-body">
        <div id="tabs" class="htabs">
          <a href="#tab-general"><?php echo $text_tab_general; ?></a>
          <a href="#tab-synchron"><?php echo $text_tab_synchron; ?></a>
          <a href="#tab-order"><?php echo $text_tab_order; ?></a>
          <a href="#tab-author"><?php echo $text_tab_author; ?></a>
        </div>
        <!--
        Начало формы
          !-->
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">

          <div id="tab-general">
            <table class="form">
              <tr>
                <td><?php echo $entry_username; ?></td>
                <td><input name="moyskladoc21cloud_username" type="text" value="<?php echo $moyskladoc21cloud_username; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_password; ?></td>
                <td><input name="moyskladoc21cloud_password" type="password" value="<?php echo $moyskladoc21cloud_password; ?>" /></td>
              </tr>
              <tr>
                <td><button type="submit"  class="btn btn-primary"><?php echo $button_save; ?></button></td>
                <td></td>
              </tr>
            </table>
          </div>
          <div id="tab-synchron">
            <table class="form">
 
              <tr>
                <td>
                  <?php echo $entry_download; ?>
                  <div class="diapason">
                    <input type="text" name="ot" class="ot" value="0"> -
                    <input type="text" name="do" class="kolichestvo" value="300">
                  </div>
                </td>
                <td>
                  <a id="button-downoload" class="button"><?php echo $button_downoload; ?></a>
                  <div class="diapason_text">
                    <p>
                      <?=$diapason_text;?>
                    </p>
                  </div>
                </td>

              </tr>
            </table>
          </div>  
 
          <div id="tab-order">
            <table class="form">
              <tr>
                <td><?php echo $entry_order_status; ?></td>
                <td>
                  <select name="moyskladoc21cloud_order_status">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <option value="<?php echo $order_status['order_status_id'];?>" <?php echo ($myskladoc21_order_status == $order_status['order_status_id'])? 'selected' : '' ;?>><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>

   </table>
          </div>
          <div id="tab-author">
             <div class="author">
               <p>Created by: <a href="http://isyms.ru/">Artur Legusha</a></p>
             </div>
            </table>
          </div>
 </form>

        <!--
        Конец формы
          !-->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
  $('#tabs a').tabs();
  //--></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#button-downoload').click(function(){
      var ot_diapason = $('.ot').val();
      var kolichestvo_diapason = $('.kolichestvo').val();

       if (kolichestvo_diapason > 301){
        alert ("Error");
      }else{
        $.ajax({
          url : 'index.php?route=module/moyskladoc21cloud/download&token=<?php echo $token;?>',
          type : 'post',
          dataType:'text',
          data :{
            ot: ot_diapason,
            kolichestvo: kolichestvo_diapason
          },
          success:function(data){
            location.href = data;

          },

        });
      }


    });
});
</script>
<?php echo $footer; ?>