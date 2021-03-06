<?php
  session_start();
  
  error_reporting(0);
  //Server Credentials
  $MyServerName = "localhost";
  $MyUserName = "root";
  $MyPassword = "";
  //Database
  $MyDBName = 'chem_glasswares';
  $MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
  
  include("verify.php");
?>
<html>
<head>
  <title>Home: UPB Glasswares and Chemicals Inventory</title>
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <?php 'loading head';include("head.php"); ?>
  <script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>
  <link rel="stylesheet" href="datatables/DataTables/css/dataTables.bootstrap4.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/typeahead.js"></script>
  <link rel="stylesheet" type="text/css" href="css/typeahead.css">
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatables/DataTables/js/dataTables.bootstrap4.js"></script>
</head>
<body  style="z-index: -10000:">
  <div class="container">
        <h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Borrower's Form</h1>
        <p class="text-center">Required fields are indicated by *</p>
        <div class="container" style="padding: 20px; margin-bottom: 50px; border-radius: 10px; background-color: #edeef2; border:2px solid #dbdbdb;">

          <form  action="bprocess.php" target="_self" method="POST">
          <div class="form-group">
            <label for="borrowerid">Borrower ID: </label>
            <input class="form-control" id="borrowerid" autocomplete="off" value="<?php $MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName); $result = mysqli_query($MyConnection,"SELECT MAX(borrower_id) AS max FROM borrower"); $row = mysqli_fetch_array($result, MYSQLI_NUM); echo $row[0]+1;?>" name = "borrower_id" readonly="readonly"/>
          </div>
          
          <label class="try" for="members">Group Members: </label>
          <div id="namegrp">
            <div class="row grpmem" style="padding: 5px; margin: auto;">
              <div class="col-md-4">
                <input type="text" autocomplete="off" name="sid[]" class="form-control" placeholder="Student ID (20XX-XXXXX)*" maxlength="10" required="true">
              </div>
              <div class="col-md-4">
                <input type="text" autocomplete="off" name="lname[]" class="form-control" placeholder="Last Name*" required="true">
              </div>
              <div class="col-md-3">
                <input type="text" autocomplete="off" name="fname[]" class="form-control" placeholder="First Name*" required="true">
              </div>
              <button class="btn btn-danger remover" form="" style="cursor: pointer; visibility: hidden; text-align: right;"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          
          <center><button type="button" class="btn btn-info" id="add-row" name="add-row" onmouseover="" style="cursor: pointer; margin-top: 20px;">Add Member</button></center>
          
          <label for="instruct">Instructor's Info:</label>
          <div class="row" id="instruct" style="margin: auto; padding: 5px;">
            <div class="col-md-6">
              <input type="text" autocomplete="off" id="prof" class="form-control" placeholder="Name of Professor" name="professor">
            </div>
            <div class="col-md-5">
              <input type="text" autocomplete="off" id="subj" class="form-control" placeholder="Name of Subject*" required="true" name="subject">
            </div>
          </div>

          <?php
            $itquery=mysqli_query($MyConnection,"SELECT * FROM chemicals WHERE Quantity_Available_ml>0 OR Quantity_Available_mg>0");
            $it=array();
            $chem=array();
            $glass=array();
            $qchemml=array();
            $qchemmg=array();
            $qglass=array();

            while ($row=$itquery->fetch_assoc()) {
              array_push($it, $row['Name']);
              array_push($chem, $row['Name']);
              array_push($qchemml, $row['Quantity_Available_ml']);
              array_push($qchemmg, $row['Quantity_Available_mg']);
            }

            $itquery=mysqli_query($MyConnection,"SELECT * FROM glasswares WHERE Quantity_Available>0");
            while ($row=$itquery->fetch_assoc()) {
              array_push($it, $row['Name']);
              array_push($glass, $row['Name']);
              array_push($qglass, $row['Quantity_Available']);
            }

           

          ?>

          <label for="item" style="padding-top: 20px;">Items:</label>
          <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>Note:</strong><br/>-If the item field does not show any suggestions, then the item is <strong>UNAVAILABLE</strong>.</p>
          </div>
          <div class="row try2" style="margin-top: 25px;">
              <div class="col-md-6"><center>Item</center></div>
              <div class="col-md-4"><center>Quantity</center></div>
          </div>
          <div class="container-fluid" id="clonegrp">
            <div class="row grpit" style="padding: 5px; margin: auto;">
            <div class="col-md-6 myItems">
              <input type="text" name="it[]" class="form-control" autocomplete="off" id="item" placeholder="Chemical/Equipment*" required="true" style="background-color: white !important;"> 
            </div>
            <div class="col-md-2">
              <input autocomplete="off" type="text" name="amount[]" class="form-control" placeholder="Amount*" required="true">
            </div>
            /<div class="col-md-2">
              <input autocomplete="off" type="text" class="form-control" name="max[]" id="max" placeholder="Max" readonly="readonly">
            </div>
            <div class="col-md-1">
              <input autocomplete="off" type="text" class="form-control" id="unit" placeholder="Unit" readonly="readonly" name="unit[]">
            </div>
            <button class="btn btn-danger remover2" form="" style="float:right; cursor: pointer; visibility: hidden;"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <center><button type="button" class="btn btn-info" id="add-item" name="add-item" onmouseover="" style="cursor: pointer; margin-top: 20px; text-align: right;">Add Item</button></center>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success btn-lg btn-block" id="confirm" data-toggle="modal" data-target="#myModal" style="margin: auto; margin-top: 60px; cursor: pointer;">
            Confirm
          </button>

          <!-- Modal -->
          <div class="modal" id="myModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered w3-animate-bottom" style="max-width: 1000px !important;">
              <div class="modal-content" style="border-radius: 10px; padding: 20px;">
                <div class="modal-header" style="background-color: white; color: black; text-align: center;">
                  <h3 style="padding: 8px;"><strong>Confirm Credentials</strong></h3>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-5">
                        <strong>Borrower ID:</strong>
                      </div>
                      <div class="col-sm-5">
                        
                      </div>
                      <div class="w-100"></div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: white; color: black;">
                  <div class="text-center" id="footmsg" style="float: left; text-align: left;">
                    <p>Are you sure you want to submit?</p>
                  </div>
                  <span style="width: 20px;"></span>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button submit" class="btn btn-success" id="submitter" style="cursor: pointer;">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
 
  </div>
  <?php include("footer.php") ?>
