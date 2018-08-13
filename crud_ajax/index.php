<?php include 'server.php'; ?>

<html>
 <head>
  <title>48 Degree Celcius Exam</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="style.css">
  


 </head>
 <body>






 <div class="container box" >
<?php  if (isset($_SESSION['email'])) : ?>
<p>Welcome:</p><h2> <strong><?php echo $_SESSION['email']; ?></strong></h2>

<div align="right">
<button type="submit" class="btn btn-lg" name="login_user" style="background: black;"><a href="login.php?logout='1'" style="color: red;">logout</a></button>
 </div>
 <?php endif ?>
</div>




  <div class="container box" >
   <h1 align="center">Contact Information</h1>
   <div class="table-responsive">
   <br />
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-info">Add</button>
    </div>

    <table id="add_contact" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th style="background: grey;">Name</th>
       <th style="background: grey;">Company</th>
       <th style="background: grey;">Contact</th>
       <th style="background: grey;">Email</th>
       <th style="background: grey;">Action</th>
      </tr>
     </thead>
    </table>
<hr>

    <div id="alert_message"></div>

<hr>
    <table id="user_data" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th style="background: green;">Name</th>
       <th style="background: green;">Company</th>
       <th style="background: green;">Contact</th>
       <th style="background: green;">Email</th>
       <th style="background: green;">Action</th>
      </tr>
     </thead>
    </table>
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >

 $(document).ready(function(){
  
  fetch_data();

  function fetch_data()
  {
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
     url:"fetch.php",
     type:"POST"
    }
   });
  }
  
  function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update.php",   // UPDATE contact --------------------------------------
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 2000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
  });


  
  $('#add').click(function(){
   var html = '<tr>';
   html += '<td contenteditable id="data1"></td>';
   html += '<td contenteditable id="data2"></td>';
   html += '<td contenteditable id="data3"></td>';
   html += '<td contenteditable id="data4"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';
   $('#add_contact').prepend(html);
  });

  
  $(document).on('click', '#insert', function(){
   var name = $('#data1').text();
   var company = $('#data2').text();
   var contact = $('#data3').text();
   var email = $('#data4').text();
   if(name != '' && company != '' && contact != '' && email != '')
   {
    $.ajax({
     url:"insert.php",    // ADD contact --------------------------------------
     method:"POST",
     data:{name:name, company:company, contact:contact, email:email},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });
  




  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"delete.php",    // DELETE contact  --------------------------------------
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 3000);
   }
  });
 });
</script>