</body>
      
</html>

<script type="text/javascript">

  $(document).ready(function() {
      var itarr= <?php echo json_encode($it)?>;
      var chem= <?php echo json_encode($chem)?>;
      var glass= <?php echo json_encode($glass)?>;
      var qchemml= <?php echo json_encode($qchemml)?>;
      var qchemmg= <?php echo json_encode($qchemmg)?>;
      var qglass= <?php echo json_encode($qglass)?>;

      var itarr = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: itarr
      });

      $('input[name^="it"]').typeahead({
        hint:true,
        highlight:true,
        minLength:1
      },{
        name: 'itarr',
        source: itarr
      }).on('typeahead:selected', function(event) {
        event.preventDefault();
        var itarr= <?php echo json_encode($it)?>;
        var chem= <?php echo json_encode($chem)?>;
        var glass= <?php echo json_encode($glass)?>;
        var qchemml= <?php echo json_encode($qchemml)?>;
        var qchemmg= <?php echo json_encode($qchemmg)?>;
        var qglass= <?php echo json_encode($qglass)?>;
        for (var i = 0; i < itarr.length; i++) {
          if (chem[i]==$(this).val()) {
            if (qchemml[i]!=null) {
              $(this).closest('.grpit').find('#max').val(qchemml[i]);
              $(this).closest('.grpit').find('#unit').val('ml');
              break;
            }else{
              $(this).closest('.grpit').find('#max').val(qchemmg[i]);
              $(this).closest('.grpit').find('#unit').val('mg');
              break;
            }
          }

          if (glass[i]==$(this).val()) {
              $(this).closest('.grpit').find('#max').val(qglass[i]);
              $(this).closest('.grpit').find('#unit').val('pc/s');
          }
          
        }
      });

      $("#confirm").click(function(event) {
        modbod();
      });
  });

  jQuery(function($){
    var $button = $('#add-row'),
    $row = $('.grpmem').clone();
    var $try=$('#namegrp');
    $button.click(function(){
        $row.clone().appendTo( $try ).on('keypress', function(event) {
        var val=$(this).closest('.grpmem').find('input[name^="sid"]').val();
        val= val.replace("/-/g","");
        if (val.length == 4) {
          $(this).closest('.grpmem').find('input[name^="sid"]').val(val+"-");
        };
        $('.remover').css({
          visibility: ''
        });
        $('.remover').first().css({
          visibility: 'hidden'
        });
        $('.grpmem').on('click','.remover', function() {
          $(this).closest('.grpmem').remove();
        });
  });
    });



    var itarr= <?php echo json_encode($it)?>;

      var itarr = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: itarr
      });
    var $button2=$('#add-item'),
        $row2=$('.grpit').clone();
        $try2=$('#clonegrp');
    $button2.click(function() {
      $row2.clone().appendTo($try2).find('input[name^="it"]').typeahead({
        hint:true,
        highlight:true,
        minLength:1
      },{
        name: 'itarr',
        source: itarr,
        afterSelect: function(item){
          $(this).focus();
        }
      }).on('typeahead:selected', function(event) {
        event.preventDefault();
        var itarr= <?php echo json_encode($it)?>;
        var chem= <?php echo json_encode($chem)?>;
        var glass= <?php echo json_encode($glass)?>;
        var qchemml= <?php echo json_encode($qchemml)?>;
        var qchemmg= <?php echo json_encode($qchemmg)?>;
        var qglass= <?php echo json_encode($qglass)?>;
        for (var i = 0; i < itarr.length; i++) {
          if (chem[i]==$(this).val()) {
            if (qchemml[i]!=null) {
              $(this).closest('.grpit').find('#max').val(qchemml[i]);
              $(this).closest('.grpit').find('#unit').val('ml');
              break;
            }else{
              $(this).closest('.grpit').find('#max').val(qchemmg[i]);
              $(this).closest('.grpit').find('#unit').val('mg');
              break;
            }
          }

          if (glass[i]==$(this).val()) {
              $(this).closest('.grpit').find('#max').val(qglass[i]);
              $(this).closest('.grpit').find('#unit').val('pc/s');
          }
          
        }
      }).css('background-color', 'white');
      $('.remover2').css({
        visibility: ''
      });
      $('.remover2').first().css({
          visibility: 'hidden'
        });
      $('.grpit').on('click','.remover2', function() {
          $(this).closest('.grpit').remove();
      });

    });
    
});
  

  $(document).on('keypress', function(event) {
    var key=event.which;
    if (key==13) {
      event.preventDefault();
      var itarr= <?php echo json_encode($it)?>;
      var chem= <?php echo json_encode($chem)?>;
      var glass= <?php echo json_encode($glass)?>;
      var qchemml= <?php echo json_encode($qchemml)?>;
      var qchemmg= <?php echo json_encode($qchemmg)?>;
      var qglass= <?php echo json_encode($qglass)?>;

      var it=new Array();
      var max=new Array();
      ctr=0;
      $('input[name^="it"]').each(function() {
           it[ctr]=$(this).val();
           ctr++;
      });
      ctr=0;
      for (var i = 0; i < it.length; i++) {
        var flag=0;
        for (var j = 0; j < chem.length; j++) {
          if (it[i]==chem[j]) {
            if (qchemml[j]==null) {
              max[ctr]=qchemmg[j];
              ctr++;
            }else{
              max[ctr]==qchemml[j];
              ctr++;
            }
            flag=1;
            break;
          }
        }

        for (var j = 0; j < glass.length && flag==0; j++) {
          if (it[i]==glass[j]) {
            max[ctr]=qglass[j];
            ctr++;
            break;
          }

          if (i==it.length-1 && j==glass.length-1 && it[i]!=glass[j]) {
            alert('Item "'+it[i]+'" is either unavailable or not in the inventory.');
          }
        }
      }

      $('#myModal').modal('show');
      modbod();
    }
  });


  $('input[name^="sid"]').on('keypress', function(event) {
    var val=$(this).closest('.grpmem').find('input[name^="sid"]').val();
    val= val.replace("/-/g","");
    if (val.length == 4) {
      $(this).closest('.grpmem').find('input[name^="sid"]').val(val+"-");
    }
  });

  function modbod(){
        $(".modal-body").html("<div class='row' id='inner'></div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Borrower Id: </strong>"+$("#borrowerid").val()+"</div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Group Members: </strong></div>");
        
        //GATEHRING ALL NAME INPUTS
        var id=new Array();
        var lname=new Array();
        var fname=new Array();
        var ctr=0;
        $('input[name^="sid"]').each(function() {
            id[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="lname"]').each(function() {
            lname[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="fname"]').each(function() {
            fname[ctr]=$(this).val();
            ctr++;
        });
        for (var i = 0; i < id.length; i++) {
          $("#inner").append("<div class='col-sm-7 text-center'><strong>"+lname[i]+", </strong>"+fname[i]+"</div><div class='col-sm-5 text-center'><strong>"+id[i]+"</strong></div>");
        }
        //////////////////////////////////////////////////////////
        
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Subject: </strong>"+$("#subj").val()+" ("+$("#prof").val()+")</div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Items: </strong></div>");

        //GATEHRING ALL ITEM INPUTS
        var it=new Array();
        var amt=new Array();
        var max=new Array();
        var unit=new Array();
        ctr=0;
        $('input[name^="it"]').each(function() {
            it[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="amount"]').each(function(){
            amt[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="max"]').each(function() {
            max[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="unit"]').each(function() {
            unit[ctr]=$(this).val();
            ctr++;
        });
        for (var i = 0; i < it.length; i++) {
          $("#inner").append("<div class='col-sm-7 text-center'>"+it[i]+"</div><div class='col-sm-1 text-center'>-</div><div class='col-sm-4 text-center'><strong>"+amt[i]+"</strong> "+unit[i]+"</div>");
        }
        //////////////////////////////////////////////////////////

        //ERROR CHECKING
        var flag=0;
        var subj=$("#subj").val();
        if(subj==""){
          flag=1;
        }

        for (var i = 0; i < id.length; i++) {
          if (flag==1){
            break;
          }
          if (id[i]==""){
            flag=1;
            break;
          }
          if (lname[i]==""){
            flag=1;
            break;
          }
          if(fname[i]==""){
            flag=1;
            break;
          }
        }
        for (var i = 0; i < it.length; i++) {
          if (it[i]==""){
            flag=1;
            break;
          }
          if (amt[i]=="") {
            flag=1;
            break;
          }
          if (max[i]=="") {
            flag=1;
            break;
          }
          if (unit[i]=="") {
            flag=1;
            break;
          }
          curramt=parseFloat(amt[i]);
          currmax=parseFloat(max[i]);
          if (curramt>currmax) {
            flag=1;
            break;
          }
        }

        //CHECK IF ALL SID IS A NUMBER
        //CHECK IF AMT IS A NUMBER
        //CHECK IF AMT EXCEEDS MAX

        if (flag==1) {
          $("#footmsg").html("");
          $("#inner").html("Error: Some input fields have invalid values. Kindly recheck.");
          $("#submitter").attr('disabled', 'disabled');
          flag=0;
        }else{
          $("#footmsg").html("Are you sure you want to submit?");
          flag=0;
          $("#submitter").prop('disabled', false);
        }
  }

  $('#clonegrp').on('keyup','#item', function(e) {
    if ($(this).closest('.grpit').find('#item').val()=='') {
      $(this).closest('.grpit').find('#max').val('');
      $(this).closest('.grpit').find('#unit').val('');
    }else{
      var itarr= <?php echo json_encode($it)?>;
      var chem= <?php echo json_encode($chem)?>;
      var glass= <?php echo json_encode($glass)?>;
      var qchemml= <?php echo json_encode($qchemml)?>;
      var qchemmg= <?php echo json_encode($qchemmg)?>;
      var qglass= <?php echo json_encode($qglass)?>;
      for (var i = 0; i < itarr.length; i++) {
        if (chem[i]==$(this).closest('.grpit').find('#item').val() ) {
          if (qchemml[i]!=null) {
            $(this).closest('.grpit').find('#max').val(qchemml[i]);
            $(this).closest('.grpit').find('#unit').val('ml');
            break;
          }else{
            $(this).closest('.grpit').find('#max').val(qchemmg[i]);
            $(this).closest('.grpit').find('#unit').val('mg');
            break;
          }
        }

        if (glass[i]==$(this).closest('.grpit').find('#item').val() ) {
            $(this).closest('.grpit').find('#max').val(qglass[i]);
            $(this).closest('.grpit').find('#unit').val('pc/s');
        }
        
      }
      
    }
    
  });
</script>

<style type="text/css">
  label{
    margin-top: 10px;
  }
</style>